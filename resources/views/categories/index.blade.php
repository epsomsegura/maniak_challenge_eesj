@extends('layouts.dashboard')
@section('title','Categories')
@section('content')

<link rel="stylesheet" href="{{asset('/css/categories/categories.css')}}">

@include('categories.helpers.form')
@include('categories.helpers.list')

<div class="card">
    <div class="card-body">
        <div class="row">
            @if(Auth::user()->profile_id==1)
            <div class="col-12 text-end">
                <button type="button" class="btn btn-primary float-right btn-new" id="btnNew" data-bs-target="#mdlForm" data-bs-toggle="modal">New category</button>
                <hr>
            </div>
            @endif

            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover" id="tblUsers">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Books registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $c)
                            <tr>
                                <td>{{$c->name}}</td>
                                <td>{{$c->description}}</td>
                                <td class="text-center">{{$c->categoryBooks->count()}}</td>
                                <td class="text-center">
                                    @if(Auth::user()->profile_id == 1)
                                    <a href="#" data-bs-target="#mdlForm" data-bs-toggle="modal" class="btnEdit text-primary" data-id="{{$c->idC}}" data-all="{{$c}}"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btnDelete text-danger" data-id="{{$c->idC}}"><i class="fas fa-trash-alt"></i></a>
                                    @if($c->categoryBooks->count() > 0)
                                    <a href="#" class="text-secondary btnBooks" data-info="{{$c}}"data-bs-target="#mdlBooks" data-bs-toggle="modal" title="Category book list"><i class="fas fa-th-list"></i></a>
                                    @endif
                                    @else {{'-'}}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('/js/categories/categories.js')}}"></script>

@endsection
