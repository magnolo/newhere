<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offers';
    protected $fillable = ['ngo_id', 'street', 'streetnumber', 'streetnumberadditional', 'zip', 'city', 'latitude', 'longitude', 'phone', 'email', 'website', 'age_from', 'age_to', 'valid_from', 'valid_until', 'disabled', 'deleted'];

    public function ngo()
    {
        return $this->hasOne('App\Ngo', 'id', 'ngo_id');
    }

    public function translations()
    {
        return $this->hasMany('App\OfferTranslation', 'offer_id', 'id');
    }

    public function filters()
    {
        return $this->belongsToMany('App\Filter', 'offer_filters', 'offer_id', 'filter_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'offer_categories', 'offer_id', 'category_id');
    }

    public function countries()
    {
        return $this->belongsToMany('App\Country', 'offer_countries', 'offer_id', 'country_id');
    }
}
