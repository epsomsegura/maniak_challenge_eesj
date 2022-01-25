@extends('layouts.clear')
@section('title','Login')
@section('content')

<link href="{{ asset('css/auth/login.css') }}" rel="stylesheet">

<div class="full-width-container">
    <div class="full-width-content">
        <div class="form-content">
            <div class="card">
                <div class="card-body">
                    <form id="frmLogin" action="{{url('/login')}}" method="POST">
                        <fieldset>
                            @csrf
                            <h1 class="text-center"><i class="fas fa-book"></i></h1>
                            <h2 class="text-center">MANIAK Library access</h2>
                            <div class="form-group mb-3">
                                <input type="email" class="form-control text-center" id="email" name="email" placeholder="Email" title="Email" autofocus required>
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" class="form-control text-center" id="password" name="password" placeholder="Password" title="Password" required>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="rememberme" name="rememberme">
                                <label class="form-check-label" for="rememberme">
                                    Remember me
                                </label>
                            </div>
                            <div class="form-group mb-3">
                                <br>
                                <button type="submit" class="btn btn-primary btn-block" id="btnSuccess">Login</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/auth/login.js')}}"></script>

@endsection
