<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polygon extends Model
{
    use HasFactory;
    protected $fillable = ["marker_id","price","density","geo","free_geo"];




    public function marker(){
        return $this->belongsTo(Marker::class,"marker_id","id");
    }

    public static function add($request){
        $model = new self();
        $model->fill($request);
        $model->save();
    }


}
