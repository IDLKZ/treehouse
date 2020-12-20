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
                <th scope="col">ФИО посадчика</th>
                <th scope="col">Участок</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($owners as $list)
                <tr>
                    <th scope="row">{{$loop->index+1}}</th>
                    <td>{{$list->user->name}}</td>
                    <td>{{$list->polygon->marker->title}}</td>
                    <td>
                        <a href="{{route('my-polygon', $list->id)}}" class="btn btn-dark">Посмотреть</a>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>


    </div>

@endsection

