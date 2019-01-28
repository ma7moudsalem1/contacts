<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function auth()
    {
        return response()->json(auth()->user());
    }

    public function welcome()
    {
        $view =  auth()->guest() ? 'welcome' : 'home';
        return view($view);
    }
}
