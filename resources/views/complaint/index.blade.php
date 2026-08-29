<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1> complaint dari index</h1>
    <form action="{{ route('logout') }}" method="POST">
    @csrf

    <button type="submit" class="btn btn-danger">
        Logout
    </button>
</form>
    @if ($complaints->isEmpty())
        <p>Belum ada complaint.</p>
    @else
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal Kejadian</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($complaints as $complaint)
                    <tr>
                        <td>{{ $complaint->id }}</td>
                        <td>{{ $complaint->title }}</td>
                        <td>{{ $complaint->category?->name }}</td>
                        <td>{{ $complaint->status }}</td>
                        <td>{{ $complaint->incident_date }}</td>
                        <td>
                            <a href="{{ route('complaint.show', $complaint->id) }}">
                                Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    
</body>
</html>