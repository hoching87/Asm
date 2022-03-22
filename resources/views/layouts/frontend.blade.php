<!DOCTYPE html>
<html lang="en">
<style>
    .navbar {
        overflow: hidden;
        background-color: #333;
    }

    .navbar a {
        float: right;
       
        color: white;
        text-align: center;
        
        text-decoration: none;
    }

    .dropdown {
        float: right;
        overflow: hidden;
    }

    .dropdown .dropbtn {
       
        border: none;
        outline: none;
        color: white;
        
        background-color: inherit;
        font-family: inherit;
        margin: 0;
    }

    .navbar a:hover,
    .dropdown:hover .dropbtn {
        background-color: red;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    .dropdown-content a:hover {
        background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add to cart</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Flower Shop</title>
    <link rel="icon" href="https://th.bing.com/th/id/OIP.-UIdA1S5NEEky2d4yG9nGQHaHa?w=169&h=180&c=7&r=0&o=5&pid=1.7" type="image/x-icon">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!--Icon-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="bg-white">
        <header>
            <div class="container px-6 py-3 mx-auto">
                <div class="flex items-center justify-between">


                    <div class="flex items-center justify-end w-full">
                        <button" class="mx-4 text-gray-600 focus:outline-none sm:mx-0">

                            </button>
                    </div>
                </div>
                <nav class="p-6 mt-4 text-white bg-black sm:flex sm:justify-center sm:items-center">
                    <div class="flex flex-col sm:flex-row">
                        <div class="navbar">
                            
                            
                        </div>
                        <a class="mt-3 hover:underline sm:mx-3 sm:mt-0" href="{{ route('home')}}">Home</a>

                        <div class="dropdown" >
                                <button class="dropbtn" >User
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-content">
                                    <a href="{{route('PersonalInfo',Auth::user()->id) }}">Personal Information</a>
                                    <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                   
                                    

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @can('isUser')
                        <a class="mt-3 hover:underline sm:mx-3 sm:mt-0" href="{{ route('products.list')}}">Shop</a>
                        <a href="{{ route('cart.list') }}" class="flex items-center">
                            <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{ Cart::getTotalQuantity()}}
                        </a>
                        @endcan
                    </div>
                </nav>

            </div>
        </header>
        <div id="app">



        </div>
        <main class="my-8">
            @yield('content')
        </main>

    </div>
</body>

</html>