<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BindClass extends Model
{
    use HasFactory;

    public static function addressPoints()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 1) {
                $markers = Marker::all();
                $addressPoints = [];
                foreach ($markers as $marker) {
                    $link = $marker->polygon ? route('polygon.show', $marker->polygon->id) : route('marker.show', $marker->id);
                    foreach (json_decode($marker->geo, 1)['features'] as $feature) {
                        $addressPoints[] = [
                            $feature['geometry']['coordinates'][0],
                            $feature['geometry']['coordinates'][1],
                            "
                    <div class='card' style='width: 18rem;'>
                      <img src='/$marker->img' class='card-img-top' alt='$marker->title'>
                      <div class='card-body'>
                        <h5 class='card-title'>$marker->title</h5>
                        <p class='card-text'>$marker->description</p>
                        <a href='$link' class='btn btn-primary btn-sm text-white'>Посмотреть участок</a>
                                    </div>
                    </div>
                    "
                        ];
                    }
                }
                $addressPoints = json_encode($addressPoints);
                return $addressPoints;
            } else {
                $polygons = Polygon::all();
                $addressPoints = [];
                foreach ($polygons as $polygon) {
                    $marker = $polygon->marker;
                    $link = route('plantation.show', $polygon->marker->id);
                    foreach (json_decode($marker->geo, 1)['features'] as $feature) {
                        $addressPoints[] = [
                            $feature['geometry']['coordinates'][0],
                            $feature['geometry']['coordinates'][1],
                            "
                    <div class='card' style='width: 18rem;'>
                      <img src='/$marker->img' class='card-img-top' alt='$marker->title'>
                      <div class='card-body'>
                        <h5 class='card-title'>$marker->title</h5>
                        <p class='card-text'>$marker->description</p>
                        <a href='$link' class='btn btn-primary btn-sm text-white'>Посмотреть участок</a>
                                    </div>
                    </div>
                    "
                        ];
                    }
                }
                $addressPoints = json_encode($addressPoints);
                return $addressPoints;
            }
        }
        $polygons = Polygon::all();
        $addressPoints = [];
        foreach ($polygons as $polygon) {
            $marker = $polygon->marker;
            $link = route('plantation.show', $polygon->id);
            foreach (json_decode($marker->geo, 1)['features'] as $feature) {
                $addressPoints[] = [
                    $feature['geometry']['coordinates'][0],
                    $feature['geometry']['coordinates'][1],
                    "
                    <div class='card' style='width: 18rem;'>
                      <img src='/$marker->img' class='card-img-top' alt='$marker->title'>
                      <div class='card-body'>
                        <h5 class='card-title'>$marker->title</h5>
                        <p class='card-text'>$marker->description</p>
                        <a href='$link' class='btn btn-primary btn-sm text-white'>Посмотреть участок</a>
                                    </div>
                    </div>
                    "
                ];
            }
        }
        $addressPoints = json_encode($addressPoints);
        return $addressPoints;
    }
}
