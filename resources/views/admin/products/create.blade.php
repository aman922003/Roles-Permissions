<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products / Create
            </h2>
            <a href="{{ route('admin.products.index') }}"
               class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-md transition duration-200">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        @error('name')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Description</label>
                        <textarea name="description" rows="4" required
                                  class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Category</label>
                        <select name="category_id" required
                                class="w-full border border-gray-300 rounded-md px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Price</label>
                        <input type="number" name="price" step="0.01" value="{{ old('price') }}" required
                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        @error('price')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Image --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-1">Image</label>
                        <input type="file" name="image" accept="image/*" onchange="previewImage(event)"
                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none">
                        @error('image')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror

                        <div class="mt-4">
                            <img id="imagePreview" src="#" alt="Selected Image"
                                 class="hidden rounded-md w-48 h-48 object-cover border border-gray-300" />
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-md shadow-md transition duration-200">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JS for preview --}}
    <script src="{{ asset('js/main.js') }}"></script>
        </script>
</x-app-layout>
