<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";
    public $timestamps = true;

    protected $fillable = [
        'id','name','description','created_at','updated_at'
    ];

    public function categoryBooks(){
        return $this->hasMany(Book::class,'category_id','id');
    }
}
