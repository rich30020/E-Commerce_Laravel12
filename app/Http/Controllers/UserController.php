<?php

namespace App\Http\Controllers;


class UserController extends Controller
{
    public function index()
      {
        // Ensure the method exists and returns a valid response
        return view('user.index');
    }
}