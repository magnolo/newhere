<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;

use App\Ngo;
use App\Offer;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use App\Logic\Address\AddressAPI;

use Log;

class OfferController extends Controller
{
  //  public function index() {
  //     $ngos = Ngo::with(['image','users', 'offers'])->get();
  //     return response()->json($ngos);
  //  }
   public function index() {
       $offers = Offer::with(['ngo', 'filters','categories', 'countries'])->get();
       return response()->json($offers);
   }

   public function autocomplete($search) {
      $addressApi = new AddressAPI();
      $returnArray = $addressApi->getAddressSuggestions($search);
      return response()->json($returnArray);
   }

   public function show($id) {
      $ngo = Ngo::findOrFail($id);
      return response()->json($ngo);
   }


   public function create(Request $request) {

      $this->validate($request, [
         'title' => 'required|max:255',
         'description' => 'required',
         'street' => 'required',
         'streetnumber' => 'required',
         'zip' => 'required',
         'city' => 'required'
      ]);

      $addressApi = new AddressAPI();
      $coordinates = $addressApi->getCoordinates($request->get('street'), $request->get('streetnumber'), $request->get('zip'));


      DB::beginTransaction();

      $ngoUser = Auth::user();


      $offer = new Offer();
      $offer->title = $request->get('title');
      $offer->description = $request->get('description');
      $offer->opening_hours = $request->get('opening_hours');
      $offer->website = $request->get('website');
      $offer->email = $request->get('email');
      $offer->phone = $request->get('phone');
      $offer->street = $request->get('street');
      $offer->streetnumber = $request->get('streetnumber');
      $offer->streetnumberadditional = $request->get('streetnumberadditional');
      $offer->zip = $request->get('zip');
      $offer->city = $request->get('city');
      $offer->valid_from = $request->get('valid_from');
      $offer->valid_until = $request->get('valid_until');

      $offer->latitude = $coordinates[0];
      $offer->longitude = $coordinates[1];

      $ngo = $ngoUser->ngos()->getResults()[0];

      $offer->ngo_id = $ngo->id;

      //Standard Translation
      //if ($request->has('description')) {
      //   $locale = $request->get('language');
      //   $ngo->translateOrNew($locale)->description = $request->get('description');
      //}
      $offer->save();

      DB::commit();
      return response()->success(compact('offer'));
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
