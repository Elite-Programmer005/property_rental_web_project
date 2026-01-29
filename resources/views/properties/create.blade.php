@extends('layouts.app')

@section('title', 'Add New Property')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold mb-6">List a New Property</h1>

                <form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Property Title</label>
                            <input type="text" name="title" id="title" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Property Type</label>
                            <select name="type" id="type" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                <option value="">Select Type</option>
                                <option value="house">House</option>
                                <option value="apartment">Apartment</option>
                                <option value="condo">Condo</option>
                                <option value="townhouse">Townhouse</option>
                                <option value="villa">Villa</option>
                            </select>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Monthly Rent ($)</label>
                            <input type="number" name="price" id="price" required min="0" step="0.01"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                <option value="available">Available</option>
                                <option value="unavailable">Unavailable</option>
                            </select>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4" required
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
                    </div>

                    <!-- Address -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" name="address" id="address" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" id="city" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                            <input type="text" name="state" id="state" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label for="bedrooms" class="block text-sm font-medium text-gray-700">Bedrooms</label>
                            <input type="number" name="bedrooms" id="bedrooms" required min="1"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <div>
                            <label for="bathrooms" class="block text-sm font-medium text-gray-700">Bathrooms</label>
                            <input type="number" name="bathrooms" id="bathrooms" required min="1"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <div>
                            <label for="area_sqft" class="block text-sm font-medium text-gray-700">Area (sqft)</label>
                            <input type="number" name="area_sqft" id="area_sqft" min="0"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                    </div>

                    <!-- Location (Optional) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude (optional)</label>
                            <input type="number" name="latitude" id="latitude" step="any"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude (optional)</label>
                            <input type="number" name="longitude" id="longitude" step="any"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-8">
                        <label for="images" class="block text-sm font-medium text-gray-700">Property Images</label>
                        <input type="file" name="images[]" id="images" multiple accept="image/*"
                               class="mt-1 block w-full">
                        <p class="text-sm text-gray-500 mt-1">You can upload multiple images. First image will be the primary.</p>
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-3 rounded-md font-medium hover:bg-blue-700">
                            List Property
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection