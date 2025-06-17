<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categories / Edit
            </h2>
            <a href="{{ route('admin.categories.index') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-md transition duration-200">
                Back
            </a>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-xl shadow-md">
        <form id="categoryEditForm" action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p id="name-error" class="text-red-600 text-sm mt-1 hidden"></p>
            </div>

            {{-- Image --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                <div id="preview-container" class="mb-3">
                    @if($category->image)
                        <img id="image-preview" src="{{ asset('storage/' . $category->image) }}"
                            class="w-24 h-24 object-cover rounded-md border" alt="Current Image">
                    @else
                        <img id="image-preview" src="#" class="w-24 h-24 object-cover rounded-md border hidden" alt="Preview">
                    @endif
                </div>
                    <input name="image" id="image" type="file" accept="image/*"
                        class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg">
                @error('image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p id="image-error" class="text-red-600 text-sm mt-1 hidden"></p>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-200">
                    Update
                </button>
            </div>
        </form>

        {{-- JavaScript --}}
        <script src="{{ asset('js/ecommerce-validation.js') }}"></script>
    </div>
</x-app-layout>
