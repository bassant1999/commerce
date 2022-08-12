<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Support\Facades\Auth;
 
class CustomAuthController extends Controller
{
 
    public function index()
    {
        return view('auth.login');
    }  
       
 
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }
   
        return redirect("login")->withSuccess('Login details are not valid');
    }
 
 
 
    public function registration()
    {
        return view('auth.registration');
    }
       
 
    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
            
        $data = $request->all();
        $check = $this->create($data);
        auth()->login($check);
        return redirect("dashboard")->withSuccess('have signed-in');
    }
 
 
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    
     
 
    public function dashboard()
    {
        
        $listings=Listing::where('active',1)->orderBy('created_at' ,'DESC')->get(); 
        return view('dashboard',['listings'=>$listings, "cuser"=>auth()->user()]);
    }
     
 
    public function signOut() {
        Session::flush();
        Auth::logout();
   
        return Redirect('login');
    }
}