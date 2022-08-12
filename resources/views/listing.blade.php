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

        @if (Session::has('fail'))
            <div class="alert alert-warning">
                <ul>
                    <li>{!! Session::get('fail') !!}</li>
                </ul>
            </div>
        @endif

        <h1 style="margin-bottom:20px; color:rgb(91, 90, 90)">Listing: {{$listing->title}}</h1>
        <a class="btn btn-primary" href ="{{ route('watchlist',['lid'=> $listing->id ]) }}">Add to Watchlist</a>
        <div class="listing">
            @if($listing->img_url)   
                <div>
                    <img src="../../public/images/{{$listing->img_url}}" alt ="image">
                </div>
            @endif  
            <div class="description">
                {{$listing->description}}
            </div>
            <div class="price">
                <strong>${{$listing->price}}</strong>
            </div>
            <div class="bid">
                @if($buser->id == $cuser->id)
                    {{$nbids}} bid(s) so far. <a href="{{ route('profile',['uid'=> $buser->id ]) }}">you </a> are the current bid.
                @else
                    {{$nbids}} bid(s) so far. <a href="{{ route('profile',['uid'=> $buser->id ]) }}">{{$buser->name}} </a> is the current bid.
                @endif
                @if($listing->active == 1)  
                    <form action = "{{ route('bid',['lid'=> $listing->id ]) }}" method="post">
                        @csrf
                        <input type="text" class="form-control" name="price">
                    </form> 
                @else  
                    <br><p class="btn btn-info">The Creator of this listing has inctivate it</p>
                @endif    
            
            </div>
            <div>
                <h3>Details</h3>
                <ul>
                    <li>Listed by <a href="{{ route('profile',['uid'=> $owner->id ]) }}">{{$owner->name}}</a></li>
                    @if($listing->category)  
                        <li>Category: {{$listing->category}}</li>
                    @else  
                        <li>Category: No category listed</li>
                    @endif 
                </ul>
            </div>
            <div> 
                <h3>Comments:</h3>
                <form action = "{{ route('comment',['lid'=> $listing->id ]) }}" method="post">
                    @csrf
                    <div class="form-floating">
                        <label for="floatingTextarea">Comment:</label>
                        <textarea class="form-control" placeholder="add a comment.." id="floatingTextarea" name="comment"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </form>
                <div>
                    @foreach($comments as $comment)  
                        <div class="comment">
                            <a href ="{{ route('profile',['uid'=> $comment[0]->id ]) }}"><h4><i class="material-icons">account_circle</i>{{$comment[0]->name}}</h4></a>
                            <p style="margin-left:20px; padding: 10px; border:1px dotted silver; background-color: rgb(244, 241, 241);">{{$comment[1]}}</p>
                            <span>{{$comment[2]}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        Not signed in
    @endauth
@endsection
