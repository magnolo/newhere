<?php

namespace App;

use \Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['icon', 'disabled', 'title', 'description'];

    public function children()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id')->with('children');
    }

    public function parent()
    {
        return $this->hasOne('App\Category', 'id', 'parent_id');
    }
    public function offers()
    {
        return $this->belongsToMany('App\Offer', 'offer_categories', 'category_id', 'offer_id');
    }
}
