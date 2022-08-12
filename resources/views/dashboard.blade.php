@extends('master.layout')
 
@section('content')
    <h2>Active Listings</h2>
    <div class="container-fluid items">
        @foreach($listings as $listing)  
            <div class="row">
                @if($listing->img_url)   
                    <div class="col-md-4">
                        <img src="images/{{$listing->img_url}}" alt ="image" class = "images">
                    </div>
                @endif  
                <div class="col-md-8 desc">
                    <h3 class="head"><a href="{{ route('listing',['listing'=> $listing->id ]) }}">{{$listing->title}}</a></h3>
                    <p><strong>Price: </strong>${{$listing->price}}</p>
                    <p class="date">{{$listing->created_at}}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection
