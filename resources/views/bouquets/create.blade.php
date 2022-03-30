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
                <h2 style="text-align: center"> Add Bouquet</h2>
                <br>
                <div class="card-body">
                    <form method="POST" action="/createBouquet" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <!-- Title -->
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Bouquet Name') }}</label>
                            <div class="col-md-6">
                                <!-- Added error handling -->
                                <input id="title" type="text" class="form-control @error('bouequetName') is-invalid @enderror" name="bouequetName" required autocomplete="title" autofocus>
                                @error('bouequetName')
                                <span class="alert alert-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control @error('bouequetDescription') is-invalid @enderror" name="bouequetDescription" required autocomplete="description" autofocus>
                               <!-- Added error handling -->
                                @error('bouequetDescription')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="text" class="form-control @error('bouequetPrice') is-invalid @enderror" name="bouequetPrice" required autocomplete="price" autofocus>
                               <!-- Added error handling -->
                                @error('bouequetPrice')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>



                        <!-- Type -->
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>

                            <div class="col-md-6">
                                <select name="type" id="pet-select">
                                    <option value="">--Please choose the type--</option>
                                    <option value="cascade">cascade</option>
                                    <option value="nosegay">nosegay</option>
                                    <option value="posy">posy</option>
                                    <option value="round">round</option>
                                    <option value="crescent">crescent</option>
                                </select>
                                <!-- Added error handling -->
                                @error('type')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>



                        <!-- Image -->
                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('bouquetImage') }}</label>
                            <div class="col-md-6">
                                <input type="file" name="bouquetImage" class="form-control-file @error('image') is-invalid @enderror" id="bouquetImage" />
                                <!-- Added error handling -->
                                @error('bouquetImage')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-sm-4 text-center buttons">
                                <input type="submit" class="spring-btn btn-lg btn-block" value="Add Bouquet" />
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection