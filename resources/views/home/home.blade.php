@extends('layouts.dashboard')
@section('title','Home')
@section('content')

<link rel="stylesheet" href="{{asset('/css/home/home.css')}}">

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="jumbotron text-center">
                    <h3>{{$books}}</h3>
                    <h2>Books registered</h2>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="jumbotron text-center">
                    <h3>{{$categories}}</h3>
                    <h2>Categories registered</h2>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="jumbotron text-center">
                    <h3>{{$readers}}</h3>
                    <h2>Readers registered</h2>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
