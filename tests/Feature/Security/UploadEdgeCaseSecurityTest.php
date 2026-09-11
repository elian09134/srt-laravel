<?php

namespace Tests\Feature\Security;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Negative / edge-case scenarios on top of FileUploadSecurityTest (DIGI-47 audit).
 */
class UploadEdgeCaseSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function pdf(): string
    {
        return "%PDF-1.4\n1 0 obj<</Type/Catalog>>endobj\ntrailer<</Size 4/Root 1 0 R>>\n%%EOF";
    }

    protected function jpeg(): string
    {
        $im = imagecreatetruecolor(10, 10);
        ob_start();
        imagejpeg($im);
        $content = ob_get_clean();
        imagedestroy($im);

        return $content;
    }

    protected function png(): string
    {
        $im = imagecreatetruecolor(10, 10);
        ob_start();
        imagepng($im);
        $content = ob_get_clean();
        imagedestroy($im);

        return $content;
    }

    protected function gif(): string
    {
        $im = imagecreatetruecolor(10, 10);
        ob_start();
        imagegif($im);
        $content = ob_get_clean();
        imagedestroy($im);

        return $content;
    }

    protected function registration(array $override = []): array
    {
        return array_merge([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'nickname' => 'Budi',
            'phone_number' => '081234567890',
            'date_of_birth' => '1995-05-15',
            'about_me' => 'Saya pelamar kerja profesional.',
            'education_level' => 'S1',
            'institution' => 'Universitas Indonesia',
            'major' => 'Teknik Informatika',
            'referral_source' => 'LinkedIn',
            'expected_salary' => 8000000,
            'cv' => UploadedFile::fake()->createWithContent('cv.pdf', $this->pdf()),
            'formal_photo' => UploadedFile::fake()->createWithContent('formal.jpg', $this->jpeg()),
            'ktp' => UploadedFile::fake()->createWithContent('ktp.png', $this->png()),
            'kk' => UploadedFile::fake()->createWithContent('kk.jpg', $this->jpeg()),
            'ijazah' => UploadedFile::fake()->createWithContent('ijazah.pdf', $this->pdf()),
        ], $override);
    }

    /**
     * @dataProvider maliciousCvProvider
     */
    public function test_rejects_malicious_cv_filenames_and_content(string $name, string $content): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $data = $this->registration([
            'cv' => UploadedFile::fake()->createWithContent($name, $content),
        ]);

        $this->post('/register', $data)->assertSessionHasErrors('cv');
        $this->assertDatabaseMissing('users', ['email' => 'budi@example.com']);
    }

    public static function maliciousCvProvider(): array
    {
        $pdf = "%PDF-1.4\n1 0 obj<</Type/Catalog>>endobj\n%%EOF";

        return [
            'apache config override' => ['.htaccess', "AddType application/x-httpd-php .pdf\n"],
            'uppercase php extension' => ['SHELL.PHP', '<?php system($_GET["c"]); ?>'],
            'phtml handler' => ['shell.phtml', '<?php system($_GET["c"]); ?>'],
            'phar archive' => ['shell.phar', '<?php system($_GET["c"]); ?>'],
            'trailing dot after php' => ['shell.php.', '<?php system($_GET["c"]); ?>'],
            'html smuggled as pdf' => ['cv.pdf', '<html><script>alert(1)</script></html>'],
            'short open tag webshell in pdf' => ['cv.pdf', "%PDF-1.4\n<? system(\$_GET['c']); ?>\n%%EOF"],
        ];
    }

    public function test_path_traversal_filename_is_neutralised_by_uuid_naming(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $this->post('/register', $this->registration([
            'cv' => UploadedFile::fake()->createWithContent('../../../../public/index.pdf', $this->pdf()),
        ]))->assertRedirect();

        $path = \App\Models\User::where('email', 'budi@example.com')->first()->profile->cv_path;
        $this->assertMatchesRegularExpression('/^cvs\/[0-9a-f\-]{36}\.pdf$/', $path);
    }

    public function test_legitimate_pdf_with_xmp_metadata_is_accepted(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        // Adobe XMP packets start with `<?xpacket` — must not trip the anti-webshell scanner
        $pdf = "%PDF-1.4\n<?xpacket begin=\"\" id=\"W5M0MpCehiHzreSzNTczkc9d\"?>\n1 0 obj<</Type/Catalog>>endobj\n%%EOF";

        $this->post('/register', $this->registration([
            'cv' => UploadedFile::fake()->createWithContent('cv.pdf', $pdf),
        ]))->assertRedirect();

        $this->assertDatabaseHas('users', ['email' => 'budi@example.com']);
    }

    public function test_rejects_image_whose_content_does_not_match_extension(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        // GIF bytes served under a whitelisted .jpg name
        $this->post('/register', $this->registration([
            'formal_photo' => UploadedFile::fake()->createWithContent('formal.jpg', $this->gif()),
        ]))->assertSessionHasErrors('formal_photo');

        // SVG (scriptable) served under a .png name
        $this->post('/register', $this->registration([
            'ktp' => UploadedFile::fake()->createWithContent('ktp.png', '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>'),
        ]))->assertSessionHasErrors('ktp');
    }

    public function test_rejects_oversized_document(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $this->post('/register', $this->registration([
            'cv' => UploadedFile::fake()->createWithContent('cv.pdf', $this->pdf().str_repeat('A', 3 * 1024 * 1024)),
        ]))->assertSessionHasErrors('cv');
    }

    public function test_accepted_image_is_re_encoded_and_carries_no_appended_payload(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        // EXIF-style comment payload inside an otherwise valid JPEG (no <?php marker)
        $payload = 'PAYLOAD_MARKER_'.'eval(base64_decode(';
        $im = imagecreatetruecolor(10, 10);
        ob_start();
        imagejpeg($im);
        $jpeg = ob_get_clean();
        imagedestroy($im);
        $jpeg = substr($jpeg, 0, 2)."\xFF\xFE".pack('n', strlen($payload) + 2).$payload.substr($jpeg, 2);

        $data = $this->registration([
            'formal_photo' => UploadedFile::fake()->createWithContent('formal.jpg', $jpeg),
        ]);

        $this->post('/register', $data)->assertRedirect();

        $path = \App\Models\User::where('email', 'budi@example.com')->first()->profile->formal_photo_path;
        $this->assertStringNotContainsString('PAYLOAD_MARKER_', Storage::disk('local')->get($path));
    }

    public function test_admin_gallery_upload_is_validated_and_re_encoded(): void
    {
        Storage::fake('public');

        $admin = \App\Models\User::forceCreate([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Polyglot: valid JPEG bytes with an appended webshell
        $this->actingAs($admin)->post(route('admin.images.update'), [
            'gallery_alt_text' => 'Galeri',
            'gallery_image' => UploadedFile::fake()->createWithContent('g.jpg', $this->jpeg().'<?php phpinfo(); ?>'),
        ])->assertSessionHasErrors('gallery_image');

        $this->assertDatabaseCount('gallery', 0);

        $this->actingAs($admin)->post(route('admin.images.update'), [
            'gallery_alt_text' => 'Galeri',
            'gallery_image' => UploadedFile::fake()->createWithContent('g.jpg', $this->jpeg()),
        ])->assertSessionHasNoErrors();

        $gallery = \App\Models\Gallery::first();
        $this->assertMatchesRegularExpression('/^gallery\/[0-9a-f\-]{36}\.jpg$/', $gallery->file_path);
    }

    public function test_site_content_html_is_escaped_on_home_page(): void
    {
        \App\Models\SiteContent::updateOrCreate(
            ['section_name' => 'hero', 'content_key' => 'title'],
            ['content_value' => '<img src=x onerror=alert(1)>Judul']
        );

        $this->get('/')
            ->assertStatus(200)
            ->assertDontSee('<img src=x onerror=alert(1)>', false);
    }
}
