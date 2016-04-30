<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferTranslation extends Model
{
    protected $table = 'nh_offer_translation';
    protected $fillable = ['language_id', 'version', 'title', 'description', 'opening_hours'];

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $language_id;

    /**
     * @var int
     */
    public $version;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $opening_hours;

    public function offer()
    {
        return $this->hasOne('App\Offer', 'offer_id', 'id');
    }

    public function language()
    {
        return $this->hasOne('App\Language', 'language_id', 'id');
    }
}
