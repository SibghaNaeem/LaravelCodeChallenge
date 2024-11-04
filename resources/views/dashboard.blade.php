<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>

                @if(!empty($jokes))
                    @foreach($jokes as $joke)
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <p>{{ $joke['setup'] ?? '' }}</p>
                            <p>{{ $joke['punchline'] ?? '' }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p>{{ $error ?? 'No joke found' }}</p>
                    </div>
                @endif

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <button class="mt-4 px-6 py-2 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-700 transition duration-300" onclick="location.reload()">Refresh</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
