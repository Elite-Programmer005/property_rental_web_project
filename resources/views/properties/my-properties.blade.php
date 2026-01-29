@extends('layouts.app')

@section('title', 'My Properties')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold">My Properties</h1>
            <a href="{{ route('properties.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus-circle mr-2"></i>Add New Property
            </a>
        </div>
        
        @if($properties->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($properties as $property)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <!-- Property Image -->
                        @php
                            $primaryImage = $property->images->where('is_primary', true)->first() 
                                ?? $property->images->first();
                        @endphp
                        
                        @if($primaryImage)
                            <a href="{{ route('properties.show', $property) }}">
                                <img src="{{ $primaryImage->thumbnail_url }}" 
                                     alt="{{ $property->title }}"
                                     class="h-48 w-full object-cover hover:opacity-90 transition"
                                     onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">
                            </a>
                        @else
                            <div class="h-48 bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                                <i class="fas fa-home text-gray-500 text-4xl"></i>
                            </div>
                        @endif
                        
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
                            
                            <div class="text-gray-600 mb-6">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $property->address }}, {{ $property->city }}
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <a href="{{ route('properties.show', $property) }}" 
                                   class="flex-1 bg-green-600 text-white px-3 py-2 rounded text-center hover:bg-green-700 transition text-sm">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <a href="{{ route('properties.show', $property) }}" 
                                   class="flex-1 bg-orange-600 text-white px-3 py-2 rounded text-center hover:bg-orange-700 transition text-sm">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <button onclick="if(confirm('Delete this property?')) { /* delete logic */ }" 
                                        class="flex-1 bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 transition text-sm">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
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
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-inbox text-gray-400 text-6xl mb-6"></i>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">No Properties Yet</h2>
                <p class="text-gray-600 mb-6">You haven't listed any properties yet. Start by creating your first listing!</p>
                <a href="{{ route('properties.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-plus-circle mr-2"></i>Add Your First Property
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
