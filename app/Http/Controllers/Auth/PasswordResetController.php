<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Logic\User\UserRepository;
use App\User;
use App\Password;
use Validator, Hash;
use App\Http\Controllers\Controller;

class PasswordResetController extends Controller
{
    //
    public function postPasswordReset( UserRepository $userRepository, Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $email  = $request->get('email');
        $user   = User::where('email', '=', $email)->first();
        if(empty($user))
        {
            return response()->error('Ein Benutzer mit dieser Email ist uns nicht bekannt', 422);

        }
        $userRepository->resetPassword( $user );

        return response()->success(compact('user'));
    }
    public function postNewPassword(Request $request, $token){
      $this->validate($request, [
        'password'              => 'required|min:5|max:20',
        're_password' => 'required|same:password'
      ]);

      $password = Password::where('token', '=', $token)->first();
      if(empty($password))
      {
          return response()->error('Reset token ist ungültig', 422);
      }
      $user = User::where('email', '=', $password->email)->first();
      $user->password = Hash::make($request->get('password'));
      $user->save();
      $password->delete();
      return response()->success(compact('user'));
    }
}
