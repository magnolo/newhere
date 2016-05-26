<?php

namespace App;

use \Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use Translatable;

    protected $table = 'filters';
    public $translatedAttributes = ['title'];
    protected $fillable = ['parent_id', 'icon', 'enabled'];

    public function children()
    {
        return $this->hasMany('App\Filter', 'parent_id')->with('children');
    }
    public function parent()
    {
        return $this->hasOne('App\Filter', 'id', 'parent_id');
    }

}
