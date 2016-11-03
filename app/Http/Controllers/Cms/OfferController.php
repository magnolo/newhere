<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;

use App\Ngo;
use App\Offer;
use App\Role;
use App\User;
use App\Filter;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use App\Logic\Address\AddressAPI;
use Auth;
use Log;


class OfferController extends Controller
{


   public function index(Request $request) {
      $offers = Offer::with(['ngo', 'filters','categories', 'countries', 'image']);

      $count = $offers->count();

      if($request->has('ngo_id')){
        $offers = $offers->where('ngo_id', $request->get('ngo_id'));
        $count = $offers->count();
      }
      if($request->has('enabled')){
        $offers = $offers->where('enabled', $request->get('enabled'));
        $count = $offers->count();
      }
      if($request->has('title')){
        $offers = $offers->whereTranslationLike('title', '%'.$request->get('title').'%');
        $count = $offers->count();
      }
      if($request->has('order')){
        $order = $request->get('order');
        $dir = 'DESC';
        if(substr($order,0,1) == '-'){
          $dir = 'ASC';
          $order = substr($order,1);
        }
        $offers = $offers->orderBy($order, $dir);
      }
      if($request->has('limit')){
        $offers = $offers->take($request->get('limit'));
      }
      if($request->has('page')){
        $offers = $offers->skip(($request->get('page') - 1) * $request->get('limit'));
      }
      $offers = $offers->get();
      return response()->success(compact('offers', 'count'));
   }
    public function search(Request $request) {
      $offers = Offer::with(array('ngo', 'categories'))
      ->whereTranslationLike('title', '%'.$request->get('query').'%')
      // ->orWhereTranslationLike('description', '%'.$request->get('query').'%')
      ->orWhere('street', 'like', '%'.$request->get('query').'%')
      ->orWhere('zip', 'like', '%'.$request->get('query').'%')
      ->orWhereHas('ngo', function($query) use ($request){
        $query->where('organisation', 'like', '%'.$request->get('query').'%');
      })
      ->orWhereHas('categories', function($query) use ($request){
        $query->whereTranslationLike('title', '%'.$request->get('query').'%');
      })
      ->orWhereHas('categories.parent', function($query) use ($request){
        $query->whereTranslationLike('title', '%'.$request->get('query').'%');
      })
      ->orWhereHas('categories.parent.parent', function($query) use ($request){
        $query->whereTranslationLike('title', '%'.$request->get('query').'%');
      })
       ->get();
       $count = $offers->count();
      return response()->success(compact('offers', 'count'));
    }
   public function getAll(Request $request){

   }
   public function autocomplete($search) {
      $addressApi = new AddressAPI();
      $returnArray = $addressApi->getAddressSuggestions($search);
      return response()->json($returnArray);
   }

  //  public function show($id) {
  //     $ngo = Ngo::findOrFail($id);
  //     return response()->json($ngo);
  //  }
  public function show($id) {
      $offer = Offer::where('id', $id)->with(['ngo', 'filters', 'categories', 'countries', 'image', 'translations'])->firstOrFail();
      return response()->json($offer);
   }

   public function create(Request $request) {

      $this->validate($request, [
         'title' => 'required|max:255',
         'description' => 'required',
      ]);

       $hasAddress = false;

       if ($request->has('street') && $request->has('streetnumber') && $request->has('zip')) {
           $hasAddress = true;
       }

       if ($hasAddress) {
          $addressApi = new AddressAPI();
          $coordinates = $addressApi->getCoordinates($request->get('street'), $request->get('streetnumber'), $request->get('zip'));
       }


      DB::beginTransaction();

      $ngoUser = Auth::user();


      $offer = new Offer();
      $offer->title = $request->get('title');
      $offer->description = $request->get('description');
      $offer->opening_hours = $request->get('opening_hours');
      $offer->website = $request->get('website');
      $offer->email = $request->get('email');
      $offer->phone = $request->get('phone');
       if ($hasAddress) {
           $offer->street = $request->get('street');
           $offer->streetnumber = $request->get('streetnumber');
           $offer->streetnumberadditional = $request->get('streetnumberadditional');
           $offer->zip = $request->get('zip');
           $offer->city = $request->get('city');
           $offer->latitude = $coordinates[0];
           $offer->longitude = $coordinates[1];
       }
      $offer->valid_from = $request->get('valid_from');
      $offer->valid_until = $request->get('valid_until');
      $offer->image_id = $request->get('image_id');



      if($request->has('ngo_id')){
        $offer->ngo_id = $request->get('ngo_id');
        $ngo = Ngo::find((int)$offer->ngo_id);
      }
      else{
        $ngo = $ngoUser->ngos()->firstOrFail();
        $offer->ngo_id = $ngo->id;
      }

      $offer->enabled = false;
      if ($ngo->published) {
           $offer->enabled = true;
      }

      //Standard Translation
      //if ($request->has('description')) {
      //   $locale = $request->get('language');
      //   $ngo->translateOrNew($locale)->description = $request->get('description');
      //}
      $offer->save();

      if($request->has('filters')){
        foreach($request->get('filters') as $key => $filter){
          $f = Filter::findOrFail($filter['id']);
          $offer->filters()->attach($f);
        }
      }
      if($request->has('categories')){
        foreach($request->get('categories') as $key => $category){
          $cat = Category::findOrFail($category['id']);
          $offer->categories()->attach($cat);
        }
      }
      if($request->has('translations')){
        foreach($request->get('translations') as $key => $translation){
          $offer->translateOrNew($key)->title = $translation['title'];
          $offer->translateOrNew($key)->description = $translation['description'];
          $offer->translateOrNew($key)->opening_hours = $translation['opening_hours'];
          $offer->save();
        }
      }

      DB::commit();
      return response()->success(compact('offer'));
   }
   public function update(Request $request, $id){

       $hasAddress = false;

       if ($request->has('street') && $request->has('streetnumber') && $request->has('zip')) {
           $hasAddress = true;
       }

       if ($hasAddress) {
        $addressApi = new AddressAPI();
        $coordinates = $addressApi->getCoordinates($request->get('street'), $request->get('streetnumber'), $request->get('zip'));
       }

     DB::beginTransaction();
     $offer = Offer::findOrFail($id);
     $offer->title = $request->get('title');
     $offer->description = $request->get('description');
     $offer->opening_hours = $request->get('opening_hours');
     $offer->website = $request->get('website');
     $offer->email = $request->get('email');
     $offer->phone = $request->get('phone');
       if ($hasAddress) {
           $offer->street = $request->get('street');
           $offer->streetnumber = $request->get('streetnumber');
           $offer->streetnumberadditional = $request->get('streetnumberadditional');
           $offer->zip = $request->get('zip');
           $offer->city = $request->get('city');
           $offer->latitude = $coordinates[0];
           $offer->longitude = $coordinates[1];
       }

     $offer->valid_from = $request->get('valid_from');
     $offer->valid_until = $request->get('valid_until');
     $offer->image_id = $request->get('image_id');

     $offer->ngo_id = $request->get('ngo_id');
     $success = $offer->save();

     if($request->has('filters')){
       $offer->filters()->detach();
       foreach($request->get('filters') as $key => $filter){
         $f = Filter::findOrFail($filter['id']);
         $offer->filters()->attach($f);
       }
     }
     if($request->has('categories')){
       $offer->categories()->detach();
       foreach($request->get('categories') as $key => $category){
         $cat = Category::findOrFail($category['id']);
         $offer->categories()->attach($cat);
       }
     }
     DB::commit();
     return response()->success(compact(['success','offer']));
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
   public function bulkAssign(Request $request, $ids){
     $offersQ = Offer::whereIn('id', explode(',', $ids));
     $offers = $offersQ->get();
     $updatedRows = $offersQ->update([$request->get('field') => $request->get('value')]);

     return response()->success(compact('offers', 'updatedRows'));
   }
   function bulkRemove($ids){
     $offersQ = Offer::whereIn('id', explode(',', $ids));
     $offers = $offersQ->get();
     $deletedRows = $offersQ->delete();

     return response()->success(compact('offers', 'deletedRows'));
   }

    public function stats()
    {
        $activeEnabledOffers = Offer::where('enabled', 1)->where(function($query) {
            $query->whereNull('valid_from')->whereNull('valid_until')->orWhere(function($query) {
                $query->whereDate('valid_from', '<', date('Y-m-d'))->whereDate('valid_until', '>', date('Y-m-d'));
            });
        })->count();
        $activeDisabledOffers = Offer::where('enabled', 0)->where(function($query) {
            $query->whereNull('valid_from')->whereNull('valid_until')->orWhere(function($query) {
                $query->whereDate('valid_from', '<', date('Y-m-d'))->whereDate('valid_until', '>', date('Y-m-d'));
            });
        })->count();
        $expiredOffers = Offer::where('enabled', 1)->whereNotNull('valid_from')
            ->whereNotNull('valid_until')->whereDate('valid_until', '<', date('Y-m-d'))
            ->count();
        $futureOffers = Offer::where('enabled', 1)->whereNotNull('valid_from')
            ->whereNotNull('valid_until')->whereDate('valid_from', '>', date('Y-m-d'))
            ->count();

        return response()->success([
            'stats' => [
                'active' => [
                    'enabled' => $activeEnabledOffers,
                    'disabled' => $activeDisabledOffers,
                    'total' => $activeEnabledOffers + $activeDisabledOffers,
                ],
                'expired' => $expiredOffers,
                'future' => $futureOffers
            ]
        ]);
    }
}
