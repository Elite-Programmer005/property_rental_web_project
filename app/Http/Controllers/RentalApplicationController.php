<?php

namespace App\Http\Controllers;

use App\Models\RentalApplication;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRentalApplicationRequest;
use Illuminate\Support\Facades\Auth;

class RentalApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRentalApplicationRequest $request, Property $property)
    {
        // Check if user already applied
        $existingApplication = RentalApplication::where('user_id', Auth::id())
            ->where('property_id', $property->id)
            ->first();
        
        if ($existingApplication) {
            return back()->with('error', 'You have already applied for this property.');
        }
        
        // Create application
        $application = RentalApplication::create([
            'property_id' => $property->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'status' => 'pending',
        ]);
        
        return back()->with('success', 'Application submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(RentalApplication $rentalApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RentalApplication $rentalApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RentalApplication $rentalApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentalApplication $rentalApplication)
    {
        //
    }
}
