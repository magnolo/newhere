<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferTranslation extends Model
{
    protected $table = 'nh_offer_translation';
    protected $fillable = ['language_id', 'version', 'title', 'description', 'opening_hours'];

    public function offer()
    {
        return $this->hasOne('App\Offer', 'id', 'offer_id');
    }

    public function language()
    {
        return $this->hasOne('App\Language', 'id', 'language_id');
    }
}
