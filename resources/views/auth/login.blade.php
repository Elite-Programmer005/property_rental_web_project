@extends('layouts.app')

@section('title', 'Login')

@section('content')
<style>
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-down {
        animation: slideInDown 0.6s ease-out;
    }

    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    .animate-slide-up {
        animation: slideInUp 0.6s ease-out 0.2s both;
    }

    .password-toggle {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .password-toggle:hover {
        color: #2563eb;
    }

    .password-input-container {
        position: relative;
    }

    input:focus {
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        transition: all 0.3s ease;
    }

    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .form-input {
        transition: all 0.3s ease;
    }

    .form-input:focus {
        border-color: #2563eb;
    }
</style>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 animate-slide-up">
        <!-- Header -->
        <div class="animate-slide-down">
            <div class="text-center">
                <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mb-4 animate-bounce" style="animation: bounce 2s infinite;">
                    <i class="fas fa-home text-lg"></i>
                </div>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Sign in to your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Or
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300">
                    create a new account
                </a>
            </p>
        </div>

        <!-- Form -->
        <form class="mt-8 space-y-6 animate-fade-in" action="{{ route('login') }}" method="POST">
            @csrf
            
            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                <div class="relative">
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="Enter your email"
                           value="{{ old('email') }}">
                    <span class="absolute right-3 top-3.5 text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <div class="password-input-container relative">
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="Enter your password">
                    <span class="absolute right-3 top-3.5 text-gray-400 password-toggle cursor-pointer" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all duration-300 cursor-pointer">
                    <label for="remember" class="ml-2 block text-sm text-gray-700 cursor-pointer hover:text-gray-900 transition-colors duration-300">
                        Remember me
                    </label>
                </div>

                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300">
                        Forgot your password?
                    </a>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 shadow-md hover:shadow-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-blue-300 group-hover:text-blue-200"></i>
                    </span>
                    Sign in
                </button>
            </div>

            <!-- Demo credentials -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Demo Accounts:</strong><br>
                            Admin: admin@example.com / password<br>
                            Landlord: landlord@example.com / password<br>
                            Tenant: tenant@example.com / password
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Password toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle eye icon
        this.innerHTML = type === 'password' 
            ? '<i class="fas fa-eye"></i>' 
            : '<i class="fas fa-eye-slash"></i>';
        
        // Add animation
        this.style.transform = 'scale(1.2)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 200);
    });

    // Add smooth transition to password toggle icon
    togglePassword.style.transition = 'transform 0.2s ease';
</script>

@endsection