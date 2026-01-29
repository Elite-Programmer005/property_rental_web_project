<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Favorite;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::where('status', 'available')
                             ->with(['user', 'images'])
                             ->latest()
                             ->paginate(12);
        
        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if user is landlord, agent, or admin
        if (!in_array(Auth::user()->role, ['landlord', 'agent', 'admin'])) {
            return redirect()->route('dashboard')
                ->with('error', 'Only landlords and agents can create properties.');
        }
        
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'area_sqft' => 'nullable|integer|min:0',
            'type' => 'required|in:house,apartment,condo,townhouse,villa',
            'status' => 'required|in:available,rented,unavailable',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create property
        $property = Property::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'price' => $validated['price'],
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'area_sqft' => $validated['area_sqft'],
            'type' => $validated['type'],
            'status' => $validated['status'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'user_id' => Auth::id(),
        ]);

        // Handle image uploads with ImageService
        if ($request->hasFile('images')) {
            $imageService = new ImageService();
            
            foreach ($request->file('images') as $key => $image) {
                $paths = $imageService->processUpload($image, $property->id);
                
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $paths['original'],
                    'thumbnail_path' => $paths['thumbnail'],
                    'display_path' => $paths['display'],
                    'original_path' => $paths['original'],
                    'is_primary' => $key === 0, // First image is primary
                    'order' => $key,
                ]);
            }
        }

        return redirect()->route('properties.show', $property)
            ->with('success', 'Property listed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        // Load relationships for the view
        $property->load(['user', 'images']);
        
        return view('properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        // Check if user owns the property or is admin
        if (Auth::id() !== $property->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('properties.index')
                ->with('error', 'You are not authorized to edit this property.');
        }
        
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        // Check if user owns the property or is admin
        if (Auth::id() !== $property->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('properties.index')
                ->with('error', 'You are not authorized to update this property.');
        }

        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'area_sqft' => 'nullable|integer|min:0',
            'type' => 'required|in:house,apartment,condo,townhouse,villa',
            'status' => 'required|in:available,rented,unavailable',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update property
        $property->update($validated);

        // Handle new image uploads with ImageService
        if ($request->hasFile('images')) {
            $imageService = new ImageService();
            $currentCount = $property->images()->count();
            
            foreach ($request->file('images') as $key => $image) {
                $paths = $imageService->processUpload($image, $property->id);
                
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $paths['original'],
                    'thumbnail_path' => $paths['thumbnail'],
                    'display_path' => $paths['display'],
                    'original_path' => $paths['original'],
                    'is_primary' => false,
                    'order' => $currentCount + $key,
                ]);
            }
        }

        return redirect()->route('properties.show', $property)
            ->with('success', 'Property updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        // Check if user owns the property or is admin
        if (Auth::id() !== $property->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('properties.index')
                ->with('error', 'You are not authorized to delete this property.');
        }

        // Delete property images from storage
        foreach ($property->images as $image) {
            Storage::delete('public/' . $image->image_path);
        }

        // Delete the property
        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully!');
    }
    
    /**
     * Show properties by specific user (landlord)
     */
    public function myProperties()
    {
        $properties = Property::where('user_id', Auth::id())
                             ->with('images')
                             ->latest()
                             ->paginate(10);
        
        return view('properties.my-properties', compact('properties'));
    }

    /**
     * Add property to favorites
     */
    public function favorite(Property $property)
    {
        $userId = Auth::id();
        
        if (Favorite::where('user_id', $userId)->where('property_id', $property->id)->exists()) {
            return back()->with('error', 'Property already in favorites.');
        }
        
        Favorite::create([
            'user_id' => $userId,
            'property_id' => $property->id,
        ]);
        
        return back()->with('success', 'Property added to favorites!');
    }

    /**
     * Remove property from favorites
     */
    public function unfavorite(Property $property)
    {
        $userId = Auth::id();
        Favorite::where('user_id', $userId)->where('property_id', $property->id)->delete();
        
        return back()->with('success', 'Property removed from favorites.');
    }
}