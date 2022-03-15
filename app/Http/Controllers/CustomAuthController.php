<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Session;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function registration()
    {
        return view('registration');
    }
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ],[
            'email.required' => 'Please Enter Email',
            'email.email' => 'Please Enter Valid Email',
            'password.required' => 'Please Enter Password',
            'password.min' => 'Password Must be 6 character long',
        ]);

        $credentials = $request->only('email', 'password');
        $remember_me = $request->has('remember') ? true : false;
        if (Auth::attempt($credentials,$remember_me)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')
                        ->with('logined','You have Successfully loggedin');
        }

        return redirect("login")->with('message','Oppes! You have entered invalid credentials');
    }

    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'cpassword' => 'required|same:password|min:6',
        ],[
            'name.required' => 'Please Enter Name',
            'email.required' => 'Please Enter Email',
            'email.email'=>'Please Enter Valid Email',
            'email.unique'=> 'Email Already Exists!!',
            'password.required' => 'Please Enter Password',
            'password.min'=>'Password must be 6 character long',
            'cpassword.required' => 'Please Enter Confirm Password',
            'cpassword.same'=>'Confirm Password must be same as Password',
            'cpassword.min'=>'Confirm Password must be 6 character long',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect("dashboard")->with('rmsg','Great! You have Successfully loggedin');
    }
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }

        return redirect("login");
    }
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }
    public function logout() {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
