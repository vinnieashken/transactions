<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class Login extends Controller
    {
        public function index()
            {
                return view('admin.login.signin');
            }
            
        public function signin(Request $request)
            {
                $validatedData = $request->validate(['email'    => 'required', 'password' => 'required']);
                
                if($validatedData)
                    {
                        if(Auth::attempt(['email'=>$request->email,'password'=>bcrypt($request->password)]))
                            {
    
                                return Auth::user();
                              
                            }
                        Redirect::to('dashboard');
                    }
                
            }
            
        public function changepassword()
            {

            }
            
        public function password_request()
            {
            
            }
    }
