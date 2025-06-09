{{-- filepath: resources/views/offensive_content_review.blade.php --}}
@extends('layouts.new_app')

@section('content')
<main class="flex-1 bg-gray-50 min-h-screen p-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
            <h2 class="text-2xl font-semibold text-gray-800">Offensive Content Moderation</h2>
            <form method="GET" action="{{ route('offensive_content_review') }}" class="w-full md:w-auto">
                <input type="text" name="search" placeholder="Search Content..." value="{{ request('search') }}"
                    class="border rounded-lg px-4 py-2 w-full md:w-64 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition" />
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
            <div class="bg-white p-8 rounded-xl shadow text-center">
                <div class="text-4xl font-extrabold text-indigo-700">{{ $total_submissions ?? 0 }}</div>
                <div class="text-gray-500 mt-2 text-base">Total Submissions</div>
            </div>
            <div class="bg-white p-8 rounded-xl shadow text-center">
                <div class="text-4xl font-extrabold text-green-600">{{ $approved_content ?? 0 }}</div>
                <div class="text-gray-500 mt-2 text-base">Approved Content</div>
            </div>
            <div class="bg-white p-8 rounded-xl shadow text-center">
                <div class="text-4xl font-extrabold text-red-600">{{ $flagged_content ?? 0 }}</div>
                <div class="text-gray-500 mt-2 text-base">Flagged Content</div>
            </div>
            <div class="bg-white p-8 rounded-xl shadow text-center">
                <div class="text-4xl font-extrabold text-blue-600">{{ $active_artists ?? 0 }}</div>
                <div class="text-gray-500 mt-2 text-base">Active Artists</div>
            </div>
            <div class="bg-white p-8 rounded-xl shadow text-center">
                <div class="text-4xl font-extrabold text-yellow-600">{{ $pending_content ?? 0 }}</div>
                <div class="text-gray-500 mt-2 text-base">Pending Music</div>
            </div>
        </div>

        {{-- Tabs --}}
        @php
            $tab = request('tab', 'pending');
        @endphp
        <div class="flex gap-8 mb-6 border-b pb-2">
            <div>
                <a href="{{ route('offensive_content_review', ['tab' => 'pending']) }}"
                   class="{{ $tab === 'pending' ? 'text-indigo-600 font-semibold border-b-2 border-indigo-600 pb-1' : 'text-gray-400 font-semibold' }}">
                    Pending Content
                </a>
                <span class="ml-1 inline-block bg-indigo-100 text-indigo-700 text-xs rounded-full px-2 py-0.5">{{ count($pendingContents) }}</span>
            </div>
            <div>
                <a href="{{ route('offensive_content_review', ['tab' => 'reviewed']) }}"
                   class="{{ $tab === 'reviewed' ? 'text-indigo-600 font-semibold border-b-2 border-indigo-600 pb-1' : 'text-gray-400 font-semibold' }}">
                    Reviewed Content
                </a>
                <span class="ml-1 inline-block bg-green-100 text-green-700 text-xs rounded-full px-2 py-0.5">{{ count($reviewedContents) }}</span>
            </div>
            <div>
                <a href="{{ route('offensive_content_review', ['tab' => 'flagged']) }}"
                   class="{{ $tab === 'flagged' ? 'text-indigo-600 font-semibold border-b-2 border-indigo-600 pb-1' : 'text-gray-400 font-semibold' }}">
                    Flagged Content
                </a>
                <span class="ml-1 inline-block bg-red-100 text-red-700 text-xs rounded-full px-2 py-0.5">{{ count($flaggedContents) }}</span>
            </div>
        </div>

        {{-- Content List --}}
        @if($tab === 'reviewed')
            @forelse($reviewedContents as $content)
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-2 gap-2">
                        <div>
                            <div class="font-semibold text-gray-900 text-lg">{{ $content['title'] ?? '-' }}</div>
                            <div class="text-xs text-gray-500 mb-1">
                                by {{ $active_artist_names[$content['user_id']] ?? '-' }}
                                &middot; Submitted: {{ isset($content['created_at']) ? \Carbon\Carbon::parse($content['created_at'])->format('Y-m-d H:i') : '-' }}
                            </div>
                        </div>
                        <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">Approved</span>
                    </div>
                    <div class="mb-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
                            <div>
                                <span class="text-xs text-gray-500">Quality:</span>
                                <span class="font-semibold text-gray-800">{{ $content['quality'] ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500">Offensive Count:</span>
                                <span class="font-semibold text-gray-800">{{ $content['offensive_count'] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mb-1 mt-2">Offensive Words Detected:</div>
                        <div class="text-sm text-red-700 mb-1 break-words">
                            @if(!empty($content['offensive_words']))
                                @if(is_array($content['offensive_words']))
                                    {{ implode(', ', $content['offensive_words']) }}
                                @else
                                    {{ $content['offensive_words'] }}
                                @endif
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                        <div class="text-right md:ml-auto">
                            <a href="{{ route('audio.view', ['id' => $content['id']]) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition text-xs">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow p-6 text-center text-gray-400">No reviewed content.</div>
            @endforelse
        @elseif($tab === 'flagged')
            @forelse($flaggedContents as $content)
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-2 gap-2">
                        <div>
                            <div class="font-semibold text-gray-900 text-lg">{{ $content['title'] ?? '-' }}</div>
                            <div class="text-xs text-gray-500 mb-1">
                                by {{ $active_artist_names[$content['user_id']] ?? '-' }}
                                &middot; Submitted: {{ isset($content['created_at']) ? \Carbon\Carbon::parse($content['created_at'])->format('Y-m-d H:i') : '-' }}
                            </div>
                        </div>
                        <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full">Flagged</span>
                    </div>
                    <div class="mb-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
                            <div>
                                <span class="text-xs text-gray-500">Quality:</span>
                                <span class="font-semibold text-gray-800">{{ $content['quality'] ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500">Offensive Count:</span>
                                <span class="font-semibold text-gray-800">{{ $content['offensive_count'] ?? 0 }}</span>
                            </div>
                        </div>
                      
                        <div class="text-xs text-gray-500 mb-1 mt-2">Offensive Words Detected:</div>
                        <div class="text-sm text-red-700 mb-1 break-words">
                            @if(!empty($content['offensive_words']))
                                @if(is_array($content['offensive_words']))
                                    {{ implode(', ', $content['offensive_words']) }}
                                @else
                                    {{ $content['offensive_words'] }}
                                @endif
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                        <div class="text-right md:ml-auto">
                            <a href="{{ route('audio.view', ['id' => $content['id']]) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition text-xs">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow p-6 text-center text-gray-400">No flagged content.</div>
            @endforelse
        @else
            @forelse($pendingContents as $content)
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-2 gap-2">
                        <div>
                            <div class="font-semibold text-gray-900 text-lg">{{ $content['title'] ?? '-' }}</div>
                            <div class="text-xs text-gray-500 mb-1">
                                by {{ $active_artist_names[$content['user_id']] ?? '-' }}
                                &middot; Submitted: {{ isset($content['created_at']) ? \Carbon\Carbon::parse($content['created_at'])->format('Y-m-d H:i') : '-' }}
                            </div>
                        </div>
                        @if(!empty($content['is_high_risk']))
                            <span class="bg-pink-100 text-pink-700 text-xs font-bold px-3 py-1 rounded-full">High risk</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
                            <div>
                                <span class="text-xs text-gray-500">Quality:</span>
                                <span class="font-semibold text-gray-800">{{ $content['quality'] ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500">Offensive Count:</span>
                                <span class="font-semibold text-gray-800">{{ $content['offensive_count'] ?? 0 }}</span>
                            </div>
                        </div>
                       
                        <div class="text-xs text-gray-500 mb-1 mt-2">Offensive Words Detected:</div>
                        <div class="text-sm text-red-700 mb-1 break-words">
                            @if(!empty($content['offensive_words']))
                                @if(is_array($content['offensive_words']))
                                    {{ implode(', ', $content['offensive_words']) }}
                                @else
                                    {{ $content['offensive_words'] }}
                                @endif
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                        <div class="text-right md:ml-auto">
                            <a href="{{ route('audio.view', ['id' => $content['id']]) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition text-xs">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow p-6 text-center text-gray-400">No pending content.</div>
            @endforelse
        @endif
    </div>
</main>
@endsection