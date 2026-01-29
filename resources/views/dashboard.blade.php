@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold mb-6">Welcome to Your Dashboard!</h1>
                
                <!-- Role-based Content -->
                @auth
                    @if(auth()->user()->role == 'admin')
                        <!-- Admin Dashboard -->
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-user-shield text-blue-400 text-2xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-blue-800">Admin Panel</h3>
                                    <div class="mt-2 text-blue-700">
                                        <p>You have administrative access to manage the entire platform.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Admin Actions -->
                        <div class="mb-6">
                            <a href="{{ route('properties.create') }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 inline-block">
                                <i class="fas fa-plus-circle mr-2"></i>Add New Property
                            </a>
                        </div>
                        
                        <!-- Admin Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-blue-100 p-6 rounded-lg text-center">
                                <i class="fas fa-users text-blue-600 text-3xl mb-3"></i>
                                <h3 class="text-2xl font-bold text-blue-800">Total Users</h3>
                                <p class="text-blue-600 text-4xl font-bold mt-2">3</p>
                            </div>
                            <div class="bg-green-100 p-6 rounded-lg text-center">
                                <i class="fas fa-home text-green-600 text-3xl mb-3"></i>
                                <h3 class="text-2xl font-bold text-green-800">Properties</h3>
                                <p class="text-green-600 text-4xl font-bold mt-2">10</p>
                            </div>
                            <div class="bg-purple-100 p-6 rounded-lg text-center">
                                <i class="fas fa-file-alt text-purple-600 text-3xl mb-3"></i>
                                <h3 class="text-2xl font-bold text-purple-800">Applications</h3>
                                <p class="text-purple-600 text-4xl font-bold mt-2">0</p>
                            </div>
                        </div>
                        
                    @elseif(auth()->user()->role == 'landlord')
                        <!-- Landlord Dashboard -->
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-house-user text-green-400 text-2xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-green-800">Landlord Dashboard</h3>
                                    <div class="mt-2 text-green-700">
                                        <p>Manage your properties and rental applications.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Landlord Actions -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <a href="{{ route('properties.create') }}" class="bg-white border-2 border-green-300 p-6 rounded-lg text-center hover:bg-green-50 transition">
                                <i class="fas fa-plus-circle text-green-600 text-3xl mb-3"></i>
                                <h3 class="text-xl font-bold text-green-800">Add New Property</h3>
                                <p class="text-gray-600 mt-2">List a new property for rent</p>
                            </a>
                            <a href="{{ route('properties.my') }}" class="bg-white border-2 border-blue-300 p-6 rounded-lg text-center hover:bg-blue-50 transition">
                                <i class="fas fa-list text-blue-600 text-3xl mb-3"></i>
                                <h3 class="text-xl font-bold text-blue-800">My Properties</h3>
                                <p class="text-gray-600 mt-2">View and manage your listings</p>
                            </a>
                        </div>
                        
                    @elseif(auth()->user()->role == 'tenant')
                        <!-- Tenant Dashboard -->
                        <div class="bg-purple-50 border-l-4 border-purple-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-user-tie text-purple-400 text-2xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-purple-800">Tenant Dashboard</h3>
                                    <div class="mt-2 text-purple-700">
                                        <p>Find your perfect rental property and manage applications.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tenant Actions -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <a href="{{ route('properties.index') }}" class="bg-white border-2 border-purple-300 p-6 rounded-lg text-center hover:bg-purple-50 transition">
                                <i class="fas fa-search text-purple-600 text-3xl mb-3"></i>
                                <h3 class="text-xl font-bold text-purple-800">Browse Properties</h3>
                                <p class="text-gray-600 mt-2">Find available rentals</p>
                            </a>
                            <a href="#" class="bg-white border-2 border-yellow-300 p-6 rounded-lg text-center hover:bg-yellow-50 transition">
                                <i class="fas fa-file-alt text-yellow-600 text-3xl mb-3"></i>
                                <h3 class="text-xl font-bold text-yellow-800">My Applications</h3>
                                <p class="text-gray-600 mt-2">Track your rental applications</p>
                            </a>
                        </div>
                        
                    @elseif(auth()->user()->role == 'agent')
                        <!-- Agent Dashboard -->
                        <div class="bg-indigo-50 border-l-4 border-indigo-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-briefcase text-indigo-400 text-2xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-indigo-800">Agent Dashboard</h3>
                                    <div class="mt-2 text-indigo-700">
                                        <p>Manage properties on behalf of landlords.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Agent Actions -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <a href="{{ route('properties.create') }}" class="bg-white border-2 border-indigo-300 p-6 rounded-lg text-center hover:bg-indigo-50 transition">
                                <i class="fas fa-plus-circle text-indigo-600 text-3xl mb-3"></i>
                                <h3 class="text-xl font-bold text-indigo-800">Add New Property</h3>
                                <p class="text-gray-600 mt-2">List a new property for rent</p>
                            </a>
                            <a href="{{ route('properties.my') }}" class="bg-white border-2 border-blue-300 p-6 rounded-lg text-center hover:bg-blue-50 transition">
                                <i class="fas fa-list text-blue-600 text-3xl mb-3"></i>
                                <h3 class="text-xl font-bold text-blue-800">My Properties</h3>
                                <p class="text-gray-600 mt-2">View and manage your listings</p>
                            </a>
                        </div>
                    @endif
                    
                    <!-- User Info Card -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold mb-4">Your Account Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600">Name:</p>
                                <p class="font-bold">{{ auth()->user()->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Email:</p>
                                <p class="font-bold">{{ auth()->user()->email }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Role:</p>
                                <p class="font-bold capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Member Since:</p>
                                <p class="font-bold">{{ auth()->user()->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                @else
                    <!-- Not logged in -->
                    <div class="text-center py-12">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-5xl mb-4"></i>
                        <h2 class="text-2xl font-bold mb-4">Please Log In</h2>
                        <p class="text-gray-600 mb-6">You need to be logged in to view the dashboard.</p>
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700">
                            Go to Login
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection