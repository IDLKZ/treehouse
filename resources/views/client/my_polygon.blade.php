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
        #map {
            width: 100%;
            height: 450px;
        }
    </style>
@endpush

@section('content')

    <div class="container">

        <div class="container">
            <div class="row">
                <div class="col-md-12" id="quantity">

                </div>
                <div class="col-md-12">
                    <div id="map"></div>


                </div>
            </div>
        </div>


    </div>

@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>
    <script src="https://unpkg.com/esri-leaflet@2.5.0/dist/esri-leaflet.js"
            integrity="sha512-ucw7Grpc+iEQZa711gcjgMBnmd9qju1CICsRaryvX7HJklK0pGl/prxKvtHwpgm5ZHdvAil7YPxI1oWPOWK3UQ=="
            crossorigin=""></script>
    <script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>

    <script src='https://unpkg.com/@turf/turf/turf.min.js'></script>

    <script>





        var map = L.map('map').setView([<?=$TIMA[1]?>, <?=$TIMA[0]?>], 17);
        L.esri.basemapLayer('Imagery').addTo(map);
        L.esri.basemapLayer('ImageryLabels').addTo(map);
        // L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        //     attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        // }).addTo(map);
        // FeatureGroup is to store editable layers
        map.pm.addControls({
            position: 'topleft',
            drawCircle: false,
            drawCircleMarker:false,
            tooltips:false,
            drawPolyline:false,
            dragMode:false,
            cutPolygon:false,
            drawPolygon:false,
            editMode:false,
            drawMarker:false,
            drawRectangle:false,
            removalMode:false,

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
        function buyedGeo(){
            return{
                fillColor:"green",
                weight: 5,
                color: 'blue',
                dashArray: '',
                fillOpacity: 0.7
            }
        }
        function myGeo(){
            return{
                fillColor:"aqua",
                weight: 5,
                color: 'white',
                dashArray: '',
                fillOpacity: 0.7
            }
        }


        {{--var marker = L.geoJson(<?=$marker?>).addTo(map);--}}
        var layout2 = L.geoJson([<?=$owner->polygon->free_geo?>],{style:freeGeo()}).addTo(map);
        var layout2 = L.geoJson([<?=$owner->polygon->selled_geo?>],{style:selledGeo(), onEachFeature: function (feature, layer) {
                layer.on('mouseover', function () {
                    var client = layer.toGeoJSON();
                    displayData(client.properties.owner.name,client.properties.owner.email )
                });
                layer.on('mouseout', function () {
                    $("#quantity").text()
                });

            }}).addTo(map);
        var layout2 = L.geoJson([<?=$owner->selled_geo?>],{style:myGeo(),
            onEachFeature: function (feature, layer) {
                layer.on('mouseover', function () {
                    var client = layer.toGeoJSON();
                    displayData(client.properties.owner.name,client.properties.owner.email )
                });
                layer.on('mouseout', function () {
                    $("#quantity").text()
                });

            }
        }).addTo(map);



        function info(e){
            var client = e.target.toGeoJSON();
            displayData(client.properties.owner.name,client.properties.owner.email )
        }


        function displayData(name,email){
            $("#quantity").text("ФИО владельца дерева:" + name + "|" + "Почта:" + email)
        }






        $("#buy").on("click",function (e){
            initializeData();
        })

        function onEachFeature(feature, layer) {
            layer.on({
                mouseover: info,
            });
        }











    </script>
@endpush


