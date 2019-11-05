<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_request extends Model
{

    use SoftDeletes;
    public function status(){
    	return $this->belongsTo('App\Status');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function category(){
    	return $this->belongsTo('App\Category');
    }

    public function assets(){
    	return $this->belongsToMany('App\Assets', 'asset_request')
    		->withPivot('quantity')
    		->withTimestamps();
    }

}
