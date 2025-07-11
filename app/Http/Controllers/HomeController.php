<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController
{
    public function index(){

        return Inertia::render('HomePage');
    }
    public function test(){

        return Inertia::render('TestPage');
    }
}
