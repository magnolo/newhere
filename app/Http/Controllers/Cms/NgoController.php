<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Logic\Address\AddressAPI;
use App\Ngo;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class NgoController extends Controller
{
    public function index() {
        $ngos = Ngo::with(['image','users', 'offers'])->get();
          return response()->success(compact('ngos'));
    }

    public function show($id){
        $ngo = Ngo::findOrFail($id)->load(['image', 'offers']);
        return response()->json($ngo);
    }

    public function my() {
        $user = Auth::user();

        $ngo = $user->ngos()->with('image', 'users')->firstOrFail();
        if (!$ngo) {
            return response()->error('NGO not found', 404);
        }

        return response()->json($ngo);
    }

    public function myOffers(Request $request) {
        $user = Auth::user();


        $ngo = $user->ngos()->with('image', 'users', 'offers')->firstOrFail();
        if (!$ngo) {
            return response()->error('NGO not found', 404);
        }

        $myoffers = $ngo->offers()->with(['filters','categories', 'countries', 'image']);


        $count = $myoffers->count();

        if($request->has('enabled')){
            $myoffers = $myoffers->where('enabled', $request->get('enabled'));
            $count = $myoffers->count();
        }
        if($request->has('title')){
            $myoffers = $myoffers->whereTranslationLike('title', '%'.$request->get('title').'%');
            $count = $myoffers->count();
        }
        if($request->has('order')){
            $order = $request->get('order');
            $dir = 'DESC';
            if(substr($order,0,1) == '-'){
                $dir = 'ASC';
                $order = substr($order,1);
            }
            $myoffers = $myoffers->orderBy($order, $dir);
        }
        if($request->has('limit')){
            $myoffers = $myoffers->take($request->get('limit'));
        }
        if($request->has('page')){
            $myoffers = $myoffers->skip(($request->get('page') - 1) * $request->get('limit'));
        }
        $myoffers = $myoffers->get();

        $ngoPublished = $ngo->published;

        return response()->success(compact('myoffers', 'count', 'ngoPublished'));
    }

    private function storeAndSendMail($name, $email, $password)
    {
        $confirmation_code = str_random(30);

        $user = new User;
        $user->name = trim($name);
        $user->email = trim(strtolower($email));
        $user->password = bcrypt($password);
        $user->confirmation_code = $confirmation_code;
        $user->save();


        Mail::send('email.verify', $confirmation_code, function($message) use($user) {
            $message->to($user->email, $user->name)
                ->subject('Verify your email address');
        });


        return $user;
    }

    public function create(Request $request) {
        $useCmsAccount = $request->has('useCmsAccount');

        if (!$useCmsAccount) {
            $this->validate($request, [
                'organisation' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:5',
                'description' => 'max:200',
                'street' => 'required',
                'street_number' => 'required',
                'city' => 'required',
                'zip' => 'required'
            ]);
        } else {
            $this->validate($request, [
                'organisation' => 'required',
                'description' => 'max:200'
            ]);
        }

        if ($request->has('street') && $request->has('street_number') && $request->has('zip')) {
            $addressApi = new AddressAPI();
            $coordinates = $addressApi->getCoordinates($request->get('street'), $request->get('street_number'), $request->get('zip'));
        }

        DB::beginTransaction();

        if ($useCmsAccount) {
            $ngoUser = Auth::user();
        } else {
            $ngoUser = $this->storeAndSendMail($request->get('organisation'), $request->email, $request->password);
            $organisationRole = Role::where('name', 'organisation-admin')->firstOrFail();
            $ngoUser->attachRole($organisationRole);
        }

        $ngo = new Ngo();
        $ngo->organisation = $request->get('organisation');
        $ngo->website = $request->get('website');
        $ngo->contact = $request->get('contact');
        $ngo->contact_email = $request->get('contact_email');
        $ngo->contact_phone = $request->get('contact_phone');
        $ngo->street = $request->get('street');
        $ngo->street_number = $request->get('street_number');
        $ngo->zip = $request->get('zip');
        $ngo->city = $request->get('city');
        $ngo->image_id = $request->get('image_id');
        if ($coordinates) {
            $ngo->latitude = $coordinates[0];
            $ngo->longitude = $coordinates[1];
        }

        //Standard Translation
        if ($request->has('description')) {
            $locale = $request->get('language');
            $ngo->translateOrNew($locale)->description = $request->get('description');
        }
        $ngo->save();
        $ngo->users()->attach($ngoUser);

        DB::commit();
        return response()->success(compact('ngo'));
    }

    public function togglePublished(Request $request, $id) {
        $this->validate($request, [
            'published' => 'required'
        ]);

        $ngo = Ngo::find((int)$id)->load(['offers']);

        if (!$ngo) {
            return response()->error('NGO not found', 404);
        }

        $modified = false;
        if (isset($request->published)) {
            $ngo->published = (bool)$request->published;
            $modified = true;
        }

        if ($modified) {
            $ngo->save();
        }

        return response()->success(compact('ngo'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'organisation' => 'required',
            'description' => 'max:200'
        ]);

        $ngo = Ngo::find((int)$id);
        if (!$ngo) {
            return response()->error('NGO not found', 404);
        }

        if ($request->has('street') && $request->has('street_number') && $request->has('zip')) {
            $addressApi = new AddressAPI();
            $coordinates = $addressApi->getCoordinates($request->get('street'), $request->get('street_number'), $request->get('zip'));
        }


        DB::beginTransaction();
        $ngo->organisation = $request->get('organisation');
        $ngo->website = $request->get('website');
        $ngo->contact = $request->get('contact');
        $ngo->contact_email = $request->get('contact_email');
        $ngo->contact_phone = $request->get('contact_phone');
        $ngo->street = $request->get('street');
        $ngo->street_number = $request->get('street_number');
        $ngo->zip = $request->get('zip');
        $ngo->city = $request->get('city');
        $ngo->image_id = $request->get('image_id');
        if ($coordinates) {
            $ngo->latitude = $coordinates[0];
            $ngo->longitude = $coordinates[1];
        }

        //Standard Translation
        if ($request->has('description')) {
            $locale = $request->get('language');
            $ngo->translateOrNew($locale)->description = $request->get('description');
        }
        $ngo->save();
        DB::commit();

        return response()->success(compact('ngo'));
    }

    public function stats()
    {
        $publishedNgos = Ngo::where('published', 1)->count();
        $unpublishedNgos = Ngo::where('published', 0)->count();

        return response()->success([
            'stats' => [
                'published' => $publishedNgos,
                'unpublished' => $unpublishedNgos,
                'total' => $publishedNgos + $unpublishedNgos
            ]
        ]);
    }
    public function bulkAssign(Request $request, $ids){
      $ngosQ = Ngo::whereIn('id', explode(',', $ids));
      $ngos = $ngosQ->get();
      $updatedRows = $ngosQ->update([$request->get('field') => $request->get('value')]);

      return response()->success(compact('ngos', 'updatedRows'));
    }
    function bulkRemove($ids){
      $ngosQ = Ngo::whereIn('id', explode(',', $ids));
      $ngos = $ngosQ->get();
      $deletedRows = $ngosQ->delete();

      return response()->success(compact('ngos', 'deletedRows'));
    }
}
