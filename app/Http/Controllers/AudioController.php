<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class AudioController extends Controller
{
    public function index()
    {
        $url = env('SUPABASE_URL') . '/rest/v1';
        $key = env('SUPABASE_KEY');
        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ];

        // Fetch all songs
        $songs = Http::withHeaders($headers)
            ->get("$url/songs_v2?select=*")
            ->json();

        // Fetch all users for artist names
        $users = Http::withHeaders($headers)
            ->get("$url/users?select=user_id,artist_name")
            ->json();

        $usersById = collect($users)->keyBy('user_id');

        // Attach artist_name to each song
        $submissions = collect($songs)->map(function ($song) use ($usersById) {
            $song['artist_name'] = $usersById[$song['user_id']]['artist_name'] ?? '-';
            return $song;
        });

        return view('audio_submissions', [
            'submissions' => $submissions,
        ]);
    }

    public function view($id)
    {
        $url = env('SUPABASE_URL') . '/rest/v1';
        $storage_url = env('SUPABASE_URL') . '/storage/v1/object/public/music-bucket';
        $key = env('SUPABASE_KEY');
        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ];

        // Fetch the song by id
        $songs = Http::withHeaders($headers)
            ->get("$url/songs_v2?id=eq.$id&select=*")
            ->json();

        $song = $songs[0] ?? null;

        if (!$song) {
            abort(404, 'Song not found');
        }

        // Fetch artist name
        $artist = '-';
        if (isset($song['user_id'])) {
            $users = Http::withHeaders($headers)
                ->get("$url/users?user_id=eq.{$song['user_id']}&select=artist_name")
                ->json();
            $artist = $users[0]['artist_name'] ?? '-';
        }

        // Build URLs with rawurlencode on filenames to avoid URL issues
        $song_url = null;
        if (!empty($song['song_url'])) {
            $song_url = $song['song_url']; // Directly use the song_url from the database
        }

        $lyrics_url = null;
        if (!empty($song['lyrics_url'])) {
            $lyrics_url = $song['lyrics_url']; // Directly use the lyrics_url from the database
        }

        // Fetch lyrics content if available
        $lyrics = 'Lyrics not available.';
        if ($lyrics_url) {
            try {
                $response = Http::get($lyrics_url);
                if ($response->ok()) {
                    $lyrics = $response->body();
                }
            } catch (\Exception $e) {
                // Handle any exceptions that occur during the fetch
                $lyrics = 'Lyrics not available.';
            }
        }

        return view('song_details', [
            'artist_name' => $artist,
            'song_title' => $song['title'] ?? '-',
            'song_url' => $song_url,
            'lyrics' => $lyrics,
            'song_id' => $song['id'],
            'lyrics_url' => $lyrics_url, // for debugging
        ]);
    }

    public function approve($id)
    {
        $url = env('SUPABASE_URL') . '/rest/v1/songs_v2?id=eq.' . $id;
        $key = env('SUPABASE_KEY');
        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=minimal',
        ];

        Http::withHeaders($headers)->patch($url, ['status' => 'approved']);
        return redirect()->back()->with('success', 'Song approved!');
    }

    public function reject($id)
    {
        $url = env('SUPABASE_URL') . '/rest/v1/songs_v2?id=eq.' . $id;
        $key = env('SUPABASE_KEY');
        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=minimal',
        ];

        Http::withHeaders($headers)->patch($url, ['status' => 'rejected']);
        return redirect()->back()->with('success', 'Song rejected!');
    }

    public function pending($id)
    {
        $url = env('SUPABASE_URL') . '/rest/v1/songs_v2?id=eq.' . $id;
        $key = env('SUPABASE_KEY');
        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=minimal',
        ];

        Http::withHeaders($headers)->patch($url, ['status' => 'pending']);
        return redirect()->back()->with('success', 'Song set to pending!');
    }
}