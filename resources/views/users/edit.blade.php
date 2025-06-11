<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users / Edit
            </h2>
            <a href="{{ route('users.index') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-md transition duration-200 ease-in-out">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.update', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input id="name" name="name" placeholder="Enter Name" type="text"
                                    value="{{$user->name}}"
                                    class="border border-gray-300 shadow-sm w-1/2 rounded-lg px-3 py-2">
                                @error('name')
                                <p class="text-red-400 font-medium">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                            <div class="my-3">
                                <input id="email" name="email" placeholder="Enter Email" type="text"
                                    value="{{$user->email}}"
                                    class="border border-gray-300 shadow-sm w-1/2 rounded-lg px-3 py-2">
                                @error('email')
                                <p class="text-red-400 font-medium">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                            <div class="my-3">
                                <input id="password" name="password" type="password" placeholder="Enter New Password"
                                    value="{{ $user->password }}"
                                    class="border border-gray-300 shadow-sm w-1/2 rounded-lg px-3 py-2">
                                @error('password')
                                <p class="text-red-400 font-medium">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                            <div class="my-3">
                                <input id="age" name="age" placeholder="Enter Age" type="number" min="0"
                                    value="{{ $user->age }}"
                                    class="border border-gray-300 shadow-sm w-1/2 rounded-lg px-3 py-2">
                                @error('age')
                                <p class="text-red-400 font-medium">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                            <div class="my-3">
                                <select id="gender" name="gender"
                                    class="border border-gray-300 shadow-sm w-1/2 rounded-lg px-3 py-2">
                                    <option value="" disabled {{ old('gender', $user->gender) ? '' : 'selected' }}>
                                        Select Gender</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                        Male</option>
                                    <option value="female"
                                        {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other"
                                        {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>
                                        Other</option>
                                </select>
                                @error('gender')
                                <p class="text-red-400 font-medium">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-5 gap-x-6 gap-y-4 mt-4">
                                @if ($roles->isNotEmpty())
                                @foreach ($roles as $role)
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="role-{{ $role->id }}" name="roles[]"
                                        value="{{ $role->id }}" class="rounded text-emerald-600 focus:ring-emerald-500"
                                        {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <label for="role-{{ $role->id }}" class="text-gray-700 text-sm">
                                        {{ $role->name }}
                                    </label>
                                </div>
                                @endforeach
                                @endif
                            </div>

                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 w-40 rounded-lg shadow-md transition duration-200 ease-in-out mt-4">
                                Submit
                            </button>
                        </div>
                    </form>
                    <script src="{{ asset('js/main.js') }}"></script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>