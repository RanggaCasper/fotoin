<!DOCTYPE html>
<html>
<head>
    <title>Catalog Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Catalog Report</h2>
    <p>Data Periode : {{ $startDate }} to {{ $endDate }}</p>

    <h3>5 Freelancer dengan Pembuatan Katalog Terbanyak</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Freelancer</th>
                <th>Total Katalog</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($freelancerLeaderboard as $index => $freelancer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $freelancer->user->username }}</td>
                    <td>{{ $freelancer->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>5 Katalog dengan Jumlah View Terbanyak</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Katalog</th>
                <th>Total Views</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($catalogViewsLeaderboard as $index => $catalog)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $catalog->title_name }}</td>
                    <td>{{ $catalog->count_views }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Data Katalog</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Total Katalog</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($catalogData as $data)
                <tr>
                    <td>{{ $data->date }}</td>
                    <td>{{ $data->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
