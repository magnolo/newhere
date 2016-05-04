<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request,
    DB,
    App\Http\Requests,
    App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(\App\Services\Category $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = \App\Category::all();
        return response()->json($this->getCategoryService()->prepareForResponse($categories));
    }

    public function show($id)
    {
        $category = \App\Category::find((int)$id);
        if (!$category) {
            return response()->error('Category not found', 404);
        }

        return response()->json($this->getCategoryService()->prepareForResponse($category));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'language'    => 'required|min:2|max:2',
            'icon' => 'required|min:1|max:20',
            'title' => 'required|max:255',
            'description' => 'required'
        ]);

        $language = \App\Language::where('language', $request->get('language'))->first();
        if (!$language) {
            return response()->error('Language not found', 404);
        }

        DB::beginTransaction();

        $category = new \App\Category();
        $category->icon = $request->get('icon');
        $category->save();

        $categoryTranslation = new \App\CategoryTranslation();
        $categoryTranslation->title = $request->get('title');
        $categoryTranslation->description = $request->get('description');
        $categoryTranslation->language_id = $language->id;
        $category->translations()->save($categoryTranslation);

        DB::commit();

        return response()->json($this->getCategoryService()->prepareForResponse($category));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'language'    => 'required|min:2|max:2',
            'icon' => 'required|min:1|max:20',
            'title' => 'required|max:255',
            'description' => 'required'
        ]);

        $language = \App\Language::where('language', $request->get('language'))->first();
        if (!$language) {
            return response()->error('Language not found', 404);
        }

        $category = \App\Category::find((int)$id);
        if (!$category) {
            return response()->error('Category not found', 404);
        }

        $translations = $category->translations()->getResults();
        $categoryTranslation = null;
        foreach ($translations as $t) {
            if ($t->language()->first()->language == $language->language) {
                $categoryTranslation = $t;
                break;
            }
        }

        DB::beginTransaction();

        $category->icon = $request->get('icon');
        $category->save();

        if (!$categoryTranslation) {
            $categoryTranslation = new \App\CategoryTranslation();
            $categoryTranslation->title = $request->get('title');
            $categoryTranslation->description = $request->get('description');
            $categoryTranslation->language_id = $language->id;
            $category->translations()->save($categoryTranslation);
        } else {
            $categoryTranslation->title = $request->get('title');
            $categoryTranslation->description = $request->get('description');
            $categoryTranslation->save();
        }

        DB::commit();

        return response()->json($this->getCategoryService()->prepareForResponse($category));
    }

    /**
     * @return \App\Services\Category
     */
    protected function getCategoryService()
    {
        return $this->categoryService;
    }
}
