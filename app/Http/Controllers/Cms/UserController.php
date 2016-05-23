<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use App\Role;
use App\Ngo;
use App\Language;
use Auth;

use DB;

class UserController extends Controller
{
    //
    public function index(){
      $users = User::with(['roles', 'ngos','languages'])->get();
      return response()->json($users);
    }

    public function show($id){
      $user = User::findOrFail($id)->load(['roles', 'ngos','languages']);
      return response()->json($user);
    }
    public function me(){
      $user = Auth::user();
      return response()->json($user);
    }
    public function byRole($role){
      $users = User::whereHas('roles', function($query) use ($role){
          $query->where('name', $role);
      })->get();
      return response()->json($users);
    }
    public function byNgo($id){
      $ngo = Ngo::findOrFail($id);
      $users = $ngo->load('users');
      return response()->json($users);
    }
    public function byLanuage($language){
      $language = Language::where('language',$language)->firstOrFail;
      $users = $language->load('users');
      return response()->json($users);
    }
    public function update(Request $request, $id){
      $this->validate($request, [
          'email'    => 'required|email',
          'name' => 'required|min:3|max:255',
          'confirmed' => 'required',
          'roles' => 'required'
      ]);

      DB::beginTransaction();

      $user = User::findOrFail($id);
      $user->name = $request->get('name');
      $user->email = $request->get('email');
      $user->confirmed = $request->get('confirmed');
      $user->save();

      $user->roles()->detach();
      foreach($request->get('roles') as $role){
        $role = Role::findOrFail($role['id']);
        $user->roles()->attach($role);
      }
      $user->ngos()->detach();
      foreach($request->get('ngos') as $ngo){
        $ngo = Ngo::findOrFail($ngo['id']);
        $user->ngos()->attach($ngo);
      }
      $user->languages()->detach();
      foreach($request->get('languages') as $language){
        $language = Language::where('language', $language['language'])->firstOrFail();
        $user->languages()->attach($language);
      }
      DB::commit();

      $user->load('ngos', 'roles', 'languages');
      return response()->success(compact(['user']));
    }

    public function create(Request $request){
      $this->validate($request, [
          'email'    => 'required|email',
          'name' => 'required|min:3|max:255',
          'confirmed' => 'required',
          'password' => 'required|min:5',
          're_password' => 'required|min:5',
          'roles' => 'required'
      ]);

      if($request->get('password') != $request->get('re_password')){
        return response()->error('Passwords do not match!', 422);
      }

      DB::beginTransaction();
      $user = new User;
      $user->name = trim($request->get('name'));
      $user->email = trim(strtolower($request->get('email')));
      $user->password = bcrypt($request->get('password'));

      if(!$request->get('confirmed')){
        $user->confirmation_code = str_random(30);
      }
      $user->save();

      foreach($request->get('roles') as $role){
        $role = Role::findOrFail($role['id']);
        $user->roles()->attach($role);
      }
      if($request->has('ngos')){
        foreach($request->get('ngos') as $ngo){
          $ngo = Ngo::findOrFail($ngo['id']);
          $user->ngos()->attach($ngo);
        }
      }
      if($request->has('languages')){
        foreach($request->get('languages') as $language){
          $language = Language::where('language', $language['language'])->firstOrFail();
          $user->languages()->attach($language);
        }
      }

      DB::commit();
      //if not confirmed send mail

      $user->load('ngos', 'roles');
      return response()->success(compact('user'));

    }
    function bulkRemove($ids){
      $usersQ = User::whereIn('id', explode(',', $ids));
      $users = $usersQ->get();
      $deletedRows = $usersQ->delete();

      return response()->success(compact('users', 'deletedRows'));
    }
}
