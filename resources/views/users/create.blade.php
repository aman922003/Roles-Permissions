<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Users / Create</h2>
            <a href="{{ route('users.index') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-md transition">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('users.store') }}" method="post">
                        @csrf

                        <div class="space-y-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700">Name</label>
                                <input id="name" name="name" type="text" placeholder="Enter Name"
                                    value="{{ old('name') }}"
                                    class="mt-2 block w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                                <input id="email" name="email" type="email" placeholder="Enter Email"
                                    value="{{ old('email') }}"
                                    class="mt-2 block w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                                <input id="password" name="password" type="password" placeholder="Enter Password"
                                    class="mt-2 block w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Age -->
                            <div>
                                <label for="age" class="block text-sm font-semibold text-gray-700">Age</label>
                                <input id="age" name="age" type="number" min="0" placeholder="Enter Age"
                                    value="{{ old('age') }}"
                                    class="mt-2 block w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                                @error('age')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-semibold text-gray-700">Gender</label>
                                <select id="gender" name="gender"
                                    class="mt-2 block w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 bg-white focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Roles -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Assign Roles</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                    @foreach ($roles as $role)
                                        <label class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                                            <input type="checkbox" id="role-{{ $role->id }}" name="roles[]"
                                                value="{{ $role->id }}"
                                                class="rounded text-emerald-600 focus:ring-emerald-500"
                                                {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                            <span>{{ $role->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('roles')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit"
                                    class="w-full sm:w-40 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow transition duration-150">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
