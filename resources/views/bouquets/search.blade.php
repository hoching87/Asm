

                                
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @foreach ($types as $types)
                                    <a class="dropdown-item" href="{{ url('bouquets-type/'.$types->type) }}">
                                    {{$types['type']}}
                                    </a>
                                        @endforeach
                               </div>
                               <div class="row">
                               <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                                Sort By Type
                                </a>
                                
                               <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                     <a class="dropdown-item" href="{{ route('bouquets-type', [ 'type' =>'lilies' ]) }}"> lilies</a>
                                    <a class="dropdown-item"href="{{ route('bouquets-type', [ 'type' => 'orchids'] ) }}">orchids</a>
                                    <a class="dropdown-item"href="{{ route('bouquets-type', ['type' => 'roses']) }}">roses</a>
                                    <a class="dropdown-item"href="{{ route('bouquets-type', ['type' => 'tulip']) }}">tulip</a>
                                    <a class="dropdown-item"href="{{ route('bouquets-type', [ 'type' => 'peony']) }}">peony</a>
                                </div>

                               
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                                Sort By Price
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                     <a class="dropdown-item" href="{{ route('bouquets-price', ['sort' => 'Newest' ]) }}"> Newest</a>
                                    <a class="dropdown-item"href="{{ route('bouquets-price', ['sort' =>'low_high' ] ) }}"style="color: #000;">Price :low - high</a>
                                    <a class="dropdown-item"href="{{ route('bouquets-price', ['sort' =>'high_low']) }}"> Price :high - low</a>
                                </div>
                                </div>
                                


