@extends('layouts.new_app')

@section('content')
<div class="py-10 bg-gray-100 min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg p-10">
            <!-- Artist Info -->
            <div class="mb-10">
                <div class="text-2xl font-extrabold mb-1 text-gray-800">{{ $artist['first_name'] ?? '' }} {{ $artist['last_name'] ?? '' }}</div>
                <div class="mb-2 text-lg"><span class="font-semibold text-gray-600">Artist Name:</span> <span class="text-gray-700">{{ $artist['artist_name'] ?? '-' }}</span></div>
                <div class="mb-2 text-lg"><span class="font-semibold text-gray-600">Email Address:</span> <span class="text-gray-700">{{ $artist['email'] ?? '-' }}</span></div>
                <div class="mb-2 text-lg"><span class="font-semibold text-gray-600">Phone Number:</span> <span class="text-gray-700">{{ $artist['phone'] ?? '-' }}</span></div>
            </div>
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="bg-indigo-50 rounded-xl p-8 flex flex-col items-center shadow">
                    <div class="text-indigo-500 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-music-note-list" viewBox="0 0 16 16">
                            <path d="M12 13c0 1.105-1.12 2-2.5 2S7 14.105 7 13s1.12-2 2.5-2 2.5.895 2.5 2zm-2.5 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            <path fill-rule="evenodd" d="M12 3v10h-1V3h1z"/>
                            <path d="M11 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                            <path d="M0 11.5A.5.5 0 0 1 .5 11h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-3A.5.5 0 0 1 .5 8h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-3A.5.5 0 0 1 .5 5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </div>
                    <div class="text-gray-500 mb-1 text-lg">Songs Submitted</div>
                    <div class="text-4xl font-extrabold text-indigo-700">{{ $artist['total_songs'] ?? 0 }}</div>
                </div>
                <div class="bg-green-50 rounded-xl p-8 flex flex-col items-center shadow">
                    <div class="text-green-500 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.32-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.63.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                    </div>
                    <div class="text-gray-500 mb-1 text-lg">Quality Score</div>
                    <div class="text-4xl font-extrabold text-green-700">
                        {{ $artist['quality_score'] ?? 'N/A' }}<span class="text-lg font-normal">/10</span>
                    </div>
                </div>
            </div>
            <!-- Recent Lyrics Analysis -->
            <div class="bg-gray-50 rounded-xl p-8 mt-4 shadow">
                <div class="font-semibold text-lg mb-2 text-gray-700">Recent Lyrics Analysis</div>
                <div class="mb-1 text-gray-800 font-medium">{{ $artist['recent_lyrics_title'] ?? 'N/A' }}</div>
                <div class="text-sm text-gray-500 mb-2">
                    Analyzed {{ $artist['recent_lyrics_date'] ?? 'N/A' }}
                </div>
                @if(isset($artist['recent_lyrics_score']))
                    <span class="inline-block bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-semibold">
                        Score {{ $artist['recent_lyrics_score'] }}/10
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection