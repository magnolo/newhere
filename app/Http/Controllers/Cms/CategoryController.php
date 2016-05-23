<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request,
    App,
    DB,
    App\Http\Requests,
    App\Http\Controllers\Controller,
    App\Category,
    App\Language;

class CategoryController extends Controller
{
    public function __construct(){
        App::setLocale(app('request')->header('language'));
    }

    public function index(Request $request)
    {
        if($request->get('all')){
          $categories = Category::withTranslation()->orderBy('id', 'ASC')->get();
        }
        else{
          $categories = Category::where('parent_id',null)->withTranslation()->orderBy('id', 'ASC')->get();
          $categories->load('children');
        }

        return response()->success(compact('categories'));
    }

    public function show($id)
    {
        $category = Category::findOrFail((int)$id);
        $languages = Language::where('enabled', true)->get();
        foreach($languages as $language){
           $category->translate($language->language);
        }
        return response()->json($category);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'language'    => 'required|min:2|max:2',
            'icon' => 'required|min:1|max:20',
            'title' => 'required|max:255',
            'description' => 'required'
        ]);

        DB::beginTransaction();

        $locale = $request->get('language');
        $category = new Category();
        $category->icon = $request->get('icon');
        $category->parent_id = $request->get('parent_id');
        $category->save();

        $category->translateOrNew($locale)->title = $request->get('title');
        $category->translateOrNew($locale)->description = $request->get('description');
        $category->save();

        if($locale !== "de"){
            $category->translateOrNew('de')->title = $request->get('title');
            $category->save();
        }

        DB::commit();

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'icon' => 'required|min:1|max:20',
            'translations' => 'required'
        ]);


        $category = Category::find((int)$id);
        if (!$category) {
            return response()->error('Category not found', 404);
        }

        DB::beginTransaction();

        $locale = $request->get('language');
        $category->icon = $request->get('icon');
        $category->parent_id = $request->get('parent_id');

        foreach($request->get('translations') as $transalation){
          $category->translateOrNew($transalation['locale'])->title = $transalation['title'];
          $category->translateOrNew($transalation['locale'])->description = $transalation['description'];

        }
        $category->save();

        DB::commit();

        return response()->success(compact('category'));
    }

    public function toggleEnabled(Request $request, $id){
      $this->validate($request, [
          'enabled'  => 'required',
      ]);

      $category = Category::findOrFail((int)$id);
      $category->enabled = $request->get('endabled');

      return response()->success(compact('category'));

    }
}
