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
    public function all()
    {
        $filters = Filter::with(['children', 'parent'])->orderBy('id')->get();
        return response()->success(compact('filters'));
    }
    public function toggleEnabled(Request $request, $id) {
        $this->validate($request, [
            'enabled' => 'required'
        ]);

        $filter = Filter::find((int)$id);
        if (!$filter) {

            return response()->error('Filter not found', 404);
        }

        $modified = false;
        if (isset($request->enabled)) {
            $filter->enabled = (bool)$request->enabled;
            $modified = true;
        }

        if ($modified) {
            $filter->save();
        }

        return response()->success(compact('filter'));
    }
    function bulkRemove($ids){
        $filtersQ = Filter::whereIn('id', explode(',', $ids));
        $filters = $filtersQ->get();
        $deletedRows = $filtersQ->delete();

        return response()->success(compact('filters', 'deletedRows'));
    }
    public function bulkAssign(Request $request, $ids){
        $filtersQ = Filter::whereIn('id', explode(',', $ids));
        $filters = $filtersQ->get();
        $updatedRows = $filtersQ->update([$request->get('field') => $request->get('value')]);

        return response()->success(compact('filters', 'updatedRows'));
    }
}
