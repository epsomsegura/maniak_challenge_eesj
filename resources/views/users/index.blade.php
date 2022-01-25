@extends('layouts.dashboard')
@section('title','Users')
@section('content')

<link rel="stylesheet" href="{{asset('/css/users/users.css')}}">

@include('users.helpers.form')
@include('users.helpers.history')

<div class="card">
    <div class="card-body">
        <div class="row">
            @if(Auth::user()->profile_id==1)
            <div class="col-12 text-end">
                <button type="button" class="btn btn-primary float-right btn-new" id="btnNew" data-bs-target="#mdlForm" data-bs-toggle="modal">New user</button>
                <hr>
            </div>
            @endif

            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover" id="tblUsers">
                        <thead>
                            <tr>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Profile</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr>
                                <td>{{$u->name}}</td>
                                <td>{{$u->email}}</td>
                                <td>{{$u->userProfile->profile}}</td>
                                <td>
                                    <button type="button" class="btnStatus btn btn-sm btn-{{$u->status == 1 ? 'success' : 'danger'}}" data-estatus="{{$u->status}}" data-id="{{$u->idC}}">{{$u->status == 1 ? 'Active' : 'Inactive'}}</button>
                                </td>
                                <td class="text-center">
                                    @if(Auth::user()->profile_id == 1)
                                    <a href="#" data-bs-target="#mdlForm" data-bs-toggle="modal" class="btnEdit text-primary" data-id="{{$u->idC}}" data-all="{{$u}}"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btnDelete text-danger" data-id="{{$u->idC}}"><i class="fas fa-trash-alt"></i></a>
                                    @if($u->profile_id == 2)
                                    <a href="#" class="btnHistory text-secondary" data-bs-target="#mdlHistory" data-bs-toggle="modal" data-history="{{$u}}" title="Books borrowed history"><i class="fas fa-th-list"></i></a>
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

<script src="{{asset('/js/users/users.js')}}"></script>

@endsection
