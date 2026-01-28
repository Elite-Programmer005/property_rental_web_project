<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-3xl font-bold mb-6">Welcome to Your Dashboard!</h1>
                        
                        <div v-if="$page.props.auth.user.role === 'admin'" class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
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

                        <!-- Add more role-based content here -->
                        
                        <div class="bg-gray-50 p-6 rounded-lg mt-6">
                            <h3 class="text-xl font-bold mb-4">Your Account Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-600">Name:</p>
                                    <p class="font-bold">{{ $page.props.auth.user.name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Email:</p>
                                    <p class="font-bold">{{ $page.props.auth.user.email }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Role:</p>
                                    <p class="font-bold capitalize">{{ $page.props.auth.user.role }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Phone:</p>
                                    <p class="font-bold">{{ $page.props.auth.user.phone || 'Not set' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>