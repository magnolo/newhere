<?php

namespace App\Http\Controllers\Auth;

use Auth;
use JWTAuth;
use App\User;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|min:5',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->error('Invalid credentials', 401);
            }
        } catch (\JWTException $e) {
            return response()->error('Could not create token', 500);
        }

        $user = Auth::user();
        if($user->confirmed != 1){
          return response()->error('Your account has not been verified. Did you get mail?',401);
        }
        $user->load('roles');
        return response()->success(compact('user', 'token'));
    }

    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'name'       => 'required|min:3',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:6',
        ]);

        $confirmation_code = str_random(30);

        $user = new User;
        $user->name = trim($request->name);
        $user->email = trim(strtolower($request->email));
        $user->password = bcrypt($request->password);
        $user->save();

        $user->attachRole(Role::where('name', 'user')->findOrFail());

        $token = JWTAuth::fromUser($user);

        Mail::send('email.verify', $confirmation_code, function($message) {
            $message->to($user->email, $user->name)
                ->subject('Verify your email address');
        });

        return response()->success(compact('user', 'token'));
    }

    public function getConfirmation($confirmation_code){
      if(!$confirmation_code){
        throw new InvalidConfirmationCodeException;
      }
      $user = User::whereConfirmationCode($confirmation_code)->first();
      if(!$user){
          throw new InvalidConfirmationCodeException;
      }
      $user->confirmed = 1;
      $user->confirmation_code = null;
      $user->save();

      return response()->success(compact('user'));
    }
}
