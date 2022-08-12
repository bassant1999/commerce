<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Listing;
use App\Models\Watchlist;
use App\Models\Bid;
use App\Models\Comment;
use App\Models\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CommerceController extends Controller
{
    // create listing
    public function create()
    {
        return view('createListing');
    }

    public function listCreation(Request $request){
        $validatedData = $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'price' => 'required'
        ], [
            'title.required' => 'Title field is required.',
            'desc.required' => 'Description field is required.',
            'price.required' => 'Price field is required.'
        ]);

    echo $validatedData['title']." ".$validatedData['desc']." ".$validatedData['price']." ".$request['category']." ";
    if ($request->image){
        echo $imageName = time().'.'.$request->image->extension();
        echo $path = $request->image->move(public_path('images'), $imageName);
    }  

    $save = new Listing();
    $save->title = $validatedData['title'];
    $save->description = $validatedData['desc'];
    $save->price = $validatedData['price'];
    if($request['category']){
        $save->category = $request['category'];
    }
    else{
        $save->category = "";
    }
    $save->user_id = auth()->user()->id;
    if ($request->image){
        $save->img_url = $imageName;
    }
    else{
        $save->img_url = "";
    }
    $save-> active = 1;
    $save->save();
    return redirect()->route('listing', ['listing' => $save->id]);
      
    }

    // access a listing
    public function listing($listing){
        // listing
        $list = listing::find($listing);  
        $owner = User::find($list->user_id);
        // get current bid
        $price =  0;
        $cuser = auth()->user()->id;
        $bids = Bid::where('lid',$listing)->get();   
        foreach ($bids as $b) {
            if(($b->price) > $price) {
                $price = $b->price;
                $cuser = $b->cuser;
            }
        }
        $user = User::find($cuser);
        // comments
        $comments = Comment::where('lid',$listing)->orderBy('created_at' ,'DESC')->get(); 
        $Comments = [];
        foreach ($comments as $comment) {
            $c = array(User::find($comment->cuser), $comment->comment, $comment->created_at);
            $Comments[] = $c;
        }
        return view('listing',["listing"=>$list , "owner"=>$owner, 'buser'=>$user, 'cuser'=>auth()->user(), "nbids"=>$bids->count(), "comments"=>$Comments]);
    }

    // watchlist
    public function showWatchlist(){
        $watchlist = Watchlist::where('cuser',auth()->user()->id)->get();
        $listings = [];
        foreach ($watchlist as $w) {
            $listings[] = listing::find($w->lid); 
        }
        return view('watchlist',["listings"=>$listings]); 
    }
    public function AddToWatchlist($lid){
        $watchlist = new Watchlist(); 
        $watchlist->cuser = auth()->user()->id;
        $watchlist->lid = $lid;
        $watchlist->save();
        return redirect()->back()->with('success', 'Added to Watchlist succesfully');  
    }
    public function remove($lid){
        $watchlist = Watchlist::where('lid',$lid)->delete(); 
        return redirect()->back()->with('success', 'deleted succesfully');
    }

    // createdList
    public function createdList(){
        $createdListings = Listing::where('user_id',auth()->user()->id)->latest()->get();
        return view('createdList',["createdListings"=>$createdListings, "cuser"=>auth()->user()]); 
    }

    // bid
    public function bid(Request $request, $lid){
        $validatedData = $request->validate([
            'price' => 'required'
        ], [
            'price.required' => 'Price field is required.'
        ]);
        $newprice =  $validatedData['price'];
        $price =  0;
        // get maximum bid
        $bids = Bid::where('lid',$lid)->get();   
        foreach ($bids as $b) {
            echo $b;
            if(($b->price) > $price) {
                $price = $b->price;
            }
        }
        if( ($newprice >= (listing::find($lid)->price)) && ($newprice > $price) ) {
            $b=new Bid;  
            $b->cuser= auth()->user()->id;  
            $b->lid=$lid; 
            $b->price= $newprice;
            $b->save();
            $list = listing::find($lid);
            $list->update(['price' => $newprice]);
            return redirect()->back()->with('success', 'the bid has been added succesfully');
        }
        return redirect()->back()->with('fail', 'the price should be larger than the original price');
    }

    // comment
    public function comment(Request $request, $lid){
        $validatedData = $request->validate([
            'comment' => 'required'
        ], [
            'comment.required' => 'Comment field is required.'
        ]);
        $comment =new Comment;  
        $comment->cuser= auth()->user()->id;  
        $comment->lid=$lid; 
        $comment->comment= $validatedData['comment'];
        $comment->save();
        return redirect()->back()->with('success', 'the comment has been added succesfully');
    }

    // profile
    public function profile($uid){
        $owner = User::find($uid);
        $nlistings = Listing::where('user_id',$uid)->count();
        $nbids = Bid::where('cuser',$uid)->count();
        $listings = Listing::where('user_id',$uid)->orderBy('created_at' ,'DESC')->get();
        return view('profile',["owner"=>$owner, "cuser"=>auth()->user(), "nlistings"=>$nlistings, "nbids"=>$nbids, "listings"=>$listings]); 
    }

    // inactivate
    public function inactivate($lid){
        // inactivate the list
        $list = listing::find($lid);
        $list->update(['active' => 0]);
        // notify
        // notify -get current bid
        $price =  0;
        $cuser = 0;
        $bids = Bid::where('lid',$lid)->get();   
        foreach ($bids as $b) {
            if(($b->price) > $price) {
                $price = $b->price;
                $cuser = $b->cuser;
            }
        }
        if($cuser != 0){
            $notification = new Notification;
            $notification->cuser = $cuser;
            $notification->lid = $lid;
            $notification->notification ="you have won ".$list->title;
            $notification->save();
        }
        return redirect()->back()->with('success', 'inactivated succesfully');
    }

    // notifications
    public function notifications(){
        $Notifications = Notification::where('cuser',auth()->user()->id)->get();
        return view('notifications',["Notifications"=>$Notifications]); 
    }

    // category 
    public function category(Request $request){

        $categories = Listing::distinct()->get(['category']);
        $listing =Listing::where('active',1)->orderBy('created_at' ,'DESC')->get(); 

        if($request['category_name']) {
            $listing = Listing::where('category',$request['category_name'])->where('active',1)->orderBy('created_at' ,'DESC')->get();
        }
        return view('category',["categories"=>$categories, "name"=>$request['category_name'], "listings"=>$listing]); 
    }
}

