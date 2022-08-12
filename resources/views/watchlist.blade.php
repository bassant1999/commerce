@extends('master.layout')
@section('content')
    @auth
        <h2>Watchlist</h2>
        <div class="container-fluid items">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
            @foreach($listings as $listing)  
                <div class="row">
                    @if($listing->img_url)   
                        <div class="col-md-4">
                            <img src="images/{{$listing->img_url}}" alt ="image" class = "images">
                        </div>
                    @endif   
                    <div class="col-md-8 desc">
                        <h3 class="head">
                            <a href="{{ route('listing',['listing'=> $listing->id ]) }}">{{$listing->title}}</a>
                            <a class="btn btn-danger" href="{{ route('remove',['lid'=> $listing->id ]) }}">Remove</a>
                        </h3>
                        <p><strong>Price: </strong>${{$listing->price}}</p>
                        <p class="date">{{$listing->date}}</p>
                    </div>
                </div> 
            @endforeach  
        </div>
    @else
        Not signed in.
    @endauth 
    
@endsection