<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reports PDF</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px; 
            background: #f8fafc;
            margin: 0;
            padding: 0;
        }
        .report-container {
            max-width: 900px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 32px 24px;
        }
        h2 {
            text-align: center;
            margin-bottom: 18px;
            color: #1a202c;
            letter-spacing: 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background: #f1f5f9;
            color: #1e293b;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.5px;
        }
        tr:nth-child(even) td {
            background: #f9fafb;
        }
        td {
            color: #334155;
            font-size: 12px;
        }
        .no-data {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 32px 0;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <h2>Music Submission Reports</h2>
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
                        <td class="px-4 py-2">{{ $submission['artist_name'] ?? '-'}}</td>
                        <td>{{ $submission['title'] ?? '-' }}</td>
                        <td>{{ ucfirst($submission['status'] ?? '-') }}</td>
                        <td>{{ $submission['quality'] ?? '-' }}</td>
                        <td>
                            {{ isset($submission['created_at']) ? \Carbon\Carbon::parse($submission['created_at'])->format('Y-m-d') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-data">No submissions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>