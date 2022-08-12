@extends('master.layout')
 
@section('content')
    @auth
        @foreach($Notifications as $notification) 
            <div class="row">
                <a href= "{{ route('listing',['listing'=> $notification->lid ]) }}" class="col notification">
                    {{$notification->notification}}
                </a>      
            </div>
        @endforeach
    @else
        Not signed in
    @endauth
@endsection
