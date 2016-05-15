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

class OfferController extends Controller
{
    public function index() {
        $ngos = Ngo::with(['image','users', 'offers'])->get();
        return response()->json($ngos);
    }


    public function autocomplete($search) {
      return response()->json(['Abigail', 'Conny The Duck']);
   }

    public function show($id) {
        $ngo = Ngo::findOrFail($id);
        return response()->json($ngo);
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

        /*
        Mail::send('email.verify', $confirmation_code, function($message) use($user) {
            $message->to($user->email, $user->name)
                ->subject('Verify your email address');
        });
        */

        return $user;
    }

    public function create(Request $request) {
        /*$useCmsAccount = $request->has('useCmsAccount');
        if (!$useCmsAccount) {
            $this->validate($request, [
                'organisation' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'description' => 'max:200'
            ]);
        } else {
            $this->validate($request, [
                'organisation' => 'required',
                'description' => 'max:200'
            ]);
        }*/

        $this->validate($request, [
            'language'    => 'required|min:2|max:2',
            'title' => 'required|max:255',
            'description' => 'required',
            'streetnumberadditional' => 'required'

        ]);

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

        $offer->latitude = 0;
        $offer->longitude = 0;

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

    public function togglePublished(Request $request, $id) {
        $this->validate($request, [
            'published' => 'required'
        ]);

        $ngo = Ngo::find((int)$id);
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

        //Standard Translation
        if ($request->has('description')) {
            $locale = $request->get('language');
            $ngo->translateOrNew($locale)->description = $request->get('description');
        }
        $ngo->save();
        DB::commit();

        return response()->success(compact('ngo'));
    }
}
