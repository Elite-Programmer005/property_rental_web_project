@extends('layouts.app')

@section('title', $property->title)

@section('content')
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Property Image (Placeholder) -->
        <div class="h-64 bg-gray-300"></div>
        
        <div class="p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold">{{ $property->title }}</h1>
                    <p class="text-gray-600 text-lg mt-2">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        {{ $property->address }}, {{ $property->city }}, {{ $property->state }}
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-blue-600">
                        ${{ number_format($property->price) }}/mo
                    </div>
                    @auth
                        <button class="mt-4 bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700">
                            Apply Now
                        </button>
                    @else
                        <a href="{{ route('login') }}" 
                           class="mt-4 bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 inline-block">
                            Login to Apply
                        </a>
                    @endauth
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <h2 class="text-2xl font-bold mb-4">Description</h2>
                    <p class="text-gray-700 mb-8">{{ $property->description }}</p>
                    
                    <h2 class="text-2xl font-bold mb-4">Features</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <i class="fas fa-bed text-blue-600 mr-3"></i>
                            <span>{{ $property->bedrooms }} Bedrooms</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-bath text-blue-600 mr-3"></i>
                            <span>{{ $property->bathrooms }} Bathrooms</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-ruler-combined text-blue-600 mr-3"></i>
                            <span>{{ $property->area_sqft }} Square Feet</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-home text-blue-600 mr-3"></i>
                            <span>{{ ucfirst($property->type) }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-4">Property Details</h3>
                    <ul class="space-y-3">
                        <li class="flex justify-between">
                            <span class="text-gray-600">Property Type:</span>
                            <span class="font-bold">{{ ucfirst($property->type) }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-bold">{{ ucfirst($property->status) }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600">City:</span>
                            <span class="font-bold">{{ $property->city }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600">State:</span>
                            <span class="font-bold">{{ $property->state }}</span>
                        </li>
                    </ul>
                    
                    @auth
                        <button class="mt-6 w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700">
                            Contact Owner
                        </button>
                    @else
                        <a href="{{ route('login') }}" 
                           class="mt-6 w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 inline-block text-center">
                            Login to Contact
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection