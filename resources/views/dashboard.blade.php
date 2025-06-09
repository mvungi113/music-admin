@extends('layouts.new_app')

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
            <div class="bg-gradient-to-br from-indigo-100 to-white p-8 rounded-xl shadow text-center hover:shadow-lg transition">
                <div class="text-4xl font-extrabold text-indigo-600">{{ $total_submissions ?? 0 }}</div>
                <div class="text-gray-500 mt-2 text-base">Total Submissions</div>
            </div>
            <div class="bg-gradient-to-br from-green-100 to-white p-8 rounded-xl shadow text-center hover:shadow-lg transition">
                <div class="text-4xl font-extrabold text-green-600">{{ $approved_content ?? 0 }}</div>
                <div class="text-gray-500 mt-2 text-base">Approved Content</div>
            </div>
            <div class="bg-gradient-to-br from-red-100 to-white p-8 rounded-xl shadow text-center hover:shadow-lg transition">
                <div class="text-4xl font-extrabold text-red-600">{{ $flagged_content ?? 0 }}</div>
                <div class="text-gray-500 mt-2 text-base">Flagged Content</div>
            </div>
            <div class="bg-gradient-to-br from-yellow-100 to-white p-8 rounded-xl shadow text-center hover:shadow-lg transition">
                <div class="text-4xl font-extrabold text-yellow-600">{{ $active_artists ?? 0 }}</div>
                <div class="text-gray-500 mt-2 text-base">Active Artists</div>
            </div>
            <div class="bg-gradient-to-br from-purple-100 to-white p-8 rounded-xl shadow text-center hover:shadow-lg transition">
                <div class="text-4xl font-extrabold text-purple-600">{{ $pending_content ?? 0 }}</div>
                <div class="text-gray-500 mt-2 text-base">Pending Music</div>
            </div>
        </div>

        <!-- Line Graph -->
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l6-6 4 4 8-8"></path>
                </svg>
                Content Overview (7-Day Trend)
            </h2>
            <canvas id="contentLineChart" height="100"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('contentLineChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chart_labels ?? []) !!},
            datasets: [
                {
                    label: 'Total Submissions',
                    data: {!! json_encode($chart_total_submissions ?? []) !!},
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
                {
                    label: 'Approved Content',
                    data: {!! json_encode($chart_approved_content ?? []) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
                {
                    label: 'Flagged Content',
                    data: {!! json_encode($chart_flagged_content ?? []) !!},
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239,68,68,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
                {
                    label: 'Pending Music',
                    data: {!! json_encode($chart_pending_content ?? []) !!},
                    borderColor: '#a855f7',
                    backgroundColor: 'rgba(168,85,247,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#111',
                    bodyColor: '#333',
                    borderColor: '#6366f1',
                    borderWidth: 1,
                    padding: 12,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#888', font: { weight: 'bold' } }
                },
                y: {
                    grid: { color: '#f3f4f6' },
                    ticks: { color: '#888', font: { weight: 'bold' } }
                }
            }
        }
    });
});
</script>
@endpush
