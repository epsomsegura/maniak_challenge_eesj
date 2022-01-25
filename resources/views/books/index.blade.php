@extends('layouts.dashboard')
@section('title','Books')
@section('content')

<link rel="stylesheet" href="{{asset('/css/books/books.css')}}">

@include('books.helpers.form')

<input type="hidden" id="categories_list" value="{{$categories}}">

<div class="card">
    <div class="card-body">
        <div class="row">
            @if(Auth::user()->profile_id==1)
            <div class="col-12 text-end">
                <button type="button" class="btn btn-primary float-right btn-new" id="btnNew" data-bs-target="#mdlForm" data-bs-toggle="modal">New book</button>
                <hr>
            </div>
            @endif

            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover" id="tblBooks">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Publication date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $b)
                            <tr>
                                <td>{{$b->name}}</td>
                                <td class="text-center">{{$b->bookCategory->name}}</td>
                                <td class="text-center">{{$b->publication_date}}</td>
                                <td class="text-center">
                                    @if($b->user_id == NULL)
                                    <strong class="text-success">In library</strong>
                                    @else
                                    <strong>Borrowed to {{$b->bookUser->name}}</strong>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(Auth::user()->profile_id == 1)
                                    <a href="#" data-bs-target="#mdlForm" data-bs-toggle="modal" class="btnEdit text-primary" data-id="{{$b->idC}}" data-all="{{$b}}"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btnDelete text-danger" data-id="{{$b->idC}}"><i class="fas fa-trash-alt"></i></a>
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

<script src="{{asset('/js/books/books.js')}}"></script>

@endsection
