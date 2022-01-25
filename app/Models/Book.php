<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = "books";
    public $timestamps = true;

    protected $fillable = [
        'id',
        'category_id',
        'user_id',
        'name',
        'publication_date',
        'status',
        'created_at',
        'updated_at'
    ];

    public function bookCategory(){
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function bookUser(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function bookLibrary(){
        return $this->hasMany(Library::class,"book_id","id");
    }
}
