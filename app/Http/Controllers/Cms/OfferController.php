<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Offer;
use App\OfferTranslation;
use Illuminate\Http\Request;
use App\Http\Requests;


class OfferController extends Controller
{
    public function index() {
        $offers = Offer::with(['ngo', 'filters','categories', 'countries'])->get();
        return response()->json($offers);
    }

    function bulkRemove($ids){
//        $offersQ = Offer::whereIn('id', explode(',', $ids));
//        $offers = $offersQ->get();
//        $deletedRows = $offersQ->delete(); // deleted -> true !!
//
//        return response()->success(compact('offers', 'deletedRows'));
    }

    public function toggleEnabled(Request $request, $id) {
        $this->validate($request, [
            'enabled' => 'required'
        ]);

        $offer = Offer::find((int)$id);
        if (!$offer) {
            return response()->error('Offer not found', 404);
        }

        $modified = false;
        if (isset($request->enabled)) {
            $offer->enabled = (bool)$request->enabled;
            $modified = true;
        }

        if ($modified) {
            $offer->save();
        }

        return response()->success(compact('offer'));
    }
}
