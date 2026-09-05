<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Suspect Detail</title>
</head>

<body>

    <h1>Suspect Detail</h1>
        @if (session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif

    <p>
        <strong>Name:</strong>
        {{ $suspect->name }}
    </p>

    <p>
        <strong>Identity Number:</strong>
        {{ $suspect->identity_number ?? '-' }}
    </p>

    <p>
        <strong>Address:</strong>
        {{ $suspect->address }}
    </p>

    <p>
        <strong>Status:</strong>
        {{ ucfirst($suspect->status) }}
    </p>

    <p>
        <strong>Notes:</strong>
        {{ $suspect->notes ?? '-' }}
    </p>

    <hr>

    <h2>Investigation Case</h2>

    <p>
        <strong>Case Number:</strong>
        {{ $suspect->case->case_number }}
    </p>

    <p>
        <strong>Case Title:</strong>
        {{ $suspect->case->title }}
    </p>

    <p>
        <strong>Case Status:</strong>
        {{ $suspect->case->status }}
    </p>

    <hr>

    <a href="{{ route('suspect.edit', $suspect->id) }}">
        Edit Suspect
    </a>

    |

    <a href="{{ route('cases.show', $suspect->case->id) }}">
        Back to Case
    </a>

</body>

</html>