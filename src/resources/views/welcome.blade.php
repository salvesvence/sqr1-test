<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="container px-6 py-4 mx-auto">
                <div class="grid grid-cols-2">
                    <div>
                        @if(Request::get('sortBy') && Request::get('direction'))
                            <a href="{{ url('/?sortBy=' . Request::get('sortBy') . '&direction=' . (Request::get('direction') === 'asc' ? 'desc' : 'asc') . (Request::get('page') ? '&page=' . Request::get('page') : '')) }}"
                               class="mb-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Reverse Article's Order By Publication Date
                            </a>
                        @else
                            <a href="{{ url('/?sortBy=publication_date&direction=asc'. (Request::get('page') ? '&page=' . Request::get('page') : '')) }}"
                               class="mb-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Reverse Article's Order By Publication Date
                            </a>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @foreach($articles as $article)
                        <div class="h-full bg-white rounded overflow-hidden shadow-md hover:shadow-lg relative smooth">
                            <a href="#" class="no-underline hover:no-underline">
                                <div class="p-6 h-auto md:h-48">
                                    <p class="text-gray-600 text-xs md:text-sm mb-1.5">{{ $article->publication_date->toFormattedDateString() }}</p>
                                    <div class="font-bold text-xl text-gray-900 mb-3 truncate">{{ $article->title }}</div>
                                    <div class="h-50">
                                        <p class="text-gray-800 font-serif text-base line-clamp-3">
                                            {{ $article->description }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach()
                </div>
                <div class="grid grid-cols-1">
                    <div class="mt-6">
                        {{ $articles->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
