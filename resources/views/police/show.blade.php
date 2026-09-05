<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Police Officer</title>
</head>

<body>

    <h1>Detail Police Officer</h1>
        @if (session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif

    <p>
        <strong>ID:</strong>
        {{ $police->id }}
    </p>

    <p>
        <strong>Nama:</strong>
        {{ $police->user?->name }}
    </p>

    <p>
        <strong>Email:</strong>
        {{ $police->user?->email }}
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
        <strong>Phone:</strong>
        {{ $police->phone }}
    </p>

    <p>
        <strong>Alamat:</strong>
        {{ $police->address }}
    </p>

    <p>
        <strong>Status:</strong>
        {{ $police->status }}
    </p>

    <a href="{{ route('police.index') }}">
        Kembali
    </a>

</body>

</html>