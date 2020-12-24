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
                <form method="post" action="{{route('polygon.store')}}" >
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputTitle">Цена за 1 дерево</label>
                        <input type="text" name="price" class="form-control" id="exampleInputTitle" placeholder="price">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputTitle">Плотность на 10 кв. метров (1 полигон квадрата)</label>
                        <input type="text" name="density" class="form-control" id="exampleInputTitle" placeholder="price">
                    </div>

                    <input type="hidden" name="marker_id" id="marker_id">
                    <input type="hidden" name="geo" id="geo">
                    <input type="hidden" name="free_geo" id="free_geo">
                    <div class="form-group">
                        <div id="map"></div>
                    </div>

                    <button id="click" type="submit" class="btn btn-primary">Сохранить</button>
                </form>
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
{{--    <script src="https://unpkg.com/esri-leaflet@2.5.0/dist/esri-leaflet.js"--}}
{{--            integrity="sha512-ucw7Grpc+iEQZa711gcjgMBnmd9qju1CICsRaryvX7HJklK0pGl/prxKvtHwpgm5ZHdvAil7YPxI1oWPOWK3UQ=="--}}
{{--            crossorigin=""></script>--}}
    <script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>

    <script src='https://unpkg.com/@turf/turf/turf.min.js'></script>

    <script>
        var map = L.map('map').setView([47.6808461, 70.5520044], 5);

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

        });
        map.pm.setLang('ru');

        var marker = L.geoJson(<?=$marker->geo?>).addTo(map)

        $('#click').on('click', function (e) {
            var fg = L.featureGroup();
            map.eachLayer((layer)=>{
                if(layer instanceof L.Path){
                    fg.addLayer(layer);
                }
            });
            const data = fg.toGeoJSON();
            $("#marker_id").attr("value",<?=$marker->id?>)
            $("#geo").attr("value",JSON.stringify(data));
            $("#free_geo").attr("value",JSON.stringify(data));



        })
        map.on('pm:create', ({ shape,layer }) => {
            if(shape == "Rectangle"){
                var position = [];
                const polygon = layer.toGeoJSON();
                var bbox = turf.bbox(polygon);
                var area = turf.area(polygon);
                // console.log(area);
                var cellSide = 1/100;
                var options = {units: 'kilometers'};
                var squareGrid = turf.squareGrid(bbox, cellSide, options);
                // console.log(squareGrid);
                var myLayer = L.geoJSON(squareGrid).addTo(map);

                layer.remove();
            }

            // alert("finished");



        });
    </script>
@endpush

