<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marker;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $markers = Marker::all();
        $addressPoints = [];
        foreach ($markers as $marker) {

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
                        <a href='' class='btn btn-primary'>Посадить лес тут</a>
                                    </div>
                    </div>
                    "
                ];
            }
        }
        $addressPoints = json_encode($addressPoints);
        return view('admin.marker.index', compact('markers', 'addressPoints'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.marker.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'required', 'description' => 'required', 'img' => 'required', 'geo' => 'required']);
        (new Marker)->add($request);
        return redirect(route('marker.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marker = Marker::find($id);
        $TIMA = (json_decode($marker->geo))->features[0]->geometry->coordinates;
        return view('admin.marker.show', compact('marker', 'TIMA'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
