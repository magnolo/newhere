<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'nh_offer';
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
        return $this->belongsToMany('App\Filter', 'nh_offer_filter', 'offer_id', 'filter_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'nh_offer_category', 'offer_id', 'category_id');
    }
}
