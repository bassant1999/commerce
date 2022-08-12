@extends('master.layout')
@section('content')
    @auth
    <h2>Categories: {{$name}}</h2>
        <div>
            @if(!$name)
                <a class="btn btn-primary" href="{{ route('category') }}" role="button">All</a>
            @else
                <a class="btn btn-secondary" href="{{ route('category') }}" role="button">All</a>
            @endif
            @foreach($categories as $category) 
                    @if($category->category)  
                        @if( ($category->category) == $name )  
                            <a class="btn btn-primary" href="{{ route('category') }}?category_name={{$category->category}}" role="button">{{$category->category}}</a> 
                        @else  
                            <a class="btn btn-secondary" href="{{ route('category') }}?category_name={{$category->category}}" role="button">{{$category->category}}</a>
                        @endif  
                    @endif  
            @endforeach
            
        </div>

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
        
    @else
        Not signed in.
    @endauth 
    
@endsection