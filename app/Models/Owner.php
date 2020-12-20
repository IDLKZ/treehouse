<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = ["user_id","polygon_id","selled_geo"];

    public function user(){
        return $this->belongsTo(User::class,"user_id","id");
    }

    public function polygon(){
        return $this->belongsTo(Polygon::class,"polygon_id","id");
    }

}
