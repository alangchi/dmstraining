<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceInfomation extends Model
{
    protected $table = 'device_infomations';

	protected $fillable = ['value', 'device_id', 'infomation_id'];


    public function deviceInfo() {
		return $this->belongTo('App\Device');
	}

	public function infomation() {
		return $this->belongTo('App\Infomation');
	}
}
