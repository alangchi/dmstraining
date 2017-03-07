<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $table = 'versions';

    protected $fillable = [
        'name'
    ];

    public function devices() {
		return $this->hasMany('App\Device');
	}
}
