<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Profil Saya') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola informasi profil dan pengaturan akun Anda</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Header Card -->
            <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-blue-600 to-indigo-800 rounded-3xl shadow-2xl p-6 md:p-10 mb-6 border border-white/10 mx-auto w-full max-w-full">
                <!-- Abstract Background Elements -->
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-64 h-64 bg-blue-300 opacity-20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-to-r from-transparent via-white/5 to-transparent skew-x-12 pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center md:items-center gap-6 md:gap-8">
                    <!-- Profile Photo Container -->
                    <div class="relative group shrink-0">
                        <!-- Glow Effect -->
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-300 to-indigo-300 rounded-full blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                        
                        @if($user->profile && $user->profile->photo_path)
                            <img src="{{ asset('storage/' . $user->profile->photo_path) }}" 
                                 alt="{{ $user->name }}" 
                                 class="relative w-28 h-28 md:w-36 md:h-36 rounded-full border-4 border-white/90 shadow-2xl object-cover transition transform group-hover:scale-105 duration-300 bg-white mx-auto">
                        @else
                            <div class="relative w-28 h-28 md:w-36 md:h-36 mx-auto rounded-full border-4 border-white/90 shadow-2xl bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center transition transform group-hover:scale-105 duration-300">
                                <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Pulse Online Status -->
                        <div class="absolute bottom-1 right-1 md:bottom-2 md:right-2 flex items-center justify-center">
                            <span class="absolute inline-flex h-6 w-6 md:h-8 md:w-8 rounded-full bg-green-400 opacity-75 animate-ping"></span>
                            <span class="relative inline-flex rounded-full h-5 w-5 md:h-6 md:w-6 bg-green-500 border-2 border-white shadow-sm"></span>
                        </div>
                    </div>
                    
                    <!-- User Info -->
                    <div class="flex-1 w-full text-center md:text-left text-white mt-2 md:mt-0">
                        <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold tracking-tight drop-shadow-md break-words">{{ $user->name }}</h3>
                        <p class="text-blue-100 mt-1 md:mt-2 text-base md:text-lg font-medium opacity-90">{{ $user->profile->last_position ?? 'Pencari Kerja' }}</p>
                        
                        <div class="flex flex-col sm:flex-row flex-wrap gap-2 md:gap-3 mt-5 justify-center md:justify-start w-full max-w-xs sm:max-w-none mx-auto sm:mx-0">
                            <div class="flex items-center justify-center md:justify-start gap-2 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 rounded-full px-4 py-2 shadow-sm group cursor-default w-full sm:w-auto">
                                <div class="bg-white/20 p-1.5 rounded-full group-hover:bg-white/30 hidden sm:block">
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4 text-blue-100" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs md:text-sm font-medium tracking-wide text-white truncate">{{ $user->email }}</span>
                            </div>
                            
                            @if($user->profile && $user->profile->phone_number)
                            <div class="flex items-center justify-center md:justify-start gap-2 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 rounded-full px-4 py-2 shadow-sm group cursor-default w-full sm:w-auto">
                                <div class="bg-white/20 p-1.5 rounded-full group-hover:bg-white/30 hidden sm:block">
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4 text-blue-100" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs md:text-sm font-medium tracking-wide text-white truncate">{{ $user->profile->phone_number }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="mb-6" x-data="{ activeTab: 'profile' }">
                <div class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-t-xl shadow-sm">
                    <nav class="flex space-x-4 px-6" aria-label="Tabs">
                        <button @click="activeTab = 'profile'" 
                                :class="activeTab === 'profile' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            Informasi Profil
                        </button>
                        <button @click="activeTab = 'security'" 
                                :class="activeTab === 'security' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Keamanan
                        </button>
                        <button @click="activeTab = 'danger'" 
                                :class="activeTab === 'danger' ? 'border-red-600 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Zona Berbahaya
                        </button>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-b-xl">
                    <!-- Profile Information Tab -->
                    <div x-show="activeTab === 'profile'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="p-6 sm:p-8">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div x-show="activeTab === 'security'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="p-6 sm:p-8">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Danger Zone Tab -->
                    <div x-show="activeTab === 'danger'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="p-6 sm:p-8">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
