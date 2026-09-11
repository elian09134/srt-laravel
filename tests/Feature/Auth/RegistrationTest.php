<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        \Illuminate\Support\Facades\Storage::fake('local');

        $im = imagecreatetruecolor(10, 10);
        ob_start();
        imagejpeg($im);
        $jpg = ob_get_clean();
        imagedestroy($im);

        $pdf = "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\ntrailer\n<< /Root 1 0 R >>\n%%EOF";

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'nickname' => 'Tester',
            'phone_number' => '081234567890',
            'date_of_birth' => '1995-01-01',
            'about_me' => 'Saya pelamar.',
            'education_level' => 'S1',
            'institution' => 'Universitas',
            'major' => 'Informatika',
            'referral_source' => 'Website',
            'expected_salary' => 8000000,
            'cv' => \Illuminate\Http\UploadedFile::fake()->createWithContent('cv.pdf', $pdf),
            'formal_photo' => \Illuminate\Http\UploadedFile::fake()->createWithContent('formal.jpg', $jpg),
            'ktp' => \Illuminate\Http\UploadedFile::fake()->createWithContent('ktp.jpg', $jpg),
            'kk' => \Illuminate\Http\UploadedFile::fake()->createWithContent('kk.jpg', $jpg),
            'ijazah' => \Illuminate\Http\UploadedFile::fake()->createWithContent('ijazah.pdf', $pdf),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
