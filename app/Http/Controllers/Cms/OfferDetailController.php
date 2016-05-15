<?php
/**
 * Created by PhpStorm.
 * User: Martina
 * Date: 14.05.2016
 * Time: 09:05
 */

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Offer;
use App\OfferTranslation;


class OfferDetailController extends Controller
{


    public function index()
    {

        $offerBase = Offer::where("id", 1)->get();
        $offersExtended = OfferTranslation::where("offer_id", 1)->get();

        return response()->json($offerBase, $offersExtended);

    }

    public function show($id)
    {
        $offerBase = Offer::where("id", $id)->get();
        $offersExtended = OfferTranslation::where("offer_id", $id)->get();

        return response()->json($offerBase, $offersExtended);
    }


}