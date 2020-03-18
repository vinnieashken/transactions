<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                if($validatedData)
                    {
                        echo $request->get('email');
                    }
            }
        public function changepassword()
            {

            }
    }
