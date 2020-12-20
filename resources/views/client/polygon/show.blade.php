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
                    <form action="{{route("buyTree")}}" method="post">
                        @csrf
                        <input type="hidden" name="polygon_id" value="{{$polygon->id}}">
                        <input type="hidden" name="free_geo" id="free_geo">
                        <input type="hidden" name="selled_geo" id="selled_geo">
                        <input type="hidden" name="buyed_geo" id="buyed_geo">
                        <button type="submit" id="buy" class="btn btn-info">Купить</button>
                    </form>

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
            tooltips:true,
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


        var marker = L.geoJson(<?=$marker?>).addTo(map);
        var layout = L.geoJson([<?=$polygon->free_geo?>],{style:freeGeo(),onEachFeature: onEachFeature}).addTo(map);
        var layout2 = L.geoJson([<?=$polygon->selled_geo?>],{style:selledGeo()}).addTo(map);


        let trees = 0;
        let summ = 0;
        let price = {{$polygon->price}};
        let density = {{$polygon->density}};

        function highlightFeature(e) {
            if(e.target instanceof L.Path){
                if(Object.entries(e.target.toGeoJSON().properties).length == 0){
                    trees += density;
                    summ = trees * price;
                    var layer = e.target;
                    e.target.remove();
                    layer.toGeoJSON().properties.buy = 1;
                    L.geoJson(layer.toGeoJSON(),{style:buyedGeo(),onEachFeature: onEachFeature}).addTo(map);

                    displayData(trees,summ)
                    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                        layer.bringToFront();
                    }
                }
                else{
                    deleteTree(e)
                    resetHighlight(e)
                }

            }
        }
        function resetHighlight(e) {
            if(e.target instanceof L.Path){
                if(e.target.toGeoJSON().properties.status != 1){
                    var layer = e.target;
                    if(layer.toGeoJSON().properties.buy != 1){
                        layer.setStyle(freeGeo());
                    }
                }
            }
        }
        function deleteTree(e){
            if(e.target instanceof  L.Path){
                if(Object.entries(e.target.toGeoJSON().properties).length > 0) {
                    if (e.target.toGeoJSON().properties.status != 1) {
                        if (e.target.toGeoJSON().properties.buy == 1) {
                            trees -= density;
                            summ = trees * price;
                            displayData(trees,summ)
                            delete e.target.toGeoJSON().properties.buy

                        }
                    }
                }
            }
        }

        function displayData(trees, summ){
            $("#quantity").text("Выбрано деревьев:" + trees + "|" + "На сумму:" + summ)
        }



        function initializeData(){
            const free = [];
            const selled = [];
            const buyed = [];
            const point = [];
            let data;
                var fg = L.featureGroup();
                map.eachLayer((layer)=>{
                    if(layer instanceof L.Path){
                        fg.addLayer(layer);
                    }
                    else{
                        point.push(layer);
                    }
                });
                data = fg.toGeoJSON();


            var f = 0;
            var s = 0;
            var b = 0;
            for(i = 0 ; i < data.features.length; i++){
                if(data.features[i].properties.buy == 1){
                    delete  data.features[i].properties.buy;
                    data.features[i].properties.owner_id = <?=@auth()->id()?>;
                    data.features[i].properties.owner = <?=@auth()->user()?>;
                    data.features[i].properties.status = 1;
                    buyed[b] = data.features[i];
                    b++;

                }
                else if(data.features[i].properties.status == 1){
                    selled[s] = data.features[i];
                    s++;
                }
                else{
                    free[f] = data.features[i];
                    f++;
                }
            }
            if(buyed.length > 0){
                for (i= 0 ; i<buyed.length; i++){
                    selled.push(buyed[i]);
                }
            }
            var free_json = L.geoJson(free).toGeoJSON();
            var buyed_json = L.geoJson(buyed).toGeoJSON();
            var selled_json = L.geoJson(selled).toGeoJSON();


            $('#free_geo').attr("value",JSON.stringify(free_json))
            $('#buyed_geo').attr("value",JSON.stringify(buyed_json))
            $('#selled_geo').attr("value",JSON.stringify(selled_json))
            console.log(free_json);
            console.log(buyed_json);
            console.log(selled_json);

        }

        function onEachFeature(feature, layer) {
            layer.on({
                click: highlightFeature,
            });
        }
        $("#buy").on("click",function (e){
            initializeData();
        })











    </script>
@endpush

