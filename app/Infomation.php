<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Infomation extends Model
{
    
	protected $table = 'infomations';

	protected $fillable = ['name'];


    public function deviceInfo() {
		return $this->hasMany('App\DeviceInfomation');
	}
}
