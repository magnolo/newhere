<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferTranslation extends Model
{

    protected $fillable = ['title', 'description', 'opening_hours'];
}
