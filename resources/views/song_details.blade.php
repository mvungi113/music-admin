@extends('layouts.new_app')

@section('content')
<div class="py-10 bg-gradient-to-br from-indigo-50 to-white min-h-screen">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Song Info & Audio -->
        <div class="bg-white rounded-3xl shadow-xl p-10 mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-indigo-800 mb-1">{{ $song_title ?? '-' }}</h2>
                    <p class="text-lg text-gray-500">by <span class="font-semibold text-gray-800">{{ $artist_name ?? '-' }}</span></p>
                </div>
                <div class="flex items-center space-x-2 mt-4 md:mt-0">
                    <span class="inline-block bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-sm font-semibold shadow">ID: {{ $song_id }}</span>
                </div>
            </div>
            @if (!empty($song_url) && $song_url !== '#')
                <div class="flex flex-col items-center space-y-4 mb-2">
                    <audio controls class="w-full rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <source src="{{ $song_url }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            @else
                <p class="text-red-600 font-semibold text-center">Audio not available.</p>
            @endif
        </div>

        <!-- Lyrics with Scroll -->
        <div class="bg-white rounded-3xl shadow-xl p-10 mb-10">
            <h3 class="font-bold text-xl mb-4 text-indigo-700 flex items-center">
               
                Lyrics
            </h3>
            <div 
                class="text-gray-700 whitespace-pre-line bg-indigo-50 rounded-xl p-6 border border-indigo-100 font-mono text-base shadow-inner"
                style="max-height: 300px; overflow-y: auto; min-height: 120px;">
                {{ !empty($lyrics) && $lyrics !== 'Lyrics not available.' ? $lyrics : 'Lyrics not available.' }}
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-3xl shadow-xl p-8 flex flex-col md:flex-row justify-center items-center space-y-4 md:space-y-0 md:space-x-8">
            <form method="POST" action="{{ route('song.approve', ['id' => $song_id]) }}">
                @csrf
                <button type="submit" class="flex items-center bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-2 rounded-full shadow transition focus:outline-none focus:ring-2 focus:ring-green-400">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                    Approve
                </button>
            </form>
            <form method="POST" action="{{ route('song.reject', ['id' => $song_id]) }}">
                @csrf
                <button type="submit" class="flex items-center bg-red-500 hover:bg-red-600 text-white font-bold px-8 py-2 rounded-full shadow transition focus:outline-none focus:ring-2 focus:ring-red-400">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                    Reject
                </button>
            </form>
            <form method="POST" action="{{ route('song.pending', ['id' => $song_id]) }}">
                @csrf
                <button type="submit" class="flex items-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-8 py-2 rounded-full shadow transition focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 8v4l3 3"></path></svg>
                    Pending
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
