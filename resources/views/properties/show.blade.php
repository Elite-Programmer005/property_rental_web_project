@extends('layouts.app')

@section('title', $property->title)

@section('content')
<style>
    /* Lightbox Styles */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .lightbox.active {
        display: flex;
    }

    .lightbox-content {
        max-width: 90%;
        max-height: 90%;
        position: relative;
    }

    .lightbox-image {
        width: 100%;
        height: auto;
        transition: transform 0.3s ease;
    }

    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 40px;
        color: white;
        cursor: pointer;
        z-index: 10000;
    }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 40px;
        color: white;
        cursor: pointer;
        padding: 10px 20px;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 5px;
        user-select: none;
    }

    .lightbox-prev {
        left: 20px;
    }

    .lightbox-next {
        right: 20px;
    }

    .lightbox-counter {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        background: rgba(0, 0, 0, 0.7);
        padding: 10px 20px;
        border-radius: 5px;
    }

    .zoom-controls {
        position: absolute;
        bottom: 80px;
        right: 30px;
        display: flex;
        gap: 10px;
    }

    .zoom-btn {
        background: rgba(0, 0, 0, 0.7);
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 20px;
    }

    .fullscreen-btn {
        position: absolute;
        top: 20px;
        left: 30px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .primary-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #3b82f6;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: bold;
    }

    .carousel-item img {
        cursor: pointer;
    }
</style>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Property Images Carousel -->
        @if($property->images->count() > 0)
            @php
                // Sort images: primary first, then by order
                $sortedImages = $property->images->sortBy(function($image) {
                    return $image->is_primary ? 0 : $image->order + 1;
                })->values();
            @endphp
            
            <div class="relative h-96 mb-6">
                <div id="propertyCarousel" class="carousel slide h-full" data-bs-ride="false">
                    <!-- Indicators -->
                    <div class="carousel-indicators">
                        @foreach($sortedImages as $key => $image)
                            <button type="button" data-bs-target="#propertyCarousel" 
                                    data-bs-slide-to="{{ $key }}" 
                                    class="{{ $key === 0 ? 'active' : '' }}"
                                    aria-current="{{ $key === 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $key + 1 }}"></button>
                        @endforeach
                    </div>

                    <!-- Slides -->
                    <div class="carousel-inner h-full">
                        @foreach($sortedImages as $key => $image)
                            <div class="carousel-item h-full {{ $key === 0 ? 'active' : '' }}" data-image-index="{{ $key }}">
                                @if($image->is_primary)
                                    <div class="primary-badge">
                                        <i class="fas fa-star"></i> Primary
                                    </div>
                                @endif
                                <img src="{{ $image->display_url }}" 
                                     data-original="{{ $image->original_url }}"
                                     class="d-block w-100 h-full object-cover"
                                     alt="Property image {{ $key + 1 }}"
                                     onclick="openLightbox({{ $key }})"
                                     onerror="this.src='https://via.placeholder.com/800x600?text=Image+Not+Found'">
                            </div>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    
                    <!-- Image counter -->
                    <div class="position-absolute bottom-0 end-0 bg-black bg-opacity-50 text-white px-3 py-2 m-3 rounded">
                        <i class="fas fa-images"></i> <span id="imageCounter">1/{{ $sortedImages->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Lightbox -->
            <div id="lightbox" class="lightbox">
                <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
                <button class="fullscreen-btn" onclick="toggleFullscreen()">
                    <i class="fas fa-expand"></i> Fullscreen
                </button>
                <div class="lightbox-content">
                    <img id="lightboxImage" src="" alt="" class="lightbox-image">
                </div>
                <span class="lightbox-nav lightbox-prev" onclick="changeImage(-1)">&#10094;</span>
                <span class="lightbox-nav lightbox-next" onclick="changeImage(1)">&#10095;</span>
                <div class="lightbox-counter" id="lightboxCounter">1/{{ $sortedImages->count() }}</div>
                <div class="zoom-controls">
                    <button class="zoom-btn" onclick="zoomIn()"><i class="fas fa-plus"></i></button>
                    <button class="zoom-btn" onclick="zoomOut()"><i class="fas fa-minus"></i></button>
                    <button class="zoom-btn" onclick="resetZoom()"><i class="fas fa-undo"></i></button>
                </div>
            </div>

            <script>
                let currentImageIndex = 0;
                let zoomLevel = 1;
                const images = @json($sortedImages->map(function($img) {
                    return [
                        'original' => $img->original_url,
                        'display' => $img->display_url
                    ];
                }));

                function openLightbox(index) {
                    currentImageIndex = index;
                    updateLightboxImage();
                    document.getElementById('lightbox').classList.add('active');
                    document.body.style.overflow = 'hidden';
                }

                function closeLightbox() {
                    document.getElementById('lightbox').classList.remove('active');
                    document.body.style.overflow = 'auto';
                    resetZoom();
                }

                function changeImage(direction) {
                    currentImageIndex += direction;
                    if (currentImageIndex >= images.length) currentImageIndex = 0;
                    if (currentImageIndex < 0) currentImageIndex = images.length - 1;
                    updateLightboxImage();
                }

                function updateLightboxImage() {
                    const img = document.getElementById('lightboxImage');
                    img.src = images[currentImageIndex].original;
                    document.getElementById('lightboxCounter').textContent = `${currentImageIndex + 1}/${images.length}`;
                }

                function zoomIn() {
                    zoomLevel += 0.2;
                    if (zoomLevel > 3) zoomLevel = 3;
                    applyZoom();
                }

                function zoomOut() {
                    zoomLevel -= 0.2;
                    if (zoomLevel < 0.5) zoomLevel = 0.5;
                    applyZoom();
                }

                function resetZoom() {
                    zoomLevel = 1;
                    applyZoom();
                }

                function applyZoom() {
                    document.getElementById('lightboxImage').style.transform = `scale(${zoomLevel})`;
                }

                function toggleFullscreen() {
                    if (!document.fullscreenElement) {
                        document.getElementById('lightbox').requestFullscreen();
                    } else {
                        document.exitFullscreen();
                    }
                }

                // Keyboard navigation
                document.addEventListener('keydown', function(e) {
                    if (!document.getElementById('lightbox').classList.contains('active')) return;
                    
                    if (e.key === 'Escape') closeLightbox();
                    if (e.key === 'ArrowLeft') changeImage(-1);
                    if (e.key === 'ArrowRight') changeImage(1);
                    if (e.key === '+') zoomIn();
                    if (e.key === '-') zoomOut();
                    if (e.key === '0') resetZoom();
                });

                // Update counter on carousel slide
                document.querySelector('#propertyCarousel').addEventListener('slide.bs.carousel', function(e) {
                    document.getElementById('imageCounter').textContent = `${e.to + 1}/${images.length}`;
                });
            </script>
        @else
            <div class="h-64 bg-gray-300 mb-6 rounded-lg flex items-center justify-center">
                <p class="text-gray-600">No images available</p>
            </div>
        @endif
        
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
                    
                    @auth
                        <div class="mt-4">
                            @if(auth()->user()->favorites->contains('property_id', $property->id))
                                <form action="{{ route('properties.unfavorite', $property) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-heart mr-2"></i>Remove from Favorites
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('properties.favorite', $property) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="far fa-heart mr-2"></i>Add to Favorites
                                    </button>
                                </form>
                            @endif
                        </div>
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
            
            @auth
                @if(auth()->user()->role === 'tenant' && $property->status === 'available')
                    <div class="mt-8">
                        <h3 class="text-xl font-bold mb-4">Apply for this Property</h3>
                        <form action="{{ route('properties.apply', $property) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="message" class="block text-sm font-medium text-gray-700">Message to Landlord</label>
                                <textarea name="message" id="message" rows="4" required
                                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                                          placeholder="Tell the landlord why you're interested..."></textarea>
                            </div>
                            <button type="submit"
                                    class="bg-green-600 text-white px-6 py-3 rounded-md font-medium hover:bg-green-700">
                                Submit Application
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
@endsection