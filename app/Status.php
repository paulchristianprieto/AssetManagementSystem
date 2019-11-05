<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function user_requests(){
        return $this->hasMany('App\User_request');
    }
}
