<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured properties for homepage
        $properties = Property::where('status', 'available')
                             ->latest()
                             ->take(6)
                             ->get();
        
        return view('home', compact('properties'));
    }
}