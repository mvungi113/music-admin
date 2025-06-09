@extends('layouts.new_app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <div class="bg-white p-10 rounded shadow text-center">
                <div class="text-5xl font-extrabold text-gray-800">{{ $total_submissions ?? 0 }}</div>
                <div class="text-gray-500 mt-4 text-lg">Total Submissions</div>
            </div>
            <div class="bg-white p-10 rounded shadow text-center">
                <div class="text-5xl font-extrabold text-gray-800">{{ $approved_content ?? 0 }}</div>
                <div class="text-gray-500 mt-4 text-lg">Approved Content</div>
            </div>
            <div class="bg-white p-10 rounded shadow text-center">
                <div class="text-5xl font-extrabold text-gray-800">{{ $flagged_content ?? 0 }}</div>
                <div class="text-gray-500 mt-4 text-lg">Flagged Content</div>
            </div>
            <div class="bg-white p-10 rounded shadow text-center">
                <div class="text-5xl font-extrabold text-gray-800">{{ $active_artists ?? 0 }}</div>
                <div class="text-gray-500 mt-4 text-lg">Active Artists</div>
            </div>
            <div class="bg-white p-10 rounded shadow text-center">
                <div class="text-5xl font-extrabold text-gray-800">{{ $pending_content ?? 0 }}</div>
                <div class="text-gray-500 mt-4 text-lg">Pending Music</div>
            </div>
        </div>

        <!-- Line Graph -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold mb-4">Content Overview</h2>
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
                },
                {
                    label: 'Approved Content',
                    data: {!! json_encode($chart_approved_content ?? []) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.1)',
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'Flagged Content',
                    data: {!! json_encode($chart_flagged_content ?? []) !!},
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239,68,68,0.1)',
                    fill: true,
                    tension: 0.4,
                },
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            }
        }
    });
});
</script>
@endpush
