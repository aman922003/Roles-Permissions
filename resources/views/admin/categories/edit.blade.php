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
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                @error('name')
                <div class="text-sm text-red-600 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                <div id="preview-container" class="mb-3">
                    @if($category->image)
                    <img id="image-preview" src="{{ asset('storage/' . $category->image) }}"
                        class="w-24 h-24 object-cover rounded-md border" alt="Current Image">
                    @else
                    <img id="image-preview" src="#" style="display:none;"
                        class="w-24 h-24 object-cover rounded-md border" alt="Preview">
                    @endif
                </div>
                <input name="image" id="image-input" type="file" accept="image/*">
                @error('image')
                <div class="text-red-600 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-200">
                    Update
                </button>
            </div>
        </form>
        <script src="{{ asset('js/main.js') }}"></script>
    </div>
</x-app-layout>