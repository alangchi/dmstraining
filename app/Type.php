<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';

    protected $fillable = [
        'name'
    ];

    public function devices() {
		return $this->hasMany('App\Device');
	}
}
