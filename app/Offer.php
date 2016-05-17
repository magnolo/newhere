<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use Translatable;
    use SoftDeletes;


    protected $table = 'offers';
    protected $dates = ['deleted_at'];
    public $translatedAttributes = ['title', 'description', 'opening_hours'];
    protected $fillable = ['ngo_id', 'street', 'streetnumber', 'streetnumberadditional', 'zip', 'city', 'latitude', 'longitude', 'phone', 'email', 'website', 'age_from', 'age_to', 'valid_from', 'valid_until', 'enabled', 'deleted'];

    public function ngo()
    {
        return $this->hasOne('App\Ngo', 'id', 'ngo_id');
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
        return $this->belongsToMany('Webpatser\Countries\Countries', 'offer_countries', 'offer_id', 'country_id');
    }

}
