<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ngo extends Model
{
    protected $table = 'nh_ngo';
    protected $fillable = ['organisation', 'street', 'zip', 'city', 'phone', 'email', 'website', 'description', 'contact', 'contact_email'];

    protected $hidden = ['password'];

    public $id;

    /**
     * @var string
     */
    public $organisation;

    /**
     * @var string|null
     */
    public $street;

    /**
     * @var string|null
     */
    public $zip;

    /**
     * @var string|null
     */
    public $city;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $website;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $contact;

    /**
     * @var string
     */
    public $contact_email;

    /**
     * @var string
     */
    public $contact_phone;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;
    
    public function offers()
    {
        return $this->hasMany('App\Offer', 'ngo_id', 'id');
    }
}
