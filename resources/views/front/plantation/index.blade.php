@extends('welcome')
@push('styles')
    <link href="{{ asset('css/leaflet.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css">
    <style>
        .card-img-top {
            width: 100%;
            height: 198px;
            margin: 0 auto;
        }
        .leaflet-popup-content {width: auto;}
        .card {width: 200px!important;}
    </style>
@endpush
@section('content')
    <div id="map"></div>
@endsection
@push('scripts')
    <script src="{{asset('js/leaflet.js')}}"></script>
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
