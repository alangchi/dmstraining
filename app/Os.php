<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Os extends Model
{
    protected $table = 'os';

    protected $fillable = ['name'];

    public function devices() {
		return $this->hasMany('App\Device');
	}
}
