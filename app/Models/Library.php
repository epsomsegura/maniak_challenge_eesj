<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    protected $table = "library";
    public $timestamps = false;

    protected $fillable = [
        "book_id",
        "user_id",
        "borrow_date",
        "return_date"
    ];

    public function libraryUser(){
        return $this->hasOne(User::class,"id","user_id");
    }
    public function libraryBook(){
        return $this->hasOne(Book::class,"id","book_id");
    }
}
