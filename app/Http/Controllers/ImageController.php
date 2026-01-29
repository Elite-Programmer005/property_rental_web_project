<?php

namespace App\Http\Controllers;

use App\Models\PropertyImage;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Set an image as primary
     */
    public function setPrimary(Request $request, $propertyId, $imageId)
    {
        $property = \App\Models\Property::findOrFail($propertyId);
        
        // Check authorization
        if (Auth::id() !== $property->user_id && !in_array(Auth::user()->role, ['admin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $success = $this->imageService->setPrimaryImage($propertyId, $imageId);

        if ($success) {
            return response()->json(['message' => 'Primary image updated successfully']);
        }

        return response()->json(['error' => 'Failed to update primary image'], 400);
    }

    /**
     * Reorder images
     */
    public function reorder(Request $request, $propertyId)
    {
        $property = \App\Models\Property::findOrFail($propertyId);
        
        // Check authorization
        if (Auth::id() !== $property->user_id && !in_array(Auth::user()->role, ['admin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:property_images,id'
        ]);

        $success = $this->imageService->reorderImages($propertyId, $validated['order']);

        if ($success) {
            return response()->json(['message' => 'Images reordered successfully']);
        }

        return response()->json(['error' => 'Failed to reorder images'], 400);
    }

    /**
     * Delete an image
     */
    public function destroy($propertyId, $imageId)
    {
        $property = \App\Models\Property::findOrFail($propertyId);
        
        // Check authorization
        if (Auth::id() !== $property->user_id && !in_array(Auth::user()->role, ['admin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $image = PropertyImage::where('property_id', $propertyId)
            ->where('id', $imageId)
            ->firstOrFail();

        $success = $this->imageService->deleteImage($image);

        if ($success) {
            return response()->json(['message' => 'Image deleted successfully']);
        }

        return response()->json(['error' => 'Failed to delete image'], 400);
    }

    /**
     * Bulk delete images
     */
    public function bulkDelete(Request $request, $propertyId)
    {
        $property = \App\Models\Property::findOrFail($propertyId);
        
        // Check authorization
        if (Auth::id() !== $property->user_id && !in_array(Auth::user()->role, ['admin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'image_ids' => 'required|array',
            'image_ids.*' => 'required|integer|exists:property_images,id'
        ]);

        $count = $this->imageService->bulkDeleteImages($validated['image_ids']);

        return response()->json([
            'message' => "{$count} images deleted successfully",
            'count' => $count
        ]);
    }

    /**
     * Get all images for a property
     */
    public function index($propertyId)
    {
        $images = PropertyImage::where('property_id', $propertyId)
            ->orderBy('order')
            ->get();

        return response()->json($images);
    }
}

