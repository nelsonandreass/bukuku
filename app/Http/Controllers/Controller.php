<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        return view('index');
    }
    public function signin(){
        return view('page-signin');
    }
    public function signup(){
        return view('page-signup');
    }
    public function signinProcess(Request $request){
        $credential = array(
            'email' => $request->input('email'),
            'password' => $request->input('password')
        );

        if(Auth::attempt($credential)){
            return redirect('/user/home');
        }
        else{
            return redirect()->back()->with('error' , "Wrong Email or Password" );
        }
    }
    public function signupProcess(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->save();

        $credential = array(
            'email' => $email,
            'password' => $request->input('password')
        );
        if(Auth::attempt($credential)){
            return redirect('/user/home');
        }
    }
    public function signout(){
        Auth::logout();
        return redirect('/signin');
    }
}
