<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Asset extends Model
{
    use SoftDeletes;
    public function category(){
    	return $this->belongsTo('App\Category');
    }

    public function vendor(){
    	return $this->belongsTo('App\Vendor');
    }

    public function asset_status(){
    	return $this->belongsTo('App\Asset_status');
    }

}
