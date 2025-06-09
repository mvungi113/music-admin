@extends('layouts.new_app')

@section('content')
<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-8 flex items-center gap-2 text-gray-800">
           
            User Management
        </h2>
        <div class="bg-white rounded-xl shadow p-6">
            <table class="min-w-full text-sm text-left border-separate border-spacing-y-2">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="px-4 py-2 font-semibold rounded-l-lg">Artist Name</th>
                        <th class="px-4 py-2 font-semibold">Email</th>
                        <th class="px-4 py-2 font-semibold">Total Songs</th>
                        <th class="px-4 py-2 font-semibold rounded-r-lg">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($artists as $artist)
                        <tr class="bg-gray-50 hover:bg-indigo-50 transition rounded-lg shadow-sm">
                            <td class="px-4 py-2 font-medium text-gray-800">
                                {{ $artist['artist_name'] ?? '-' }}
                            </td>
                            <td class="px-4 py-2 text-gray-700">
                                {{ $artist['email'] ?? '-' }}
                            </td>
                            <td class="px-4 py-2 text-gray-700">
                                <span class="inline-block bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $artist['total_songs'] ?? 0 }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('artist.view', ['id' => $artist['user_id']]) }}"
                                   class="inline-flex items-center px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded transition text-xs font-semibold shadow">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-400">No artists found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection