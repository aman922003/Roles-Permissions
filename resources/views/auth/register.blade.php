<x-guest-layout>
    <form method="POST" action="{{ route('register') }}"
        class="max-w-xl mx-auto mt-10 space-y-6 bg-white p-8 rounded-xl shadow-lg">
        @csrf

        <h2 class="text-2xl font-bold text-gray-800 text-center">Create an Account</h2>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required
                autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Age -->
        <div>
            <x-input-label for="age" :value="__('Age')" />
            <x-text-input id="age" class="mt-1 block w-full" type="number" min="10" max="100" name="age"
                :value="old('age')" required />
            <x-input-error :messages="$errors->get('age')" class="mt-2" />
        </div>

        <!-- Gender -->
        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" required
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mb-4">
            <label for="role" class="block font-medium text-sm text-gray-700">Role <span
                    class="text-danger">*</span></label>
            <select name="role" id="role" required class="form-select rounded-md shadow-sm mt-1 w-full">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
            @error('role')
                <p class="text-danger text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        <!-- Register Button -->    
        <div class="flex items-center justify-between">
            <a class="text-sm text-indigo-600 hover:underline" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>