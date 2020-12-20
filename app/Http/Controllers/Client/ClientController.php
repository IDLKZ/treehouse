<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\Polygon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function allTrees(){
        $polygons = Polygon::paginate(15);
        return view("client.polygon.index",compact("polygons"));
    }

    public function growTree($id){
        $polygon = Polygon::find($id);
        $marker = $polygon->marker->geo;
        $TIMA = ( json_decode($polygon->marker->geo))->features[0]->geometry->coordinates;
        return view("client.polygon.show",compact("polygon","marker","TIMA"));
    }

    public function buyTree(Request $request){
        $polygon = Polygon::find($request["polygon_id"]);
        $polygon->free_geo = $request["free_geo"];
        $polygon->selled_geo = $request["selled_geo"];
        $polygon->save();
        $owner = Owner::create([
           "user_id" => Auth::id(),
           "polygon_id" => $polygon->id,
            "selled_geo"=>$request["buyed_geo"],
        ]);
        $owner->save();
        return redirect()->back();
    }

    public function myTree(){
        $owners = Owner::where("user_id",Auth::id())->with(["user","polygon"])->paginate(15);
        return view("client.my_tree",compact("owners"));
    }

    public function myPolygon($id){
        $owner = Owner::find($id);
        $TIMA = ( json_decode($owner->polygon->marker->geo))->features[0]->geometry->coordinates;

        return view("client.my_polygon",compact("owner","TIMA"));


    }
}
