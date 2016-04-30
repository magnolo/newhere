<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $table = 'nh_filter';
    protected $fillable = ['filterkey', 'icon', 'disabled'];

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $filterkey;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var boolean
     */
    public $disabled;
}
