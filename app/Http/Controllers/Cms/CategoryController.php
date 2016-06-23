<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App;
use DB;
use App\Http\Controllers\Controller;
use App\Category;
use App\Language;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        if ($request->get('all')) {
            $categories = Category::withTranslation()->orderBy('sortindex', 'ASC')->get();
        } else {
            $categories = Category::where('parent_id', null)->withTranslation()->orderBy('sortindex', 'ASC')->get();
            $categories->load(['children' => function ($query) {
                $query->orderBy('sortindex', 'ASC');
            }]);
        }

        $categories->load('image');

        return response()->success(compact('categories'));
    }

    public function show($id)
    {

          $category = Category::findOrFail((int)$id);
          $languages = Language::where('enabled', true)->get();
          foreach ($languages as $language) {
              $category->translate($language->language);
          }

        $category->load('image');

        return response()->json($category);
    }
    public function bySlug($slug)
    {
        $category = Category::where('slug', $slug)->with(['children', 'parent'])->firstOrFail();
          $category->load('image');
        return response()->json($category);
    }
    public function offers($slug){
      $category = Category::where('slug', $slug)->with(['children', 'public_offers'])->firstOrFail();
      $offers = $category->offers;
      if(count($category->children)){
        foreach($category->children as $child){
          $child->load('public_offers');
          $offers->push($child->offers);
          if(count($child->children)){
            foreach($child->children as $c){
              $c->load('public_offers');
              $offers->push($c->offers);
            }
          }
        }
      }
      $offers = $offers->flatten();
      return response()->success(compact('offers'));
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'language' => 'required|min:2|max:2',
            'image_id' => 'required|int',
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        DB::beginTransaction();

        $locale = $request->get('language');
        $category = new Category();
        $category->parent_id = $request->get('parent_id');
        $category->image_id = $request->get('image_id');
        $category->slug = str_slug($request->get('title'));
        $category->save();

        $category->translateOrNew($locale)->title = $request->get('title');
        $category->translateOrNew($locale)->description = $request->get('description');
        $category->save();

        if ($locale !== 'de') {
            $category->translateOrNew('de')->title = $request->get('title');
            $category->save();
        }

        $this->recreateSortIndex($request->get('parent_id'));

        DB::commit();

        return response()->json(compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'image_id' => 'required|int',
            'translations' => 'required',
        ]);

        $category = Category::find((int) $id);
        if (!$category) {
            return response()->error('Category not found', 404);
        }

        $parentCategory = null;
        if ($request->get('parent_id')) {
            $parentCategory = Category::find((int) $request->get('parent_id'));
            if (!$parentCategory) {
                return response()->error('Category not found', 404);
            }
        }

        $changeParent = false;
        if (($parentCategory && $category->parent_id && $parentCategory->id != $category->parent_id)
            || (!$parentCategory && $category->parent_id)
        ) {
            $changeParent = true;
            $oldParent = $category->parent_id;
        }

        DB::beginTransaction();

        $category->parent_id = $request->get('parent_id');
        $category->image_id = $request->get('image_id');

        $this->recreateSortIndex(
            ($parentCategory ? $parentCategory->id : null),
            ($changeParent ? 999 : null)
        );

        $category->parent_id = ($parentCategory ? $parentCategory->id : null);
        if ($changeParent) {
            $category->sortindex = 999;
        }

        /*
         * @todo versioning!
         */
        foreach ($request->get('translations') as $transalation) {
            $category->translateOrNew($transalation['locale'])->title = $transalation['title'];
            $category->translateOrNew($transalation['locale'])->description = $transalation['description'];
        }
        $category->save();

        if ($changeParent) {
            // do it a 2nd time to fix sortindex
            $this->recreateSortIndex(
                ($parentCategory ? $parentCategory->id : null)
            );

            $this->recreateSortIndex($oldParent);
        }

        DB::commit();

        return response()->success(compact('category'));
    }

    public function move(Request $request, $id)
    {
        $this->validate($request, [
            'sortindex' => 'required|int',
            'parent' => 'int',
        ]);

        $category = Category::find((int) $id);
        if (!$category) {
            return response()->error('Category not found', 404);
        }

        $parentCategory = null;
        if ($request->get('parent')) {
            $parentCategory = Category::find((int) $request->get('parent'));
            if (!$parentCategory) {
                return response()->error('Category not found', 404);
            }
        }
        $changeParent = false;
        if (($parentCategory && $category->parent_id && $parentCategory->id != $category->parent_id)
            || (!$parentCategory && $category->parent_id)
        ) {
            $changeParent = true;
            $oldParent = $category->parent_id;
        }

        $newSortIndex = (int) $request->get('sortindex');

        DB::beginTransaction();

        $this->recreateSortIndex(
            ($parentCategory ? $parentCategory->id : null),
            $newSortIndex
        );

        $category->parent_id = ($parentCategory ? $parentCategory->id : null);
        $category->sortindex = $newSortIndex;
        $category->save();

        if ($changeParent) {
            $this->recreateSortIndex($oldParent);
        }

        DB::commit();

        return response()->json(compact('category'));
    }

    public function toggleEnabled(Request $request, $id)
    {
        $this->validate($request, [
            'enabled' => 'required',
        ]);

        $category = Category::findOrFail((int) $id);
        $category->enabled = $request->get('endabled');

        return response()->success(compact('category'));
    }

    private function recreateSortIndex($parentId = null, $newSortIndex = null)
    {
        $categoryItems = Category::where('parent_id', $parentId)->orderBy('sortindex', 'ASC')->get();
        $currentSortIndex = 0;
        foreach ($categoryItems as $categoryItem) {
            if ($newSortIndex !== null && $currentSortIndex == $newSortIndex) {
                ++$currentSortIndex;
            }
            if ($categoryItem->sortindex != $currentSortIndex) {
                $categoryItem->sortindex = $currentSortIndex;
                $categoryItem->save();
            }
            ++$currentSortIndex;
        }
    }
}
