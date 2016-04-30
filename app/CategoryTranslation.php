<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $table = 'nh_category_translation';
    protected $fillable = ['category_id', 'language_id', 'title', 'description', 'version'];

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    public function language()
    {
        return $this->hasOne('App\Language', 'id', 'language_id');
    }
}
