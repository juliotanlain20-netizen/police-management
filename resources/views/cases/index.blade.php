<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Investigation Cases</title>
</head>

<body>

    <h1>Investigation Cases</h1>
    @if (session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif
    @forelse ($cases as $case)
        <div>
            <p>
                <strong>Case Number:</strong>
                {{ $case->case_number }}
            </p>

            <p>
                <strong>Title:</strong>
                {{ $case->title }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ $case->status }}
            </p>

            <p>
                <strong>Priority:</strong>
                {{ $case->priority }}
            </p>

            <a href="{{ route('cases.show', $case->id) }}">
                Detail
            </a>

            <hr>
        </div>
    @empty
        <p>Belum ada investigation case.</p>
    @endforelse

</body>

</html>