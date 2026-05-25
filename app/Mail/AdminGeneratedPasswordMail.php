<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminGeneratedPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public string $temporaryPassword;

    public function __construct(User $user, string $temporaryPassword)
    {
        $this->user = $user;
        $this->temporaryPassword = $temporaryPassword;
    }

    public function build()
    {
        return $this->subject('Password Sementara - TERANG By SRT')
            ->view('emails.admin_generated_password')
            ->with([
                'user' => $this->user,
                'name' => $this->user->name,
                'temporaryPassword' => $this->temporaryPassword,
            ]);
    }
}
