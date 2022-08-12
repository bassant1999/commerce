@extends('master.layout')
 
@section('content')
    @auth
        <!-- put messages here -->
        @if (Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! Session::get('success') !!}</li>
                    </ul>
                </div>
        @endif
        <div class="container profile">
            <div class="row">
                <div class="col-md-2">
                    <i class="material-icons" style="font-size:150px;color:rgb(170, 237, 237)">account_circle</i>
                </div>
                <div class="col-md-10">
                    <h1>{{$owner->name}}</h1>
                    <p>Number of created listing: <strong>{{$nlistings}}</strong></p>
                    <p>Number of bids: <strong>{{$nbids}}</strong></p>
                </div>
            </div>
        </div>
        <hr>
            
        <div class="container-fluid items">
            <h1>The Created Listings</h1>
            @foreach($listings as $listing)  
                <div class="row">
                    @if($listing->img_url)   
                        <div class="col-md-4">
                            <img src="../images/{{$listing->img_url}}" alt ="image" class = "images">
                        </div>
                    @endif  
                    <div class="col-md-8 desc">
                        <h3 class="head">
                            <a href="{{ route('listing',['listing'=> $listing->id ]) }}">{{$listing->title}}</a>
                            @if($cuser->id == $owner->id and  $listing->active == 1)
                                <button class="btn btn-primary">Active</button>
                                <a class="btn btn-secondary" href="{{ route('inactivate',['lid'=> $listing->id ]) }}">inactivate it</a>
                            @elseif($listing->active == 1)
                                <button class="btn btn-primary">Active</button>
                            @else
                                <button class="btn btn-primary">Inactive</button>
                            @endif
                        </h3>
                        <p><strong>Price: </strong>${{$listing->price}}</p>
                        <p class="date">{{$listing->created_at}}</p>
                    </div>
                </div>
            @endforeach
            
        </div>
    @else
        Not signed in
    @endauth
@endsection
