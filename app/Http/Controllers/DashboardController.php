<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $url = env('SUPABASE_URL') . '/rest/v1';
        $key = env('SUPABASE_KEY');
        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ];

        // Fetch all songs from songs_v2
        $songs = Http::withHeaders($headers)
            ->get("$url/songs_v2?select=*")
            ->json();

        // If Supabase returns an error, $songs may be an array with 'message'
        if (!is_array($songs) || isset($songs['message'])) {
            $songs = [];
        }

        $songsCollection = collect($songs);

        $total = $songsCollection->count();
        $approved = $songsCollection->where('status', 'approved')->count();
        $flagged = $songsCollection->where('status', 'rejected')->count();
        $pending = $songsCollection->where('status', 'pending')->count();
        $active_artist_ids = $songsCollection->pluck('user_id')->unique();
        $active_artists = $active_artist_ids->count();

        // Prepare chart data: group by date (Y-m-d)
        $labels = [];
        $chart_total_submissions = [];
        $chart_approved_content = [];
        $chart_flagged_content = [];

        $grouped = $songsCollection->groupBy(function ($item) {
            return isset($item['created_at']) ? substr($item['created_at'], 0, 10) : 'Unknown';
        });

        foreach ($grouped as $date => $items) {
            $labels[] = $date;
            $chart_total_submissions[] = count($items);
            $chart_approved_content[] = collect($items)->where('status', 'approved')->count();
            $chart_flagged_content[] = collect($items)->where('status', 'rejected')->count();
        }

        // Fetch all users
        $users = Http::withHeaders($headers)
            ->get("$url/users?select=*")
            ->json();

        if (!is_array($users) || isset($users['message'])) {
            $users = [];
        }
        $usersCollection = collect($users);

        // Optionally, get artist names for display
        $active_artist_names = $usersCollection->whereIn('user_id', $active_artist_ids)->pluck('artist_name')->all();

        return view('dashboard', [
            'total_submissions' => $total,
            'approved_content' => $approved,
            'flagged_content' => $flagged,
            'pending_content' => $pending,
            'active_artists' => $active_artists,
            'active_artist_names' => $active_artist_names,
            'chart_labels' => $labels,
            'chart_total_submissions' => $chart_total_submissions,
            'chart_approved_content' => $chart_approved_content,
            'chart_flagged_content' => $chart_flagged_content,
        ]);
    }
}
