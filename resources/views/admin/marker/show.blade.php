@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css"/>
    <style>
        .plus {
            position: absolute;
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
        <div id="map"></div>

        <a href="{{route('marker.create')}}"><button class="btn btn-success btn-lg rounded plus">Создать поле</button></a>
    </div>

@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>
    <script src="https://unpkg.com/esri-leaflet@2.5.0/dist/esri-leaflet.js"
            integrity="sha512-ucw7Grpc+iEQZa711gcjgMBnmd9qju1CICsRaryvX7HJklK0pGl/prxKvtHwpgm5ZHdvAil7YPxI1oWPOWK3UQ=="
            crossorigin=""></script>
    <script>
        var map = L.map('map').setView([<?=$TIMA[1]?>, <?=$TIMA[0]?>], 17);
        L.esri.basemapLayer('Imagery').addTo(map);
        L.esri.basemapLayer('ImageryLabels').addTo(map);
        // L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        //     attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        // }).addTo(map);
        // FeatureGroup is to store editable layers
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);
        var drawControl = new L.Control.Draw({
            draw: {
                polygon: false,
                rectangle: true,
                marker: false,
                polyline: false,
                circle: false
            },
            edit: {
                featureGroup: drawnItems
            }
        });
        map.addControl(drawControl);

        map.on('draw:created', function (e) {
            var layer = e.layer,
                feature = layer.feature = layer.feature || {};

            feature.type = feature.type || 'Feature';
            var props = feature.properties = feature.properties || {};

            drawnItems.addLayer(layer);
        })

        var marker = L.geoJson(<?=$marker->geo?>).addTo(map)

        $('#click').on('click', function () {
            var res = $('#hidden').attr('value', JSON.stringify(drawnItems.toGeoJSON()))
            console.log(res)
            // var data_geo = document.getElementById('').innerHTML;
            {{--if (data_geo=='{"type":"FeatureCollection","features":[]}') {--}}
            {{--    alert('empty')--}}
            {{--} else {--}}
            {{--    $.ajax({--}}
            {{--        url: "{{route('sendJson')}}",--}}
            {{--        type: 'POST',--}}
            {{--        data: {--}}
            {{--            result: JSON.stringify(drawnItems.toGeoJSON()),--}}
            {{--            _token: "{{ csrf_token() }}",--}}
            {{--        },--}}
            {{--        success: function (data) {--}}
            {{--            $('#result').html(data)--}}
            {{--        }--}}
            {{--    })--}}
            {{--}--}}

        })
    </script>
@endpush

