@extends('layouts.app')

@section('title', 'Browse Properties')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Available Properties</h1>
    
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
                        
                        <div class="flex items-center text-gray-500 mb-4">
                            <i class="fas fa-bed mr-2"></i> {{ $property->bedrooms }} Beds
                            <i class="fas fa-bath ml-4 mr-2"></i> {{ $property->bathrooms }} Baths
                            <i class="fas fa-ruler ml-4 mr-2"></i> {{ $property->area_sqft }} sqft
                        </div>
                        
                        <div class="text-gray-600">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $property->address }}, {{ $property->city }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $properties->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">No properties found. Check back later!</p>
        </div>
    @endif
@endsection