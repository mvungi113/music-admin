<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        $url = env('SUPABASE_URL') . '/rest/v1';
        $key = env('SUPABASE_KEY');
        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ];

        // Fetch all users
        $users = Http::withHeaders($headers)
            ->get("$url/users?select=*")
            ->json();

        // Fetch all songs
        $songs = Http::withHeaders($headers)
            ->get("$url/songs_v2?select=user_id")
            ->json();

        $songsCollection = collect($songs);

        // Prepare artists array with total songs
        $artists = collect($users)->map(function ($user) use ($songsCollection) {
            return [
                'artist_name' => $user['artist_name'] ?? '-',
                'email' => $user['email'] ?? '-',
                'user_id' => $user['user_id'] ?? '-',
                'total_songs' => $songsCollection->where('user_id', $user['user_id'])->count(),
            ];
        });

        return view('usermanagement', [
            'artists' => $artists,
        ]);
    }

    public function view($id)
    {
        $url = env('SUPABASE_URL') . '/rest/v1';
        $key = env('SUPABASE_KEY');
        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ];

        // Fetch artist/user by user_id
        $users = Http::withHeaders($headers)
            ->get("$url/users?user_id=eq.$id&select=*")
            ->json();

        $artist = $users[0] ?? null;

        // Fetch all songs for this artist
        $songs = Http::withHeaders($headers)
            ->get("$url/songs_v2?user_id=eq.$id&select=*")
            ->json();

        $total_songs = is_array($songs) ? count($songs) : 0;
        $quality_score = is_array($songs) && $total_songs > 0
            ? round(collect($songs)->avg('quality') / 10, 1)
            : 'N/A';

        // Example: Recent lyrics analysis (customize as needed)
        $recent_song = is_array($songs) && $total_songs > 0
            ? collect($songs)->sortByDesc('created_at')->first()
            : null;

        return view('artist_profile', [
            'artist' => [
                'first_name' => $artist['first_name'] ?? '',
                'last_name' => $artist['last_name'] ?? '',
                'artist_name' => $artist['artist_name'] ?? '',
                'email' => $artist['email'] ?? '',
                'phone' => $artist['phone'] ?? '',
                'total_songs' => $total_songs,
                'quality_score' => $quality_score,
                'recent_lyrics_title' => $recent_song['title'] ?? '',
                'recent_lyrics_date' => isset($recent_song['created_at']) ? date('M d Y', strtotime($recent_song['created_at'])) : '',
                'recent_lyrics_score' => isset($recent_song['quality']) ? round($recent_song['quality'] / 10, 1) : '',
            ]
        ]);
    }
}
