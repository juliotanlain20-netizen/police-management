<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Officers</title>
</head>

<body>

    <h1>Daftar Police Officer</h1>
        @if (session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif

    @forelse ($police as $police)
        <div>
            <p>
                <strong>Nama:</strong>
                {{ $police->user?->name }}
            </p>

            <p>
                <strong>NRP:</strong>
                {{ $police->nrp }}
            </p>

            <p>
                <strong>Pangkat:</strong>
                {{ $police->rank?->name }}
            </p>

            <p>
                <strong>Unit:</strong>
                {{ $police->unit?->name }}
            </p>
            <p>
                <strong>phone:</strong>
                {{ $police->user->phone }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ $police->status }}
            </p>

            <a href="{{ route('police.show', $police->id) }}">
                Detail
            </a>

            <hr>
        </div>
    @empty
        <p>Belum ada police officer.</p>
    @endforelse

</body>

</html>