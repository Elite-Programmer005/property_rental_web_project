<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\PropertyImage;

class ImageService
{
    // Image size configurations
    const THUMBNAIL_WIDTH = 400;
    const THUMBNAIL_HEIGHT = 300;
    const DISPLAY_WIDTH = 800;
    const DISPLAY_HEIGHT = 600;
    const QUALITY = 85;

    /**
     * Process uploaded image and create multiple versions
     * 
     * @param UploadedFile $file
     * @param int $propertyId
     * @return array Array with paths: ['original', 'display', 'thumbnail']
     */
    public function processUpload(UploadedFile $file, int $propertyId): array
    {
        $basePath = "properties/{$propertyId}";
        $filename = time() . '_' . uniqid();
        $extension = $file->getClientOriginalExtension();

        // Store original
        $originalPath = $file->store($basePath, 'public');

        // Load image for processing
        $image = Image::read($file->getRealPath());

        // Create display version (800x600)
        $displayPath = "{$basePath}/{$filename}_display.{$extension}";
        $displayImage = clone $image;
        $displayImage->cover(self::DISPLAY_WIDTH, self::DISPLAY_HEIGHT);
        $encoded = $displayImage->toJpeg(self::QUALITY);
        Storage::disk('public')->put($displayPath, (string) $encoded);

        // Create thumbnail version (400x300)
        $thumbnailPath = "{$basePath}/{$filename}_thumb.{$extension}";
        $thumbnailImage = clone $image;
        $thumbnailImage->cover(self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT);
        $encoded = $thumbnailImage->toJpeg(self::QUALITY);
        Storage::disk('public')->put($thumbnailPath, (string) $encoded);

        return [
            'original' => $originalPath,
            'display' => $displayPath,
            'thumbnail' => $thumbnailPath,
        ];
    }

    /**
     * Set an image as primary for a property
     * 
     * @param int $propertyId
     * @param int $imageId
     * @return bool
     */
    public function setPrimaryImage(int $propertyId, int $imageId): bool
    {
        // Set all images to non-primary
        PropertyImage::where('property_id', $propertyId)
            ->update(['is_primary' => false]);

        // Set selected image as primary
        $image = PropertyImage::where('property_id', $propertyId)
            ->where('id', $imageId)
            ->first();

        if ($image) {
            $image->is_primary = true;
            $image->save();
            return true;
        }

        return false;
    }

    /**
     * Reorder images for a property
     * 
     * @param int $propertyId
     * @param array $orderArray Array of image IDs in desired order
     * @return bool
     */
    public function reorderImages(int $propertyId, array $orderArray): bool
    {
        foreach ($orderArray as $index => $imageId) {
            PropertyImage::where('property_id', $propertyId)
                ->where('id', $imageId)
                ->update(['order' => $index]);
        }

        return true;
    }

    /**
     * Delete image and all its versions
     * 
     * @param PropertyImage $image
     * @return bool
     */
    public function deleteImage(PropertyImage $image): bool
    {
        // Delete all versions from storage
        if ($image->original_path) {
            Storage::disk('public')->delete($image->original_path);
        }
        if ($image->display_path) {
            Storage::disk('public')->delete($image->display_path);
        }
        if ($image->thumbnail_path) {
            Storage::disk('public')->delete($image->thumbnail_path);
        }
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete database record
        return $image->delete();
    }

    /**
     * Bulk delete images
     * 
     * @param array $imageIds
     * @return int Number of images deleted
     */
    public function bulkDeleteImages(array $imageIds): int
    {
        $count = 0;
        $images = PropertyImage::whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            if ($this->deleteImage($image)) {
                $count++;
            }
        }

        return $count;
    }
}
