<?php

namespace App\Http\Controllers\Cms;

use App\Http\Requests,
    App\Http\Controllers\Controller;

class FilterController extends Controller
{
    public function index()
    {
        $filters = \App\Filter::all();
        return response()->json($filters);
    }
}
