<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset_status extends Model
{
    public function assets(){
        return $this->hasMany('App\Asset');
    }
}
