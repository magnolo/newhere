<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'nh_category';
    protected $fillable = ['icon', 'disabled'];

    /**
     * @var int
     */
    public $id;

    /**
     * @var Category
     */
    public $parent;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var bool
     */
    public $enabled;

    public function translations() {
        return $this->hasMany('App\CategoryTranslation', 'category_id', 'id');
    }

    public function children()
    {
        return $this->hasMany('App\Category', 'parent', 'id');
    }

    public function parent()
    {
        return $this->hasOne('App\Category', 'id', 'parent');
    }
}
