<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
	const DEFAULT_HIS_REQUEST   = 'Requesting';
	const DEFAULT_HIS_BORROWED  = 'Borrowed';
	const DEFAULT_HIS_WARNING   = 'Warning';
	const DEFAULT_HIS_RETURNED  = 'Returned';
	const DEFAULT_HIS_LOST      = 'Lost';
	const DEFAULT_HIS_CANCELLED = 'Canceled';

    protected $table ='histories';

    protected $fillable = ['start_at', 'end_at','device_id', 'status_id', 'user_id'];

    public function history_status() {
		return $this->belongsTo('App\HistoryStatus');
	}

	public function devices() {
		return $this->belongsTo('App\Device', 'device_id');
	}
}