<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
    {
        public function index()
            {
                return view('admin.login.signin');
            }
        public function signin(Request $request)
            {
                $validatedData = $request->validate([
                                                        'email'    => 'required',
                                                        'password' => 'required',
                                                    ]);
                //echo Hash::make($request->password);
                    //echo $request->email;
                //return;
                if($validatedData)
                    {
                        //$user= User::where('email',$request->email)->first();
                        
                        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
                        {
                            return Auth::user();
                        }
                        
                        
                    }
            }
            
            
            
        public function changepassword()
            {

            }
    }
