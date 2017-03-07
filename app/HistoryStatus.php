<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryStatus extends Model
{
    protected $table = 'history_status';

    protected $fillable = ['name'];

    public function histories() {
		return $this->hasMany('App\History');
	}
}
