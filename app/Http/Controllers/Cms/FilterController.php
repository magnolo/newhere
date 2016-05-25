<?php

namespace App\Http\Controllers\Cms;

use App\Http\Requests,
    App\Http\Controllers\Controller;
use App\Filter;

class FilterController extends Controller
{
    public function index()
    {
        $filters = Filter::where('parent_id', null)->with('children')->orderBy('type')->orderBy('id')->get();
        return response()->success(compact('filters'));
    }
}
