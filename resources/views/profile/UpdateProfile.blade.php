<?php 

use App\Common;

?>

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <br>
                <h2 style="text-align: center"> Update User Information</h2>
                <br>
                <div class="card-body">
                <form method="POST" action="/UserUpdate/{{$data['id']}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Title -->
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('title') is-invalid @enderror"
                                    name="name" value="{{$data->name}}" required autocomplete="title" autofocus>
                                @error('title')
                                <span class="alert alert-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{$data->email}}" required autocomplete="title" autofocus>
                                @error('email')
                                <span class="alert alert-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                                    name="address" value="{{$data->address}}" required autocomplete="title" autofocus>
                                @error('address')
                                <span class="alert alert-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number') }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{$data->phone}}" required autocomplete="title" autofocus>
                                @error('phone')
                                <span class="alert alert-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                       
                        <br>
                        <div class="form-group row justify-content-center">
                            <div class="col-sm-4 text-center buttons">
                                <input type="submit" class="spring-btn btn-lg btn-block" value="Save Changes" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection