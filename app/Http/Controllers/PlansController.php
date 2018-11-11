<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function root()
    {
        return view('plans.root');
    }
}
