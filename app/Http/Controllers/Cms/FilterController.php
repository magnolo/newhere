<?php

namespace App\Http\Controllers\Cms;

use App\Http\Requests,
    App\Http\Controllers\Controller;
use App\Filter;

class FilterController extends Controller
{
    public function index()
    {
        $filters = Filter::all();
        return response()->json($filters);
    }
}
