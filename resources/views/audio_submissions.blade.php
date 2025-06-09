@extends('layouts.new_app')

@section('content')
<div class="py-10 bg-gradient-to-br from-indigo-50 to-white min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-extrabold text-indigo-800 flex items-center">
                Audio and Lyrics Submissions
            </h2>
        </div>
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-indigo-50 text-indigo-700">
                        <th class="px-6 py-4 text-left font-semibold">Song</th>
                        <th class="px-6 py-4 text-left font-semibold">Artist</th>
                        <th class="px-6 py-4 text-left font-semibold">Genre</th>
                        <th class="px-6 py-4 text-left font-semibold">Language</th>
                        <th class="px-6 py-4 text-left font-semibold">Status</th>
                        <th class="px-6 py-4 text-left font-semibold">Submitted</th>
                        <th class="px-6 py-4 text-left font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($submissions as $submission)
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $submission['title'] ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $submission['artist_name'] ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $submission['genre'] ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $submission['language'] ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($submission['status'] === 'approved')
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                        Approved
                                    </span>
                                @elseif($submission['status'] === 'rejected')
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                        Rejected
                                    </span>
                                @elseif($submission['status'] === 'pending')
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">
                                        {{ ucfirst($submission['status'] ?? '-') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ isset($submission['created_at']) ? \Carbon\Carbon::parse($submission['created_at'])->format('Y-m-d') : '-' }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('audio.view', ['id' => $submission['id']]) }}"
                                   class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-semibold rounded-lg shadow transition">
                                    View
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                                        <path d="M9 12h6m-2-2 2 2-2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">No submissions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection