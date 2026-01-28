@extends('layouts.app')

@section('title', 'Home - Find Your Perfect Rental')

@section('content')
    <!-- Hero Section -->
    <section class="mb-12">
        <div class="bg-blue-600 text-white rounded-lg p-8">
            <h1 class="text-4xl font-bold mb-4">Find Your Perfect Rental Property</h1>
            <p class="text-xl mb-6">Browse thousands of properties and apply online</p>
            <div class="bg-white p-4 rounded-lg">
                <form action="{{ route('properties.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <input type="text" name="search" placeholder="City, Address, or ZIP" 
                           class="flex-1 p-3 border rounded">
                    <select name="type" class="p-3 border rounded">
                        <option value="">Property Type</option>
                        <option value="house">House</option>
                        <option value="apartment">Apartment</option>
                        <option value="condo">Condo</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white p-3 rounded hover:bg-blue-700">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Featured Properties -->
    <section>
        <h2 class="text-3xl font-bold mb-6">Featured Properties</h2>
        
        @if($properties->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($properties as $property)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <div class="h-48 bg-gray-300"></div> <!-- Image placeholder -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $property->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($property->description, 100) }}</p>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-2xl font-bold text-blue-600">
                                    ${{ number_format($property->price) }}/mo
                                </span>
                                <a href="{{ route('properties.show', $property) }}" 
                                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    View Details
                                </a>
                            </div>
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-bed mr-2"></i> {{ $property->bedrooms }} Beds
                                <i class="fas fa-bath ml-4 mr-2"></i> {{ $property->bathrooms }} Baths
                                <i class="fas fa-ruler ml-4 mr-2"></i> {{ $property->area_sqft }} sqft
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-8">
                <a href="{{ route('properties.index') }}" 
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                    View All Properties
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">No properties available at the moment.</p>
            </div>
        @endif
    </section>
@endsection