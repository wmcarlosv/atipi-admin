<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';

    protected $fillable = ['name'];

    public function fields(){
    	return $this->hasMany('App\Field','payment_method_id');
    }
}
