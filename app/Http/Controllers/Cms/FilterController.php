<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request,
    App,
    DB,
    App\Http\Requests,
    App\Http\Controllers\Controller,
    App\Filter,
    App\Language;

class FilterController extends Controller
{
    public function __construct(){
        App::setLocale(app('request')->header('language'));
    }

    public function index(Request $request)
    {

        if($request->get('all')){
            $filters = Filter::withTranslation()->orderBy('id', 'ASC')->get();
        }
        else{
//            $filters = Filter::where('parent_id', null)->with('children')->orderBy('type')->orderBy('id')->get();
            $filters = Filter::where('parent_id',null)->withTranslation()->orderBy('type')->get();
            $filters->load('children');
        }

        return response()->success(compact('filters'));
    }
    public function show($id)
    {
        $filter = Filter::findOrFail((int)$id);
        $languages = Language::where('enabled', true)->get();
        foreach($languages as $language){
            $filter->translate($language->language);
        }
        return response()->json($filter);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'language'    => 'required|min:2|max:2',
            'icon' => 'required|min:1|max:20',
            'title' => 'required|max:255'
        ]);

        DB::beginTransaction();

        $locale = $request->get('language');
        $filter = new Filter();
        $filter->icon = $request->get('icon');
        $filter->parent_id = $request->get('parent_id');
        $filter->save();

        $filter->translateOrNew($locale)->title = $request->get('title');
        $filter->save();

        if($locale !== "de"){
            $filter->translateOrNew('de')->title = $request->get('title');
            $filter->save();
        }

        DB::commit();

        return response()->json(compact('filter'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'icon' => 'required|min:1|max:20',
            'translations' => 'required'
        ]);


        $filter = Filter::find((int)$id);
        if (!$filter) {
            return response()->error('Filter not found', 404);
        }

        DB::beginTransaction();

        $locale = $request->get('language');
        $filter->icon = $request->get('icon');
        $filter->parent_id = $request->get('parent_id');

        foreach($request->get('translations') as $translation){
            $filter->translateOrNew($translation['locale'])->title = $translation['title'];

        }
        $filter->save();

        DB::commit();

        return response()->success(compact('filter'));
    }

    public function toggleEnabled(Request $request, $id){
        $this->validate($request, [
            'enabled'  => 'required',
        ]);

        $filter = Filter::findOrFail((int)$id);
        $filter->enabled = $request->get('endabled');

        return response()->success(compact('filter'));

    }
}
