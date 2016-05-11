<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Ngo;
use Illuminate\Http\Request;

use App\Http\Requests;

class NgoController extends Controller
{
    public function index() {
        $ngos = Ngo::all();
        return response()->json($ngos);
    }

    public function show($id) {
        $ngo = Ngo::findOrFail($id);
        return response()->json($ngo);
    }

    public function create(Request $request) {
        // TODO: same as in AuthController@register but store admin as user
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'published' => 'boolean'
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
}
