<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles / EditPermissions
            </h2>
            <a href="{{ route('roles.index') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-md transition duration-200 ease-in-out">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('roles.update', $role->id) }}" method="post">
                        @csrf
                        <div>
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input id="name" name="name" placeholder="Enter Name" type="text"
                                    value="{{$role->name}}"
                                    class="border border-gray-300 shadow-sm w-1/2 rounded-lg px-3 py-2">
                                @error('name')
                                    <p class="text-red-400 font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-5 gap-x-6 gap-y-4 mt-4">
                                @if ($permissions->isNotEmpty())
                                    @foreach ($permissions as $permission)
                                        <div class="flex items-center space-x-2">
                                            <input {{ $hasPermissions->contains($permission->name) ? 'checked' : '' }}
                                                type="checkbox" id="permission-{{ $permission->id }}" name="permission[]"
                                                value="{{ $permission->name }}"
                                                class="rounded text-emerald-600 focus:ring-emerald-500">
                                            <label for="permission-{{ $permission->id }}" class="text-gray-700 text-sm">
                                                {{ $permission->name }}
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
                </div>
            </div>
        </div>
    </div>

</x-app-layout>