<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $url = env('SUPABASE_URL') . '/rest/v1';
        $key = env('SUPABASE_KEY');

        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ];

        // ✅ Use correct foreign key join to fetch artist_name from users table
        $query = "$url/songs_v2?select=title,status,quality,created_at,user_id,users!user_id(artist_name)&order=created_at.desc";

        $filters = [];

        if ($request->filled('from')) {
            $filters[] = "created_at=gte." . $request->input('from');
        }
        if ($request->filled('to')) {
            $filters[] = "created_at=lte." . $request->input('to');
        }
        if ($request->filled('status')) {
            $filters[] = "status=eq." . $request->input('status');
        }

        if (count($filters)) {
            $query .= '&' . implode('&', $filters);
        }

        $query .= '&limit=50';

        $response = Http::withHeaders($headers)->get($query);

        if ($response->failed()) {
            return view('reports', [
                'submissions' => collect(),
                'error' => 'Failed to fetch data from Supabase: ' . $response->body(),
            ]);
        }

        $submissions = collect($response->json())->map(function ($item) {
            $item['artist_name'] = $item['users']['artist_name'] ?? '-';
            return $item;
        });

        return view('reports', [
            'submissions' => $submissions,
        ]);
    }

    public function export(Request $request)
    {
        $url = env('SUPABASE_URL') . '/rest/v1';
        $key = env('SUPABASE_KEY');

        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ];

        // ✅ Same corrected query for export
        $query = "$url/songs_v2?select=title,status,quality,created_at,user_id,users!user_id(artist_name)&order=created_at.desc";

        $filters = [];

        if ($request->filled('from')) {
            $filters[] = "created_at=gte." . $request->input('from');
        }
        if ($request->filled('to')) {
            $filters[] = "created_at=lte." . $request->input('to');
        }
        if ($request->filled('status')) {
            $filters[] = "status=eq." . $request->input('status');
        }

        if (count($filters)) {
            $query .= '&' . implode('&', $filters);
        }

        $query .= '&limit=1000';

        $response = Http::withHeaders($headers)->get($query);

        if ($response->failed()) {
            return back()->with('error', 'Failed to fetch data from Supabase: ' . $response->body());
        }

        $submissions = collect($response->json())->map(function ($item) {
            $item['artist_name'] = $item['users']['artist_name'] ?? '-';
            return $item;
        });

        $pdf = Pdf::loadView('reports_pdf', [
            'submissions' => $submissions,
        ]);

        return $pdf->download('reports.pdf');
    }
}
