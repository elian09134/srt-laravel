<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_password_reset_request_can_be_submitted(): void
    {
        $user = User::factory()->create();
        UserProfile::create([
            'user_id' => $user->id,
            'phone_number' => '08123456789',
        ]);

        $response = $this->post('/forgot-password', [
            'phone' => '08123456789',
        ]);

        $response->assertSessionHas('status');
        $this->assertDatabaseHas('password_reset_requests', [
            'user_id' => $user->id,
            'phone' => '08123456789',
            'status' => 'pending',
        ]);
    }

    public function test_password_reset_request_with_unknown_phone(): void
    {
        $response = $this->post('/forgot-password', [
            'phone' => '00000000000',
        ]);

        $response->assertSessionHas('status');
        $this->assertDatabaseHas('password_reset_requests', [
            'phone' => '00000000000',
            'user_id' => null,
        ]);
    }

    public function test_password_reset_request_requires_phone(): void
    {
        $response = $this->post('/forgot-password', []);

        $response->assertSessionHasErrors(['phone']);
    }
}
