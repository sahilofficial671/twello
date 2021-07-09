<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-3 text-lg">Boards</div>
                    <div class="flex">
                        @foreach ($boards as $board)
                            <a href="{{ route('boards.show', $board) }}" class="p-3 bg-blue-100 border-2 border-blue-200 rounded hover:bg-blue-200">{{$board->title}}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
