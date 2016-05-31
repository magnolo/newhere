<?php

namespace App\Http\Controllers\Auth;

use App\Ngo;
use App\Role;
use Auth;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use App\User;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Logic\User\UserRepository;

class AuthController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository){
      $this->userRepository = $userRepository;
    }
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->error('Invalid credentials', 401);
            }
        } catch (\JWTException $e) {
            return response()->error('Could not create token', 500);
        }

        $user = Auth::user();
        if ($user->confirmed != 1) {
            return response()->error('Your account has not been verified. Did you get mail?', 401);
        }
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
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
        ]);
        $user = $this->storeAndSendMail($request->name, $request->email, $request->password);
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
            'organisation' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'description' => 'max:200'
        ]);

        DB::beginTransaction();

        $ngoUser = $this->storeAndSendMail($request->get('organisation'), $request->email, $request->password);
        $organisationRole = Role::where('name', 'organisation-admin')->firstOrFail();
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
        $ngo->image_id = $request->get('image_id');

        //Standard Translation
        if ($request->has('description')) {
            $locale = $request->get('language');
            $ngo->translateOrNew($locale)->description = $request->get('description');
        }

        $ngo->save();
        $ngo->users()->attach($ngoUser);

        DB::commit();

        //$token = JWTAuth::fromUser($ngoUser);
        return response()->success(compact('user', 'token'));
    }

    private function storeAndSendMail($name, $email, $password)
    {
        $confirmation_code = str_random(30);

        $user = new User;
        $user->name = trim($name);
        $user->email = trim(strtolower($email));
        $user->password = bcrypt($password);
        $user->confirmation_code = $confirmation_code;
        $user->save();

        $this->userRepository->verifyMail($user);

        return $user;
    }

    public function getConfirmation($confirmation_code)
    {
        if (!$confirmation_code) {
            throw new InvalidConfirmationCodeException;
        }
        $user = User::whereConfirmationCode($confirmation_code)->first();
        if (!$user) {
            throw new InvalidConfirmationCodeException;
        }
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        return redirect('/#/login');
        return response()->success(compact('user'));
    }

    public function getVerify(){
        $user = User::find(3);
        $user->confirmation_code = str_random(30);
        $user->save();

        $this->userRepository->verifyMail($user);

        return true;//
    }

}
