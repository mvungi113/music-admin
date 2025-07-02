<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Set Supabase credentials
        $url = env('SUPABASE_URL') . '/rest/v1';
        $key = env('SUPABASE_KEY');
        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ];

        try {
            // Fetch songs with error handling
            $response = Http::withHeaders($headers)
                ->get("$url/songs_v2?select=*");
                
            if ($response->successful()) {
                $songs = $response->json();
                $songsCollection = collect(is_array($songs) ? $songs : []);
            } else {
                $songsCollection = collect([]);
            }

            // KPIs
            $total = $songsCollection->count();
            $approved = $songsCollection->where('status', 'approved')->count();
            $flagged = $songsCollection->where('status', 'rejected')->count();
            $pending = $songsCollection->where('status', 'pending')->count();
            $active_artist_ids = $songsCollection->pluck('user_id')->unique()->filter();
            $active_artists = $active_artist_ids->count();

            // ----------- ALL-TIME CHART DATA -----------
            // Get all unique dates in the data, sorted
            $allDates = $songsCollection
                ->pluck('created_at')
                ->filter()
                ->map(function($dt) {
                    return substr($dt, 0, 10); // Extract YYYY-MM-DD
                })
                ->unique()
                ->sort()
                ->values()
                ->all();

            // Ensure we have at least some dates for the chart
            if (empty($allDates)) {
                // If no dates, create a default range with today
                $allDates = [Carbon::today()->format('Y-m-d')];
            }

            // Initialize arrays for chart data
            $labels = [];
            $chart_total_submissions = [];
            $chart_approved_content = [];
            $chart_flagged_content = [];
            $chart_pending_content = [];

            // Process each date for chart data
            foreach ($allDates as $dateStr) {
                // Format date for display
                $labels[] = Carbon::parse($dateStr)->format('M d, Y');
                
                // Filter songs for this date
                $daySongs = $songsCollection->filter(function ($song) use ($dateStr) {
                    return isset($song['created_at']) && substr($song['created_at'], 0, 10) === $dateStr;
                });
                
                // Count songs by status for this date
                $chart_total_submissions[] = $daySongs->count();
                $chart_approved_content[] = $daySongs->where('status', 'approved')->count();
                $chart_flagged_content[] = $daySongs->where('status', 'rejected')->count();
                $chart_pending_content[] = $daySongs->where('status', 'pending')->count();
            }

            // Fetch users to get artist names
            $usersResponse = Http::withHeaders($headers)
                ->get("$url/users?select=user_id,artist_name");
                
            if ($usersResponse->successful()) {
                $users = $usersResponse->json();
                $usersCollection = collect(is_array($users) ? $users : []);
            } else {
                $usersCollection = collect([]);
            }

            // Map user_ids to artist names
            $active_artist_names = [];
            foreach ($active_artist_ids as $userId) {
                $user = $usersCollection->firstWhere('user_id', $userId);
                if ($user && isset($user['artist_name'])) {
                    $active_artist_names[] = $user['artist_name'];
                }
            }

            // Ensure chart data is properly formatted for JavaScript
            $chartData = [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Total Submissions',
                        'data' => $chart_total_submissions,
                        'borderColor' => '#4c51bf',
                        'backgroundColor' => 'rgba(76, 81, 191, 0.1)',
                        'fill' => true
                    ],
                    [
                        'label' => 'Approved',
                        'data' => $chart_approved_content,
                        'borderColor' => '#38a169',
                        'backgroundColor' => 'rgba(56, 161, 105, 0.1)',
                        'fill' => true
                    ],
                    [
                        'label' => 'Flagged',
                        'data' => $chart_flagged_content,
                        'borderColor' => '#e53e3e',
                        'backgroundColor' => 'rgba(229, 62, 62, 0.1)',
                        'fill' => true
                    ],
                    [
                        'label' => 'Pending',
                        'data' => $chart_pending_content,
                        'borderColor' => '#ed8936',
                        'backgroundColor' => 'rgba(237, 137, 54, 0.1)',
                        'fill' => true
                    ]
                ]
            ];

            // Return data to the view
            return view('dashboard', [
                'total_submissions' => $total,
                'approved_content' => $approved,
                'flagged_content' => $flagged,
                'pending_content' => $pending,
                'active_artists' => $active_artists,
                'active_artist_names' => $active_artist_names,
                'chart_data' => json_encode($chartData),
                'chart_labels' => $labels,
                'chart_total_submissions' => $chart_total_submissions,
                'chart_approved_content' => $chart_approved_content,
                'chart_flagged_content' => $chart_flagged_content,
                'chart_pending_content' => $chart_pending_content,
            ]);
            
        } catch (\Exception $e) {
            // Handle exceptions and return a view with empty data
            return view('dashboard', [
                'total_submissions' => 0,
                'approved_content' => 0,
                'flagged_content' => 0,
                'pending_content' => 0,
                'active_artists' => 0,
                'active_artist_names' => [],
                'chart_data' => json_encode([
                    'labels' => [],
                    'datasets' => []
                ]),
                'chart_labels' => [],
                'chart_total_submissions' => [],
                'chart_approved_content' => [],
                'chart_flagged_content' => [],
                'chart_pending_content' => [],
                'error' => 'Failed to fetch data: ' . $e->getMessage()
            ]);
        }
    }
}