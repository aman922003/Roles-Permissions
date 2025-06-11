<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div
                class="flex items-center gap-3 bg-green-100 border border-green-300 text-green-800 text-sm font-medium px-4 py-3 rounded-lg shadow-sm">
                <i class="fas fa-circle-check text-green-600 text-base"></i>
                <span>
                    {{ __("You're logged in!") }}
                </span>
            </div>

        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Management Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- User Management Card -->
                @can('manage user')
                <div
                    class="bg-white rounded-2xl shadow-lg p-8 text-center border border-blue-100 hover:shadow-xl transition duration-300">
                    <div class="flex justify-center mb-5">
                        <i class="fas fa-users fa-3x text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 flex items-center justify-center gap-2">
                        <i class="fas fa-user text-blue-500"></i>
                        User Management
                    </h3>
                    <p class="text-gray-500 mb-6">Manage all registered users, update details, and control access.</p>
                    <a href="{{ route('users.index') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition">
                        Manage Users
                    </a>
                </div>
                @endcan
                <!-- Roles & Permissions Card -->
                @can('manage roles&permission')
                <div
                    class="bg-white rounded-2xl shadow-lg p-8 text-center border border-green-100 hover:shadow-xl transition duration-300">
                
                    <div class="flex justify-center mb-5">
                        <i class="fas fa-user-shield fa-3x text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 flex items-center justify-center gap-2">
                        <i class="fas fa-lock text-green-500"></i>
                        Roles & Permissions
                    </h3>
                    <p class="text-gray-500 mb-6">Assign roles and set permissions for system-wide access control.</p>
                    <a href="{{ route('roles.index') }}"
                        class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg transition">
                        Manage Roles
                    </a>
                </div>
                @endcan

            </div>
        </div>
    </div>
</x-app-layout>