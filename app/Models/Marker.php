<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class Marker extends Model
{
    use HasImageUploads;
    protected $table = "markers";
    // assuming `users` table has 'cover', 'avatar' columns
    // mark all the columns as image fields
    protected static $imageFields = [
        'img' => [
            // what disk you want to upload, default config('imageup.upload_disk')
            'disk' => 'local',

            // a folder path on the above disk, default config('imageup.upload_directory')
            'path' => 'uploads',
        ]
    ];
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'alias' => [
                'source' => 'title'
            ]
        ];
    }

//    protected $casts = [
//        'geo' => 'json'
//    ];
    use HasFactory;
    protected $fillable = ['title', 'description', 'img', 'geo', 'alias'];
    public function polygon()
    {
        return $this->hasOne(Polygon::class, 'marker_id', 'id');
    }

    public function add($request)
    {
        $marker = new self();
        $marker->title = $request['title'];
        $marker->description = $request['description'];
        $marker->geo = $request['geo'];
        if ($request->hasFile('img')) {
        $marker->uploadImage($request->file('img', 'img'));
        }
        $marker->save();

        return $marker;
    }
}
