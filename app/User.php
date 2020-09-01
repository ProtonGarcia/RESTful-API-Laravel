<?php

namespace App;

use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens ,SoftDeletes;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';

    const IS_ADMIN = 'true';
    const NOT_ADMIN = 'false';

    protected $table = 'users';
    protected $dates = ['deleted_at'];

    #transformador
    public $transformer = UserTransformer::class;
    

    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
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
