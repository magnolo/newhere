<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Dimsav\Translatable\Translatable;

class Ngo extends Model
{
    use Translatable;

    protected $table = 'ngos';
    public $translatedAttributes = ['description'];
    protected $fillable = ['organisation', 'street', 'street_number','zip', 'city', 'website', 'contact', 'contact_email', 'contact_phone'];

    public function offers()
    {
        return $this->hasMany('App\Offer', 'ngo_id', 'id');
    }
    public function users(){
      return $this->belongsToMany('App\User', 'ngo_users');
    }
    public function image(){
        return $this->hasOne('App\Image', 'image_id');
    }

}
