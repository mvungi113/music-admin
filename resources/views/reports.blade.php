{{-- filepath: resources/views/reports.blade.php --}}
@extends('layouts.new_app')

@section('content')
<main class="flex-1 p-10 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto">
        <!-- Filter & Export Container -->
        <div class="bg-white rounded-xl shadow p-6 mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <form method="GET" action="{{ route('reports') }}" class="flex flex-col md:flex-row md:items-end gap-4 w-full">
                <!-- From Date -->
                <div>
                    <label for="from" class="block text-xs font-semibold text-gray-600">From</label>
                    <input 
                        type="date" 
                        id="from" 
                        name="from" 
                        value="{{ request('from') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                    >
                </div>
                <!-- To Date -->
                <div>
                    <label for="to" class="block text-xs font-semibold text-gray-600">To</label>
                    <input 
                        type="date" 
                        id="to" 
                        name="to" 
                        value="{{ request('to') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                    >
                </div>
                <!-- Status Select -->
                <div>
                    <label for="status" class="block text-xs font-semibold text-gray-600">Status</label>
                    <select 
                        id="status" 
                        name="status" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                    >
                        <option value="">All</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="flagged" {{ request('status') == 'flagged' ? 'selected' : '' }}>Flagged</option>
                    </select>
                </div>
                <!-- Apply Button -->
                <div class="flex items-end">
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition w-full md:w-auto"
                    >
                        Apply
                    </button>
                </div>
            </form>
            <!-- Export Button -->
            <div class="flex items-end">
                <a href="{{ route('reports.export', request()->query()) }}"
                   class="inline-flex items-center px-6 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 transition w-full md:w-auto text-center justify-center"
                >
                 
                    Export PDF
                </a>
            </div>
        </div>

        <!-- Submissions Table -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
               
                Recent Submissions
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="px-4 py-2 font-semibold rounded-l-lg">ARTIST NAME</th>
                            <th class="px-4 py-2 font-semibold">SONG TITLE</th>
                            <th class="px-4 py-2 font-semibold">STATUS</th>
                            <th class="px-4 py-2 font-semibold">QUALITY</th>
                            <th class="px-4 py-2 font-semibold rounded-r-lg">SUBMITTED</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $submission)
                            <tr class="bg-gray-50 hover:bg-indigo-50 transition rounded-lg shadow-sm">
                                <td class="px-4 py-2 font-medium text-gray-800">
                                    {{ $submission['artist_name'] ?? '-' }}
                                </td>
                                <td class="px-4 py-2 text-gray-700">
                                    {{ $submission['title'] ?? '-' }}
                                </td>
                                <td class="px-4 py-2 font-semibold
                                    @if(strtolower($submission['status'] ?? '') === 'approved') text-green-600
                                    @elseif(strtolower($submission['status'] ?? '') === 'pending') text-yellow-600
                                    @elseif(strtolower($submission['status'] ?? '') === 'flagged' || strtolower($submission['status'] ?? '') === 'rejected') text-red-600
                                    @else text-gray-600 @endif">
                                    {{ ucfirst($submission['status'] ?? '-') }}
                                </td>
                                <td class="px-4 py-2 text-gray-700">{{ $submission['quality'] ?? '-' }}</td>
                                <td class="px-4 py-2 text-gray-500">
                                    {{ isset($submission['created_at']) ? \Carbon\Carbon::parse($submission['created_at'])->format('Y-m-d') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-400">No submissions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
