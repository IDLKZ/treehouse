<?php

namespace App\Http\Controllers;

use App\Models\BindClass;
use App\Models\Polygon;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('front.main');
    }

    public function plantation()
    {
        $addressPoints = BindClass::addressPoints();
        return view('front.plantation.index', compact('addressPoints'));
    }

    public function show($id)
    {
        $polygon = Polygon::find($id);
        $marker = $polygon->marker->geo;
        $TIMA = ( json_decode($polygon->marker->geo))->features[0]->geometry->coordinates;
        return view('front.plantation.show', compact('TIMA', 'polygon', 'marker'));
    }
}
