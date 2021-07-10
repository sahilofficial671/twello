<x-app-layout>
    <x-slot name="title">{{ __('Dashboard') }}</x-slot>

    <div class="max-w-2xl py-12 mx-auto px-2 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-3 text-lg">Boards</div>
                <div class="flex">
                    @foreach ($boards as $board)
                        <a href="{{ route('boards.show', $board) }}" class="px-2 py-1 bg-blue-100 border-2 border-blue-200 rounded hover:bg-blue-200">{{$board->title}}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
