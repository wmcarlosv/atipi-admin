<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $table = 'channels';

    protected $fillable = ['user_id','name','description','cover','country_id','category_id'];

    public function country(){
    	return $this->belongsTo('App\Country');
    }

    public function category(){
    	return $this->belongsTo('App\Category');
    }

    public function links(){
    	return $this->hasMany('App\Link','channel_id');
    }
}
