<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'nh_offer';
    protected $fillable = ['ngo_id', 'street', 'streetnumber', 'streetnumberadditional', 'zip', 'city', 'latitude', 'longitude', 'phone', 'email', 'website', 'age_from', 'age_to', 'valid_from', 'valid_until', 'disabled', 'deleted'];

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $street;

    /**
     * @var string
     */
    public $streetnumber;

    /**
     * @var string
     */
    public $streetnumberadditional;

    /**
     * @var string
     */
    public $zip;

    /**
     * @var string
     */
    public $city;

    /**
     * @var float
     */
    public $latitude;

    /**
     * @var float
     */
    public $longitude;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $website;

    /**
     * @var int
     */
    public $age_from;

    /**
     * @var int
     */
    public $age_to;

    /**
     * @var \DateTime|null
     */
    public $valid_from;

    /**
     * @var \DateTime|null
     */
    public $valid_until;

    /**
     * @var bool
     */
    public $disabled;

    /**
     * @var \DateTime|null
     */
    public $deleted;
    
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
