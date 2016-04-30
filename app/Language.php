<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'nh_language';
    protected $fillable = ['language', 'default_language', 'published', 'disabled'];
    
}
