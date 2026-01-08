<!DOCTYPE html>
<html lang="en">

<x-page-title>
    <x-slot:title> Profile </x-slot:title>
</x-page-title>

<body class="bg-gray-50 text-gray-800 antialiased">

    <x-navbar> </x-navbar>

    <div class="font-std mb-10 w-full rounded-2xl bg-white p-10 font-normal leading-relaxed text-gray-900 shadow-xl">

        <div class="flex flex-col">
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ session('status') }}</p>
                </div>
            @endif
            {{-- Added enctype here --}}
            <form action="{{ route('profile.change') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="flex flex-col md:flex-row justify-between mb-5 items-start">
                    <h2 class="mb-5 text-4xl font-bold text-blue-900">Update Profile</h2>
                    <div class="text-center">
                        <div>
                            {{-- Added a fallback for the image src --}}
                            <img src="{{ $user->prof_img ? asset('storage/' . $user->prof_img) : 'https://ui-avatars.com/api/?name=' . $user->name }}"
                                alt="Profile Picture"
                                class="rounded-full w-32 h-32 mx-auto border-4 border-indigo-800 mb-4 transition-transform duration-300 hover:scale-105 ring ring-gray-300">

                            {{-- Changed name="profile" to name="prof_img" to match Controller --}}
                            <input type="file" name="prof_img" id="upload_profile" hidden required>

                            <label for="upload_profile" class="inline-flex items-center cursor-pointer bg-indigo-800 text-white px-4 py-2 rounded-lg hover:bg-blue-900 transition-colors duration-300 ring ring-gray-300 hover:ring-indigo-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </label>
                        </div>
                        <button type="submit"
                            class="bg-indigo-800 text-white px-4 py-2 rounded-lg hover:bg-blue-900 transition-colors duration-300 ring ring-gray-300 hover:ring-indigo-300">

                            Change Profile Picture

                        </button>
                    </div>
                </div>
            </form>

            <!-- Bilgi Düzenleme Formu -->
            <form action="{{ route('profile.update') }}" class="space-y-4" method="POST">
                @csrf
                @method('PATCH')
                <!-- İsim ve Unvan -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('name', $user->name) }}">
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('username', $user->username) }}">
                    @error('username')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- İletişim Bilgileri -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('email', $user->email) }}">
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="tel" id="phone_number" name="phone_number"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('phone_number', $user->phone_number) }}">
                    @error('phone_number')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" id="address" name="address"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('address', $user->address) }}">
                </div>

                <!-- Kaydet ve İptal Butonları -->
                <div class="flex justify-end space-x-4">
                    <button type="button"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-800 text-white rounded-lg hover:bg-indigo-700">Save Changes</button>
                </div>
            </form>
        </div>

    </div>
</body>

</html>
