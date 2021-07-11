<x-app-layout>
    <x-slot name="title">{{ __('Dashboard') }}</x-slot>

    <div class="max-w-2xl py-4 md:py-12 mx-auto px-2 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="py-2 px-2 md:px-6 md:py-6 bg-white border-b border-gray-200">

                <div class="flex justify-between mb-3 items-center" x-data="{isModalActive: false}">
                    <div class="text-lg font-semibold">Boards</div>
                    <div>
                        <x-button buttonType="light" padding="px-2 sm:px-2.5" x-on:click="isModalActive = ! isModalActive">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <div>Add Board</div>
                        </x-button>
                    </div>

                    <x-modal x-show="isModalActive" toggle="isModalActive" type="info">
                        <x-slot name="header">
                            <div id="modal-title">
                                <h3 class="text-md md:text-lg font-semibold leading-6text-gray-900">
                                    <span>Add Board</span>
                                </h3>
                            </div>
                        </x-slot>
                        <x-slot name="body">
                            <div class="mt-5 md:mt-8 text-sm text-gray-500 space-y-2">
                                <form method="POST" action="{{ route('boards.store') }}">
                                    @csrf

                                    <div class="flex">
                                        <x-input id="title" class="block w-full" type="text" name="title" :value="old('title')" placeholder="{{ __('Title') }}" required x-ref="name" autofocus />
                                        <x-button class="ml-3" type="submit">
                                            {{ __('Create') }}
                                        </x-button>
                                    </div>
                                </form>
                            </div>
                        </x-slot>
                    </x-modal>
                </div>
                <div class="flex space-x-2">
                    @foreach ($boards as $board)
                        <a href="{{ route('boards.show', $board) }}" class="px-2 py-1 bg-blue-100 border-2 border-blue-200 rounded hover:bg-blue-200">{{$board->title}}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
