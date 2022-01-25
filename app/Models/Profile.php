<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = "profiles";
    public $timestamps = true;

    protected $fillable = [
        'id',
        'profile',
        'created_at',
        'updated_at'
    ];

    public function profileUsers(){
        return $this->hasMany(User::class,'profile_id','id');
    }
}
