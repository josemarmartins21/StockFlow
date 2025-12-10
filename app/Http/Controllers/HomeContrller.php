<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeContrller extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {   die;
        return view('home');
    }
}
