<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = 'fields';

    protected $fillable = ['payment_method_id','name','value'];

    public function payment_method(){
    	return $this->belongsTo('App\PaymentMethod');
    }
}
