<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::all();

    return view('layouts.welcome', compact('categories'));
  
}
}

