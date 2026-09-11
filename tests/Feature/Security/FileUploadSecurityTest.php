<?php

namespace Tests\Feature\Security;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function getValidPdfContent(): string
    {
        return "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj 2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj 3 0 obj<</Type/Page/MediaBox[0 0 3 3]>>endobj\nxref\n0 4\n0000000009 00000 n\n0000000052 00000 n\n0000000101 00000 n\ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n147\n%%EOF";
    }

    protected function getValidJpegContent(): string
    {
        $im = imagecreatetruecolor(10, 10);
        ob_start();
        imagejpeg($im);
        $content = ob_get_clean();
        imagedestroy($im);
        return $content;
    }

    protected function getValidPngContent(): string
    {
        $im = imagecreatetruecolor(10, 10);
        ob_start();
        imagepng($im);
        $content = ob_get_clean();
        imagedestroy($im);
        return $content;
    }

    protected function getBaseRegistrationData(): array
    {
        return [
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
            'cv' => UploadedFile::fake()->createWithContent('cv.pdf', $this->getValidPdfContent()),
            'formal_photo' => UploadedFile::fake()->createWithContent('formal.jpg', $this->getValidJpegContent()),
            'ktp' => UploadedFile::fake()->createWithContent('ktp.png', $this->getValidPngContent()),
            'kk' => UploadedFile::fake()->createWithContent('kk.jpg', $this->getValidJpegContent()),
            'ijazah' => UploadedFile::fake()->createWithContent('ijazah.pdf', $this->getValidPdfContent()),
        ];
    }

    public function test_rejects_webshell_php_upload(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $data = $this->getBaseRegistrationData();
        $data['cv'] = UploadedFile::fake()->createWithContent('radio.php', '<?php system($_GET["cmd"]); ?>');

        $response = $this->post('/register', $data);
        $response->assertSessionHasErrors('cv');

        $this->assertDatabaseMissing('users', ['email' => 'budi@example.com']);
    }

    public function test_rejects_double_extension_file(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $data = $this->getBaseRegistrationData();
        $data['cv'] = UploadedFile::fake()->createWithContent('cv.php.pdf', $this->getValidPdfContent());

        $response = $this->post('/register', $data);
        $response->assertSessionHasErrors('cv');

        $data['cv'] = UploadedFile::fake()->createWithContent('cv.pdf', $this->getValidPdfContent());
        $data['formal_photo'] = UploadedFile::fake()->createWithContent('photo.php.jpg', $this->getValidJpegContent());

        $response = $this->post('/register', $data);
        $response->assertSessionHasErrors('formal_photo');
    }

    public function test_rejects_fake_pdf_without_magic_bytes(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $data = $this->getBaseRegistrationData();
        $data['cv'] = UploadedFile::fake()->createWithContent('cv.pdf', 'This is not a real PDF file content.');

        $response = $this->post('/register', $data);
        $response->assertSessionHasErrors('cv');
    }

    public function test_rejects_pdf_with_embedded_php_script(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $maliciousPdf = "%PDF-1.4\n1 0 obj<</Type/Catalog>>endobj\n<?php system('whoami'); ?>\n%%EOF";
        $data = $this->getBaseRegistrationData();
        $data['cv'] = UploadedFile::fake()->createWithContent('cv.pdf', $maliciousPdf);

        $response = $this->post('/register', $data);
        $response->assertSessionHasErrors('cv');
    }

    public function test_rejects_polyglot_image_with_php_code(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $polyglotImage = $this->getValidJpegContent().'<?php phpinfo(); ?>';
        $data = $this->getBaseRegistrationData();
        $data['formal_photo'] = UploadedFile::fake()->createWithContent('formal.jpg', $polyglotImage);

        $response = $this->post('/register', $data);
        $response->assertSessionHasErrors('formal_photo');
    }

    public function test_valid_files_are_stored_in_private_storage_with_uuid(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $data = $this->getBaseRegistrationData();

        $response = $this->post('/register', $data);
        $response->assertRedirect();

        $user = User::where('email', 'budi@example.com')->first();
        $this->assertNotNull($user);

        $profile = $user->profile;
        $this->assertNotNull($profile);

        // Verify stored in private local disk
        $this->assertTrue(Storage::disk('local')->exists($profile->cv_path));
        $this->assertTrue(Storage::disk('local')->exists($profile->formal_photo_path));
        $this->assertTrue(Storage::disk('local')->exists($profile->ktp_path));
        $this->assertTrue(Storage::disk('local')->exists($profile->kk_path));
        $this->assertTrue(Storage::disk('local')->exists($profile->ijazah_path));

        // Verify NOT stored in public disk
        $this->assertFalse(Storage::disk('public')->exists($profile->cv_path));
        $this->assertFalse(Storage::disk('public')->exists($profile->formal_photo_path));
        $this->assertFalse(Storage::disk('public')->exists($profile->ktp_path));

        // Verify pure UUID filename without user original filename
        $this->assertMatchesRegularExpression('/^cvs\/[0-9a-f\-]{36}\.pdf$/', $profile->cv_path);
        $this->assertMatchesRegularExpression('/^formal_photos\/[0-9a-f\-]{36}\.jpg$/', $profile->formal_photo_path);
    }

    public function test_unauthenticated_user_cannot_access_documents(): void
    {
        Storage::fake('local');

        $user = User::forceCreate([
            'name' => 'User One',
            'email' => 'user1@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $profile = UserProfile::create([
            'user_id' => $user->id,
            'cv_path' => 'cvs/test.pdf',
        ]);
        Storage::disk('local')->put('cvs/test.pdf', $this->getValidPdfContent());

        $response = $this->get(route('documents.show', ['user' => $user->id, 'type' => 'cv']));
        $response->assertRedirect('/login');
    }

    public function test_unauthorized_user_cannot_access_other_users_document(): void
    {
        Storage::fake('local');

        $owner = User::forceCreate([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        UserProfile::create([
            'user_id' => $owner->id,
            'cv_path' => 'cvs/owner.pdf',
        ]);
        Storage::disk('local')->put('cvs/owner.pdf', $this->getValidPdfContent());

        $otherUser = User::forceCreate([
            'name' => 'Other',
            'email' => 'other@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($otherUser)->get(route('documents.show', ['user' => $owner->id, 'type' => 'cv']));
        $response->assertStatus(403);
    }

    public function test_document_owner_can_access_own_document(): void
    {
        Storage::fake('local');

        $owner = User::forceCreate([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        UserProfile::create([
            'user_id' => $owner->id,
            'cv_path' => 'cvs/owner.pdf',
        ]);
        Storage::disk('local')->put('cvs/owner.pdf', $this->getValidPdfContent());

        $response = $this->actingAs($owner)->get(route('documents.show', ['user' => $owner->id, 'type' => 'cv']));
        $response->assertStatus(200);
    }

    public function test_admin_can_access_applicant_document(): void
    {
        Storage::fake('local');

        $owner = User::forceCreate([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        UserProfile::create([
            'user_id' => $owner->id,
            'cv_path' => 'cvs/owner.pdf',
        ]);
        Storage::disk('local')->put('cvs/owner.pdf', $this->getValidPdfContent());

        $admin = User::forceCreate([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('documents.show', ['user' => $owner->id, 'type' => 'cv']));
        $response->assertStatus(200);
    }
}
