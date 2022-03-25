<!-- Pages of user to edit order, only reciever name, address, and phone are able to edit-->
@foreach($orderList as $orderList)
    <form method="POST" action="{{route('EditOrder',['order_id'=>$orderList->order_id]) }}" enctype="multipart/form-data">
                        @csrf
                       
                    
                        <!-- Title -->
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Reciever') }}</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('reciever_name') is-invalid @enderror"
                                    name="reciever_name" value="{{$orderList->reciever_name}}" required autocomplete="title" autofocus>
                                @error('reciever_name')
                                <span class="alert alert-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <input id="reciever_address" type="text" class="form-control @error('reciever_address') is-invalid @enderror"
                                    name="reciever_address" value="{{$orderList->reciever_address}}" required autocomplete="title" autofocus>
                                @error('reciever_address')
                                <span class="alert alert-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>
                            <div class="col-md-6">
                                <input id="reciever_phone" type="text" class="form-control @error('reciever_phone') is-invalid @enderror"
                                    name="reciever_phone" value="{{$orderList->reciever_phone}}" required autocomplete="title" autofocus>
                                @error('reciever_phone')
                                <span class="alert alert-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                       

                     
                        <div class="form-group row justify-content-center">
                            <div class="col-sm-4 text-center buttons">
                                <input type="submit" class="spring-btn btn-lg btn-block" value="Edit" />
                            </div>
                        </div>
                    </form>   @endforeach