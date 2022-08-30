<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WellcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.wellcome')
            ->subject("Bem vindo ao "  . config("app.name"))
            ->with([
                'verifyEmailLink' => config('app.url') . '/verify-email?token=' . $this->user->confirmation_token,
                'userName' => $this->user->first_name . " " . $this->user->last_name
            ]);
    }
}
