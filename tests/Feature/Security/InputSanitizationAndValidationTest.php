<?php

namespace Tests\Feature\Security;

use App\Models\Job;
use App\Models\User;
use App\Models\UserProfile;
use App\Support\Security;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InputSanitizationAndValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function getValidPdfContent(): string
    {
        return "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\ntrailer\n<< /Root 1 0 R >>\n%%EOF";
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

    public function test_mass_assignment_protection_role_cannot_be_injected_at_registration(): void
    {
        Storage::fake('local');

        $response = $this->post('/register', [
            'name' => 'Attacker',
            'email' => 'attacker@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'admin', // Attempted privilege escalation
            'nickname' => 'Attacker',
            'phone_number' => '081234567890',
            'date_of_birth' => '1995-05-15',
            'about_me' => 'Saya pelamar.',
            'education_level' => 'S1',
            'institution' => 'Universitas Indonesia',
            'major' => 'Teknik Informatika',
            'referral_source' => 'LinkedIn',
            'expected_salary' => 10000000,
            'cv' => UploadedFile::fake()->createWithContent('cv.pdf', $this->getValidPdfContent()),
            'formal_photo' => UploadedFile::fake()->createWithContent('formal.jpg', $this->getValidJpegContent()),
            'ktp' => UploadedFile::fake()->createWithContent('ktp.png', $this->getValidPngContent()),
            'kk' => UploadedFile::fake()->createWithContent('kk.jpg', $this->getValidJpegContent()),
            'ijazah' => UploadedFile::fake()->createWithContent('ijazah.pdf', $this->getValidPdfContent()),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'attacker@example.com',
            'role' => 'user', // Must remain 'user'
        ]);

        $user = User::where('email', 'attacker@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('user', $user->role);
        $this->assertNotEquals('admin', $user->role);
    }

    public function test_mass_assignment_protection_role_cannot_be_updated_via_profile(): void
    {
        $user = User::forceCreate([
            'name' => 'Normal User',
            'email' => 'normal@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'nickname' => 'Normal',
            'phone_number' => '081234567890',
            'date_of_birth' => '1990-01-01',
            'about_me' => 'About normal',
            'education_level' => 'S1',
            'institution' => 'ITB',
            'major' => 'Informatika',
            'expected_salary' => 8000000,
        ]);

        $this->actingAs($user)->patch('/profile', [
            'name' => 'Updated User',
            'email' => 'normal@example.com',
            'role' => 'superadmin', // Attempted role escalation
            'nickname' => 'Updated',
            'phone_number' => '081234567899',
            'date_of_birth' => '1990-01-01',
            'about_me' => 'About updated',
            'education_level' => 'S1',
            'institution' => 'ITB',
            'major' => 'Informatika',
            'expected_salary' => 9000000,
        ]);

        $user->refresh();
        $this->assertEquals('user', $user->role);
    }

    public function test_html_tags_and_xss_are_sanitized_in_profile_inputs(): void
    {
        $user = User::forceCreate([
            'name' => 'Profile User',
            'email' => 'profile@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'nickname' => 'Old Nick',
            'phone_number' => '081234567890',
            'date_of_birth' => '1992-02-02',
            'about_me' => 'Old about',
            'education_level' => 'S1',
            'institution' => 'ITS',
            'major' => 'Sistem Informasi',
            'expected_salary' => 7000000,
        ]);

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => '<b>Hacked Name</b>',
            'email' => 'profile@example.com',
            'nickname' => '<b>CleanNick</b>',
            'phone_number' => '081234567891',
            'date_of_birth' => '1992-02-02',
            'about_me' => '<script>stealCookies()</script>Saya adalah developer berpengalaman',
            'education_level' => 'S1',
            'institution' => '<b>ITS Surabaya</b>',
            'major' => '<script>alert(1)</script>Sistem Informasi',
            'expected_salary' => 12000000,
            'skills' => '<script>evil()</script>PHP, Laravel',
        ]);

        $response->assertSessionDoesntHaveErrors();

        $user->refresh();
        $this->assertStringNotContainsString('<b>', $user->name);
        $this->assertStringNotContainsString('</b>', $user->name);
        $this->assertEquals('Hacked Name', $user->name);

        $profile = $user->profile;
        $this->assertNotNull($profile);
        $this->assertStringNotContainsString('<script>', $profile->about_me);
        $this->assertStringNotContainsString('<script>', $profile->major);
        $this->assertStringNotContainsString('<script>', $profile->skills);
        $this->assertEquals('Saya adalah developer berpengalaman', $profile->about_me);
        $this->assertEquals('Sistem Informasi', $profile->major);
        $this->assertEquals('PHP, Laravel', $profile->skills);
    }

    public function test_strict_whitelist_validation_rejects_invalid_education_level(): void
    {
        $user = User::forceCreate([
            'name' => 'Val User',
            'email' => 'val@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => 'Val User',
            'email' => 'val@example.com',
            'nickname' => 'Val',
            'phone_number' => '081234567890',
            'date_of_birth' => '1995-01-01',
            'about_me' => 'About me text',
            'education_level' => 'PHD_SUPER_INVALID',
            'institution' => 'University',
            'major' => 'Major',
            'expected_salary' => 5000000,
        ]);
        $response->assertSessionHasErrors('education_level');
    }

    public function test_application_status_update_enforces_whitelist(): void
    {
        $admin = User::forceCreate([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $candidate = User::forceCreate([
            'name' => 'Candidate',
            'email' => 'cand@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $job = Job::create([
            'title' => 'Software Engineer',
            'jobdesk' => 'Coding',
            'requirements' => 'PHP, Laravel',
            'location' => 'Jakarta',
            'type' => 'Full-time',
            'is_active' => true,
        ]);

        $application = \App\Models\Application::create([
            'user_id' => $candidate->id,
            'job_id' => $job->id,
            'status' => 'Baru',
            'cv_path' => 'cvs/test.pdf',
        ]);

        // Invalid status
        $response = $this->actingAs($admin)->patch("/admin/applicants/{$application->id}/status", [
            'status' => 'hacked_status',
        ]);
        $response->assertSessionHasErrors('status');

        // Valid status
        $response = $this->actingAs($admin)->patch("/admin/applicants/{$application->id}/status", [
            'status' => 'Psikotest',
        ]);
        $response->assertSessionDoesntHaveErrors();

        $application->refresh();
        $this->assertEquals('Psikotest', $application->status);
    }

    public function test_sql_like_wildcard_escaping(): void
    {
        $this->assertEquals('100\\%', Security::escapeLike('100%'));
        $this->assertEquals('user\\_name', Security::escapeLike('user_name'));
        $this->assertEquals('\\%\\_test', Security::escapeLike('%_test'));
        $this->assertEquals('normal text', Security::escapeLike('normal text'));
    }
}
