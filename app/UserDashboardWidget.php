<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDashboardWidget extends Model
{
    protected $table = 'user_dashboard_widgets';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function dashboardWidget()
    {
        return $this->belongsTo('App\DashboardWidget');
    }
}
