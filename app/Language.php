<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'nh_language';
    protected $fillable = ['language', 'default_language', 'published', 'disabled'];

    /**
     * @var int
     */
    public $id;

    /**
     * @var bool
     */
    public $default_language;

    /**
     * @var bool
     */
    public $published;

    /**
     * @var bool
     */
    public $disabled;
}
