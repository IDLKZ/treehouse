@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css"/>
    <style>

    </style>
@endpush

@section('content')

    <div class="container">
        <form method="post" action="{{route('marker.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputTitle">Наименование</label>
                <input type="text" name="title" class="form-control" id="exampleInputTitle" placeholder="наименование">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Описание</label>
                <textarea name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputImg">Изображения</label>
                <input type="file" name="img">
            </div>
            <input type="hidden" name="geo" id="hidden">
            <div class="form-group">
                <div id="map"></div>
            </div>

            <button id="click" type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>

@endsection


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'description' );
        var map = L.map('map').setView([47.6808461, 70.5520044], 5);
        // FeatureGroup is to store editable layers
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);
        var drawControl = new L.Control.Draw({
            draw: {
                polygon: false,
                rectangle: false,
                marker: true,
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
