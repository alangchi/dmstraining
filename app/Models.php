<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    protected $table = 'models';

    protected $fillable = ['name'];

    public function devices() {
		return $this->hasMany('App\Device');
	}
}
