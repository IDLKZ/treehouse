@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css">
    <style>
        .plus {
            position: absolute;
            bottom: 40px;
            right: 40px;
            font-size: 24px;
            font-weight: 700;
        }
        .card-img-top {
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }
        .leaflet-popup-content {width: auto;}
        .card {width: 200px!important;}
    </style>
@endpush

@section('content')

    <div class="container">
{{--        <table class="table">--}}
{{--            <thead class="thead-dark">--}}
{{--            <tr>--}}
{{--                <th scope="col">#</th>--}}
{{--                <th scope="col">Наименование</th>--}}
{{--                <th scope="col">Описание</th>--}}
{{--                <th scope="col">Изображения</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach($markers as $list)--}}
{{--                <tr>--}}
{{--                    <th scope="row">{{$loop->index+1}}</th>--}}
{{--                    <td>{{$list->title}}</td>--}}
{{--                    <td>{!! $list->description !!}</td>--}}
{{--                    <td>--}}
{{--                        <a href="{{route('marker.show', $list->id)}}" class="btn btn-dark">Посмотреть</a>--}}
{{--                    </td>--}}
{{--                </tr>--}}

{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
        <div id="map"></div>

        <a href="{{route('marker.create')}}"><button class="btn btn-success btn-lg rounded-circle plus">+</button></a>
    </div>

@endsection
@push('scripts')
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
    <script>
        var addressPoints = [<?=$addressPoints?>]
        var map = L.map('map').setView([47.6808461, 70.5520044], 5);
        L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {subdomains:['mt0','mt1','mt2','mt3']}).addTo(map);
        var markers = L.markerClusterGroup({ chunkedLoading: true, });

        for (var i = 0; i < addressPoints[0].length; i++) {
            var a = addressPoints[0][i];
            var title = a[2];
            var marker = L.marker(L.latLng(a[1], a[0]), { title: title });
            marker.bindPopup(title);
            markers.addLayer(marker);
        }
        map.addLayer(markers);
    </script>

@endpush

