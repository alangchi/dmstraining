<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceStatus extends Model
{
    protected $table = 'device_status';

    protected $fillable = ['name'];

    public function devices() {
		return $this->hasMany('App\Device');
	}
}
