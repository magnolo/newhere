<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Role;

class RoleController extends Controller
{
    //
    public function index(){
      $roles = Role::all()->load('users');
      return response()->json($roles);
    }
}
