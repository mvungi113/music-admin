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

        <!-- Chart Container with fixed height -->
        <div class="bg-white rounded-xl shadow p-6 mb-10">
            <h2 class="text-xl font-semibold mb-4">Song Status Trends (All Time)</h2>
            <div class="relative h-96 w-full">
                <canvas id="songStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Check if we have data to display
    const labels = {!! json_encode($chart_labels ?? []) !!};

    if (labels.length === 0) {
        // No data available, display a message
        const canvas = document.getElementById('songStatusChart');
        const ctx = canvas.getContext('2d');
        ctx.font = '16px Arial';
        ctx.fillStyle = '#666';
        ctx.textAlign = 'center';
        ctx.fillText('No data available for chart', canvas.width / 2, canvas.height / 2);
        return;
    }

    // Create chart with data
    const ctx = document.getElementById('songStatusChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Total Submissions',
                    data: {!! json_encode($chart_total_submissions ?? []) !!},
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'Approved',
                    data: {!! json_encode($chart_approved_content ?? []) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'Rejected',
                    data: {!! json_encode($chart_flagged_content ?? []) !!},
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239,68,68,0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'Pending',
                    data: {!! json_encode($chart_pending_content ?? []) !!},
                    borderColor: '#a855f7',
                    backgroundColor: 'rgba(168,85,247,0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: { 
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#333',
                    bodyColor: '#666',
                    borderColor: '#ddd',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { 
                        precision: 0,
                        color: '#666'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        color: '#666',
                        maxRotation: 45,
                        minRotation: 45
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            }
        }
    });
});
</script>