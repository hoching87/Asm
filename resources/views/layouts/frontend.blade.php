<!DOCTYPE html>
<html lang="en">
<style type=text/css>
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
        float: left;
    }

    .dropdown .dropbtn {

        border: none;
        outline: solid;
        color: black;

        background-color: inherit;
        font-family: inherit;
        margin: 0;
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

    .navbar a:hover,
    .dropdown:hover .dropbtn {
        background-color: white;
    }

    /*Added new class group for sort by type dropdown*/ 
    .dropdown1 {
        float: right;
    }

    .dropdown1 .dropbtn1 {

        border: none;
        outline: none;
        color: white;

        background-color: inherit;
        font-family: inherit;
        margin: 0;
    }



    .dropdown1-content1 {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown1-content1 a {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }


    .dropdown1-content1 a:hover {
        background-color: #ddd;
    }

    .dropdown1:hover .dropdown1-content1 {
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

                <nav class="p-5 mt-5 text-white navbar-light bg-black justify-content-between">

                    <div class="flex flex-col sm:flex-row">
                        <div class="navbar">
                        </div>
                        <!-- Some function only available for dmin -->
                        <a class="mt-3 hover:underline sm:mx-3 sm:mt-0" href="{{ route('home')}}">Home</a>
                        @can('isAdmin')
                        <a class="mt-3 hover:underline sm:mx-3 sm:mt-0" href="{{ route('AdminViewOrders') }}">Check Order</a>
                        <a class="mt-3 hover:underline sm:mx-3 sm:mt-0" href="{{ route('AddBouquet') }}">Add Bouquet</a>
                        <a class="mt-3 hover:underline sm:mx-3 sm:mt-0" href="{{ route('bouquets')}}">View Bouquet</a>

                        @endcan
                        <!-- Some function only available for user -->
                        @can('isUser')
                        <a class="mt-3 hover:underline sm:mx-3 sm:mt-0" href="{{ route('bouquets')}}">Shop</a>
                        <a class="mt-3 hover:underline sm:mx-3 sm:mt-0" href="{{ route('UserViewOrders') }}">Order</a>
                        <a href="{{ route('cart.list') }}" class="flex items-center">
                            <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{ Cart::getTotalQuantity()}}
                        </a>
                        @endcan


                    </div>
                    <!--This is the user dropdown -->
                    <ul class="navbar-nav ms-auto">
                        <div class="dropdown1">
                            <button class="dropbtn1">{{ Auth::user()->name }}
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown1-content1">
                                <a href="{{route('PersonalInfo',Auth::user()->id) }}">Personal Information</a>
                                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>



                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </ul>
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