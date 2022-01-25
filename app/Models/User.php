<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";
    public $timestamps = true;

    protected $fillable = [
        'id',
        'profile_id',
        'name',
        'email',
        'password',
        'remember_token',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    #region JWT
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }
    #endregion JWT


    #region relationships
    public function userProfile(){
        return $this->hasOne(Profile::class,'id','profile_id');
    }

    public function userLibrary(){
        return $this->hasMany(Library::class,'user_id','id');
    }
    #endregion relationships
}
