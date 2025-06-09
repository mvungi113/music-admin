<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reports PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background: #f3f3f3; }
    </style>
</head>
<body>
    <h2>Reports</h2>
    <table>
        <thead>
            <tr>
                <th>ARTIST NAME</th>
                <th>SONG TITLE</th>
                <th>STATUS</th>
                <th>QUALITY</th>
                <th>SUBMITTED</th>
            </tr>
        </thead>
        <tbody>
            @forelse($submissions as $submission)
                <tr>
                    <td>{{ isset($submission['users'][0]['artist_name']) ? $submission['users'][0]['artist_name'] : '-' }}</td>
                    <td>{{ $submission['title'] ?? '-' }}</td>
                    <td>{{ ucfirst($submission['status'] ?? '-') }}</td>
                    <td>{{ $submission['quality'] ?? '-' }}</td>
                    <td>{{ isset($submission['created_at']) ? \Carbon\Carbon::parse($submission['created_at'])->format('Y-m-d') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">No submissions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>