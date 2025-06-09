<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class OffensiveContentReviewController extends Controller
{
    public function index(Request $request)
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

        // Check if the response is valid
        if (!is_array($songs) || isset($songs['message'])) {
            $songs = [];
        }

        $songsCollection = collect($songs);

        // Summary counts
        $total_submissions = $songsCollection->count();
        $approved_content = $songsCollection->where('status', 'approved')->count();
        $flagged_content = $songsCollection->where('status', 'rejected')->count();
        $pending_content = $songsCollection->where('status', 'pending')->count();

        // Get unique artist IDs from songs
        $active_artist_ids = $songsCollection->pluck('user_id')->unique();
        $active_artists = $active_artist_ids->count();

        // Pending content for review (list)
        $pendingContents = $songsCollection->where('status', 'pending')->values();
        // Reviewed content (approved)
        $reviewedContents = $songsCollection->where('status', 'approved')->values();
        // Flagged content (rejected)
        $flaggedContents = $songsCollection->where('status', 'rejected')->values();

        // Fetch artist names for display if there are active artist IDs
        $active_artist_names = [];
        if ($active_artist_ids->isNotEmpty()) {
            $users = Http::withHeaders($headers)->get("$url/users?select=user_id,artist_name")->json();
            $usersCollection = collect(is_array($users) ? $users : []);
            $active_artist_names = $usersCollection->whereIn('user_id', $active_artist_ids)->pluck('artist_name', 'user_id')->all();
        }

        // Prepare the view with the necessary data
        return view('offensive_content_review', [
            'total_submissions' => $total_submissions,
            'approved_content' => $approved_content,
            'flagged_content' => $flagged_content,
            'pending_content' => $pending_content,
            'active_artists' => $active_artists,
            'pendingCount' => $pending_content,
            'pendingContents' => $pendingContents,
            'reviewedContents' => $reviewedContents,
            'flaggedContents' => $flaggedContents,
            'active_artist_names' => $active_artist_names, // Include artist names if fetched
        ]);
    }
}