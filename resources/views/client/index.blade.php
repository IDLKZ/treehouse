@extends('layouts.app')
@push('styles')
    <style>
        .plus {
            position: absolute;
            bottom: 40px;
            right: 40px;
            font-size: 24px;
            font-weight: 700;
        }
    </style>
@endpush

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Посадите ваше дерево!</h1>
            </div>
        </div>


        <a href="{{route('marker.create')}}"><button class="btn btn-success btn-lg rounded-circle plus">+</button></a>
    </div>

@endsection
