<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categories / Create
            </h2>
            <a href="{{ route('admin.categories.index') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-md transition duration-200">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form id="categoryForm" action="{{ route('admin.categories.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p id="name-error" class="text-red-600 text-sm mt-1 hidden"></p>
                    </div>

                    {{-- Image --}}
                    <div class="mb-6">
                        <label for="image" class="block text-gray-700 font-medium mb-1">Image</label>

                        {{-- Preview Container --}}
                        <div id="preview-container" class="mb-3">
                            @isset($category->image)
                            <img id="image-preview" src="{{ asset('storage/' . $category->image) }}"
                                class="w-24 h-24 object-cover rounded-md border" alt="Current Image">
                            @else
                            <img id="image-preview" src="#" class="w-24 h-24 object-cover rounded-md border hidden"
                                alt="Preview">
                            @endisset
                        </div>

                        {{-- Image Input --}}
                        <input type="file" name="image" id="image" accept="image/*"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">

                        @error('image')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p id="image-error" class="text-red-600 text-sm mt-1 hidden"></p>
                    </div>


                    {{-- Submit --}}
                    <div>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-md shadow-md transition duration-200">
                            Save
                        </button>
                    </div>
                </form>
                <script src="{{ asset('js/ecommerce-validation.js') }}"></script>
            </div>
        </div>
    </div>
</x-app-layout>