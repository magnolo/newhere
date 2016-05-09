<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ngo extends Model
{
    protected $table = 'ngos';
    protected $fillable = ['organisation', 'street', 'zip', 'city', 'phone', 'email', 'website', 'description', 'contact', 'contact_email'];

    protected $hidden = ['password'];

    public function offers()
    {
        return $this->hasMany('App\Offer', 'ngo_id', 'id');
    }
}
