<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';
    protected $fillable = ['language', 'default_language', 'published', 'enabled'];

    public function users(){
      return $this->belongsToMany('App\User', 'user_languages');
    }
}
