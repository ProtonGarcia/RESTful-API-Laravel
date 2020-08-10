<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';

    const IS_ADMIN = 'true';
    const NOT_ADMIN = 'false';

    protected $table = 'users';
    protected $dates = ['deleted_at'];
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    #mutador

    public function setNameAttribute($value){
        $this->attributes['name'] = strtolower($value);
    }

    public function setEmailAttribute($value){
        $this->attributes['email'] = strtolower($value);
    }

    #accesores
    public function getNameAttribute($value){
       # return ucfirst($value);
       return ucwords($value);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    


    public function isVerified()
    {
        return $this->verified == User::VERIFIED_USER;
    }

    public function isAdmin()
    {
        return $this->admin == User::IS_ADMIN;
    }

    public static function verificationTokenGenerator(){
        return str_random(40);
    }
}
