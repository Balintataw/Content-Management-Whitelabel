<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'is_active', 'user_id', 'photo_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role() {
        return $this->belongsTo('App\Role');
    }

    public function photo() {
        return $this->belongsTo('App\Photo');
    }
     
    public function posts() {
        return $this->hasMany('App\Post');
    }

    public function getGravatarAttribute() {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash";
    }

    public function isAdmin() {
        // ensures access only to active admins or above
        if($this->is_active == 1 && ($this->role->type == 'ADMIN' || $this->role->type == 'SUPERUSER')) {
            return true;
        } else {
            return false;
        }
    }
}
