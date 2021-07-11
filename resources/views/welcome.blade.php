<x-app-layout>
    <x-slot name="title">Twello - Project Management!</x-slot>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
        <div class="lg:max-w-2xl lg:w-full sm:text-center lg:text-left">
            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                <span class="inline">Working on projects</span>
                <span class="text-blue-600 inline">Made Easy</span>
            </h1>
            <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                Customise your setup to best fit your team. Easiest way to manage your projects and tasks.
            </p>
            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                <div class="rounded-md shadow">
                    @guest
                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                            Get started
                        </a>
                    @endguest
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                            Go to Dashboard
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <img alt="Cloud" class="w-auto mx-auto px-6 mt-8 sm:mt-10 sm:max-w-lg md:mt-0" src="{{ url('/images/bg-image-1.png')}}">
    </div>
</x-app-layout>
