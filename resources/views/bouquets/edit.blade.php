

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <br>
                <h2 style="text-align: center"> Edit Bouquet Details</h2>
                <br>
                
                <div class="card-body">
                <form method="POST" action="UpdateBouquet" enctype="multipart/form-data">
                    
                        @csrf
                        <input type='hidden' name='id' value="{{$bouquet->id}}">

                        <!-- Title -->
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Bouequet Name') }}</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('bouequetName') is-invalid @enderror"
                                    name="bouequetName" value="{{$bouquet->bouequetName}}" required autocomplete="title" autofocus>
                                    @if ($errors->has('bouequetName'))
                    <span class="text-danger">{{ $errors->first('bouequetName') }}</span>
                @endif

                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group row">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text"
                                    class="form-control @error('bouequetDescription') is-invalid @enderror" name="bouequetDescription"
                                    value="{{$bouquet->bouequetDescription}}" required autocomplete="description" autofocus>
                                    @if ($errors->has('bouequetDescription'))
                    <span class="text-danger">{{ $errors->first('bouequetDescription') }}</span>
                @endif
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="text" class="form-control @error('bouequetPrice') is-invalid @enderror"
                                    name="bouequetPrice" value="{{$bouquet->bouequetPrice}}" required autocomplete="price" autofocus>
                                 @if ($errors->has('bouequetPrice'))
                    <span class="text-danger">{{ $errors->first('bouequetPrice') }}</span>
                @endif
                                
                            </div>
                        </div>

                      

                        <!-- Type -->
                        <div class="form-group row">
                            <label for="type"
                                class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>

                            <div class="col-md-6">
                            <select name="type" id="pet-select">
                            <option value="{{$bouquet->type}}">--Please choose the type--</option>
                            <option value="cascade">cascade</option>
                            <option value="nosegay">nosegay</option>
                            <option value="posy">posy</option>
                            <option value="round">round</option>
                            <option value="crescent">crescent</option>
                        </select>                               
                        
                               
                          
                            </div>
                        </div>
                        
                        <!-- Image -->
                        <div class="form-group row">
                            <label for="size" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>
                            <div class="col-md-6">
                                <input type="file" name="bouquetImage"
                                    class="form-control-file @error('image') is-invalid @enderror" id="bouquetImage" />
                                
                               
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-sm-4 text-center buttons">
                            <button type='submit'> Edit Bouquet </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection