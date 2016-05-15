<?php

namespace App;

use \Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];
    protected $fillable = ['icon', 'disabled'];

    public function children()
    {
        return $this->hasMany('App\Filter', 'parent_id')->with('children');
    }

}
