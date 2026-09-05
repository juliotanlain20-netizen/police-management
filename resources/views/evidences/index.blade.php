<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <h1>evidence</h1>
        @if (session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif
    <h1>Daftar Evidence</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if ($evidences->isEmpty())
    <p>Belum ada evidence.</p>
@else

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Evidence Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>Storage Location</th>
                <th>Status</th>
                <th>Record Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($evidences as $evidence)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $evidence->evidence_code }}
                    </td>

                    <td>
                        {{ $evidence->name }}
                    </td>

                    <td>
                        {{ $evidence->category->name ?? '-' }}
                    </td>

                    <td>
                        {{ $evidence->storage_location }}
                    </td>

                    <td>
                        {{ $evidence->status }}
                    </td>

                    <td>
                        {{ $evidence->record_status }}
                    </td>

                    <td>
                        <a href="{{ route('evidence.show', $evidence->id) }}">
                            Detail
                        </a>

                        @if ($evidence->record_status === 'Valid')
                            |
                            <a href="{{ route('evidence.edit', $evidence->id) }}">
                                Edit
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endif
</body>
</html>