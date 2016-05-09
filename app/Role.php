<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    //

    public function users(){
      return $this->belongsToMany('App\User', 'role_user', 'user_id', 'role_id');
    }
}
