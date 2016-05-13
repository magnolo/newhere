<?php namespace App\Logic\User;

use App\Logic\Mailers\UserMailer;
use App\Role;
use App\User;
use App\Password;
use Hash, Carbon\Carbon;

class UserRepository {
    protected $userMailer;

    public function __construct( UserMailer $userMailer )
    {
        $this->userMailer = $userMailer;
    }
    public function verifyMail($user){
      return $this->userMailer->verify($user);
    }
    public function resetPassword( User $user  )
    {

        $token = sha1(mt_rand());
        $password = new Password;
        $password->email = $user->email;
        $password->token = $token;
        $password->created_at = Carbon::now();
        $password->save();

        $data = [
            'name'    => $user->name,
            'token'         => $token,
            'subject'       => 'Reset you password!',
            'email'         => $user->email
        ];
        $this->userMailer->passwordReset($user, $data);
    }
}
