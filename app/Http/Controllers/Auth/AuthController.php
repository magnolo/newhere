<?php

namespace App\Http\Controllers\Auth;

use App\Ngo;
use App\Role;
use Auth;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use App\User;
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
        $user->load('roles');
        return response()->success(compact('user', 'token'));
    }

    /**
     * Standard Registration
     * @param Request $request
     * @return mixed
     */
    public function postRegister(Request $request)
    {
        if ($request->has('organisation')) {
            //redirect to NGO registration
            return $this->registerNgo($request);
        }

        $this->validate($request, [
            'name'       => 'required|min:3',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:8',
        ]);

        $user = $this->saveUser($request->name, $request->email, $request->password);
        $user->attachRole(Role::where('name', 'user')->findOrFail());

        $token = JWTAuth::fromUser($user);
        return response()->success(compact('user', 'token'));
    }

    /**
     * NGO Registration
     * @param Request $request
     * @return mixed
     */
    public function registerNgo(Request $request)
    {
        $this->validate($request, [
            'organisation'    => 'required',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:8',
            'description'    => 'max:200'
        ]);

        DB::beginTransaction();

        $ngoUser = $this->saveUser($request->get('organisation'), $request->email, $request->password);
        $organisationRole = Role::where('name', 'organisation')->firstOrFail();
        $ngoUser->attachRole($organisationRole);

        $ngo = new Ngo();
        $ngo->organisation = $request->get('organisation');
        $ngo->website = $request->get('website');
        $ngo->contact = $request->get('contact');
        $ngo->contact_email = $request->get('contact_email');
        $ngo->contact_phone = $request->get('contact_phone');
        $ngo->street = $request->get('street');
        $ngo->street_number = $request->get('street_number');
        $ngo->zip = $request->get('zip');
        $ngo->city = $request->get('city');
        $ngo->save();
        $ngo->users()->attach($ngoUser);

        DB::commit();

        $token = JWTAuth::fromUser($ngoUser);
        return response()->success(compact('user', 'token'));
    }

    private function saveUser($name, $email, $password) {
        $user = new User;
        $user->name = trim($name);
        $user->email = trim(strtolower($email));
        $user->password = bcrypt($password);
        $user->save();

        return $user;
    }
}
