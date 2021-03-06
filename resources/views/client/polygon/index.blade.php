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
                <th scope="col">Наименование точки</th>
                <th scope="col">Цена</th>
                <th scope="col">Плотность</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($polygons as $list)
                <tr>
                    <th scope="row">{{$loop->index+1}}</th>
                    <td>{{$list->marker->title}}</td>
                    <td>{{$list->price}}</td>
                    <td>{{$list->density}}</td>
                    <td>
                        <a href="{{route('grow-tree', $list->id)}}" class="btn btn-dark">Посадить тут дерево</a>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>


    </div>

@endsection

