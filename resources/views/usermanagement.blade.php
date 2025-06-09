@extends('layouts.new_app')

@section('content')
<div class="py-8">
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-6">User Management</h2>
        <div class="bg-white rounded shadow p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Artist Name</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total Songs</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($artists as $artist)
                        <tr>
                            <td class="px-4 py-2">{{ $artist['artist_name'] ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $artist['email'] ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $artist['total_songs'] ?? 0 }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('artist.view', ['id' => $artist['user_id']]) }}" class="text-indigo-600 hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-400">No artists found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection