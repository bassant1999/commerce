<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            @yield('title')  
        </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo asset('css/styles.css')?>" type="text/css"> 
    </head>
    <body>
        <h1>Auctions</h1>
        <div>
            @auth
                Signed in as <a href="{{ route('profile',['uid'=>auth()->user()->id ]) }}"><strong>{{auth()->user()->name}}</strong></a>.
            @else
            @endauth
        </div>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">Active Listings</a>
            </li>
            @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('category') }}">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('showWatchlist') }}">Watchlist</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('create') }}">Create Listing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('createdList') }}">Created Listing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('notifications') }}">Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('signout') }}">Log Out</a>
                    </li>
            @else
                <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Log In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register-user') }}">Register</a>
                </li>
            @endauth
        </ul>
        <hr>
        
        @yield('content')  
    </body>
</html>
