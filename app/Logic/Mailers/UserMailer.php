<?php
namespace App\Logic\Mailers;
class UserMailer extends Mailer {
    public function verify(\App\User $user)
    {
        $view       = 'email.verify';
        $subject    = 'Verify my email';
        $fromEmail  = env('FROM_MAIL');

        return $this->sendTo($user->email, $user->name, $subject, $fromEmail, $view, ['confirmation_code' => $user->confirmation_code]);
    }
    public function passwordReset(\App\User $user, $data)
    {
        $view       = 'email.password-reset';
        $subject    = 'Reset your password';
        $fromEmail  = env('FROM_MAIL');
        $this->sendTo($user->email, $user->name, $subject, $fromEmail, $view, $data);
    }

}
