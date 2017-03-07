<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
	const DEFAULT_DEVICE_AVAILABLE = 'Available';   
	const DEFAULT_DEVICE_UNAVAILABLE = 'Unavailable';
	const DEFAULT_DEVICE_BROKEN = 'Broken';
	const DEFAULT_DEVICE_LOST = 'Lost';

    protected $table = 'devices';

    protected $fillable = [
        'name', 'device_code','description', 'image', 'type_id','status_id', 'manufatory_id', 'version_id', 'model_id', 'os_id' 
    ];

    public function DeviceInfo() {
		return $this->hasMany('App\DeviceInfomation');
	}

	public function DeviceHistories() {
		return $this->belongsToMany('App\History');
	}

	public function types() {
		return $this->belongTo('App\Type');
	}

	public function deviceStatus() {
		return $this->belongTo('App\DeviceStatus');
	}

	public function manufactories() {
		return $this->belongTo('App\Manufactory');
	}

	public function Versions() {
		return $this->belongTo('App\Version');
	}

	public function models() {
		return $this->belongTo('App\Models');
	}

	public function Os() {
		return $this->belongTo('App\Os');
	}
}
