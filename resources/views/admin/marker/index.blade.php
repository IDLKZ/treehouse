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
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Наименование</th>
                <th scope="col">Описание</th>
                <th scope="col">Изображения</th>
            </tr>
            </thead>
            <tbody>
            @foreach($markers as $list)
                <tr>
                    <th scope="row">{{$loop->index+1}}</th>
                    <td>{{$list->title}}</td>
                    <td>{!! $list->description !!}</td>
                    <td>
                        <a href="{{route('marker.show', $list->id)}}" class="btn btn-dark">Посмотреть</a>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>


        <a href="{{route('marker.create')}}"><button class="btn btn-success btn-lg rounded-circle plus">+</button></a>
    </div>

@endsection


