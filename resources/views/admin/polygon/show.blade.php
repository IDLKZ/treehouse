@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css"/>
    <link rel="stylesheet" href="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.css" />    <!-- Make sure you put this AFTER Leaflet's CSS -->

    <style>
        .plus {
            position: fixed;
            bottom: 40px;
            right: 120px;
            font-size: 16px;
            font-weight: 700;
            z-index: 2000;
        }

    </style>
@endpush

@section('content')

    <div class="container">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="map"></div>
                </div>
            </div>
        </div>


    </div>

@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>
    <script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>
    <script src='https://unpkg.com/@turf/turf/turf.min.js'></script>

    <script>

        var map = L.map('map').setView([<?=$TIMA[1]?>, <?=$TIMA[0]?>], 17);

        // FeatureGroup is to store editable layers
        map.pm.addControls({
            position: 'topleft',
            drawCircle: false,
            drawCircleMarker:false,
            tooltips:true,
            drawPolyline:false,
            dragMode:false,
            cutPolygon:false,
            drawPolygon:false,
            editMode:false,
            drawMarker:false,
            drawRectangle:false,
            removalMode: false
        });
         map.pm.setLang('ru');

        function freeGeo(){
            return{
                fillColor:"white",
                weight: 5,
                color: 'grey',
                dashArray: '',
                fillOpacity: 0.7
            }
        }
        function selledGeo(){
            return{
                fillColor:"blue",
                weight: 5,
                color: 'red',
                dashArray: '',
                fillOpacity: 0.7
            }
        }


        var marker = L.geoJson(<?=$marker?>).addTo(map);
        var layout = L.geoJson([<?=$polygon->free_geo?>],{style:freeGeo()}).addTo(map);
        var layout2 = L.geoJson([<?=$polygon->selled_geo?>],{style:selledGeo()}).addTo(map);

    </script>
@endpush
