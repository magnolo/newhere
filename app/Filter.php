<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $table = 'nh_filter';
    protected $fillable = ['filterkey', 'icon', 'disabled'];
    
}
