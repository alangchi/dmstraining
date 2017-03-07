<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufactory extends Model
{
    protected $table = 'manufactories';

    protected $fillable = [
        'name'
    ];

    public function devices() {
		return $this->hasMany('App\Device');
	}
}
