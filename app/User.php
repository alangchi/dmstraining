<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    const DEFAULT_ROLE_ADMIN = 'admin_master';
    const DEFAULT_ROLE_MANAGER = 'user_manager';
    const DEFAULT_ROLE_ALIAS_USER_MEMBER = 'user_member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'username', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsTo('App\Role', 'role_id');
        // return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }
}
