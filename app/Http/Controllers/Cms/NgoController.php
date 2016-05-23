<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Ngo;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class NgoController extends Controller
{
    public function index() {
        $ngos = Ngo::with(['image','users', 'offers'])->get();
        return response()->json($ngos);
    }

    public function show() {
        $user = Auth::user();

        $ngo = $user->ngos()->with('image')->firstOrFail();
        if (!$ngo) {
            return response()->error('NGO not found', 404);
        }

        return response()->json($ngo);
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

        /*
        Mail::send('email.verify', $confirmation_code, function($message) use($user) {
            $message->to($user->email, $user->name)
                ->subject('Verify your email address');
        });
        */

        return $user;
    }

    public function create(Request $request) {
        $useCmsAccount = $request->has('useCmsAccount');
        if (!$useCmsAccount) {
            $this->validate($request, [
                'organisation' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:5',
                'description' => 'max:200'
            ]);
        } else {
            $this->validate($request, [
                'organisation' => 'required',
                'description' => 'max:200'
            ]);
        }

        DB::beginTransaction();

        if ($useCmsAccount) {
            $ngoUser = Auth::user();
        } else {
            $ngoUser = $this->storeAndSendMail($request->get('organisation'), $request->email, $request->password);
            $organisationRole = Role::where('name', 'organisation')->firstOrFail();
            $ngoUser->attachRole($organisationRole);
        }

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
        return response()->success(compact('ngo'));
    }

    public function togglePublished(Request $request, $id) {
        $this->validate($request, [
            'published' => 'required'
        ]);

        $ngo = Ngo::find((int)$id);
        if (!$ngo) {
            return response()->error('NGO not found', 404);
        }

        $modified = false;
        if (isset($request->published)) {
            $ngo->published = (bool)$request->published;
            $modified = true;
        }

        if ($modified) {
            $ngo->save();
        }

        return response()->success(compact('ngo'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'organisation' => 'required',
            'description' => 'max:200'
        ]);

        $ngo = Ngo::find((int)$id);
        if (!$ngo) {
            return response()->error('NGO not found', 404);
        }

        DB::beginTransaction();
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
        DB::commit();

        return response()->success(compact('ngo'));
    }
}
