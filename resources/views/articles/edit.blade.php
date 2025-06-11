<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Articles / Edit
            </h2>
            <a href="{{ route('articles.index') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-md transition duration-200 ease-in-out">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="articleEditForm" action="{{ route('articles.update', $article->id)}}" method="post"> @csrf
                        @method("PUT")
                        <div>
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input id="title" name="title" placeholder="Edit Title" type="text"
                                    value="{{old('title', $article->title)}}"
                                    class="border border-gray-300 shadow-sm w-1/2 rounded-lg px-3 py-2">
                                @error('title')
                                    <p class="text-red-400 font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <label for="text" class="text-lg font-medium">Content</label>
                            <div class="my-3">
                                <textarea name="text" id="text" cols="30" rows="10" placeholder="Enter Text"
                                    class="border border-gray-300 shadow-sm w-1/2 rounded-lg px-3 py-2">{{old('text', $article->text)}}</textarea>
                                @error('text')
                                    <p class="text-red-400 font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="my-3">
                                <input id="auther" name="auther" placeholder="Auther" type="text"
                                    value="{{old('auther', $article->auther)}}"
                                    class="border border-gray-300 shadow-sm w-1/2 rounded-lg px-3 py-2">
                                @error('auther')
                                    <p class="text-red-400 font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 w-40 rounded-lg shadow-md transition duration-200 ease-in-out mt-4">
                                Update
                            </button>
                        </div>
                    </form>
                    <!-- Include the external JS file -->
                    <script src="{{ asset('js/main.js') }}"></script>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>