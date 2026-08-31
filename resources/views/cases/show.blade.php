<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail Case</title>
</head>

<body>

    <h1>Detail Investigation Case</h1>

    <p><strong>ID:</strong> {{ $case->id }}</p>
    <p><strong>Case Number:</strong> {{ $case->case_number }}</p>
    <p><strong>Title:</strong> {{ $case->title }}</p>
    <p><strong>Description:</strong> {{ $case->description }}</p>
    <p><strong>Status:</strong> {{ $case->status }}</p>
    <p><strong>Priority:</strong> {{ $case->priority }}</p>
    <p><strong>Opened At:</strong> {{ $case->opened_at }}</p>
    <p><strong>Closed At:</strong> {{ $case->closed_at ?? '-' }}</p>

    <a href="{{ route('cases.edit', $case->id) }}">
        Edit Case
    </a>

    <hr>

    <h2>Complaint</h2>

    <p>
        {{ $case->complaint?->title }}
    </p>

    <h3>Complaint Attachments</h3>

    @forelse ($case->complaint?->attachments ?? [] as $attachment)
        <p>
            {{ $attachment->file_name }}
        </p>
    @empty
        <p>Tidak ada attachment.</p>
    @endforelse

    <hr>

    <h2>Suspects</h2>

    @forelse ($case->suspects as $suspect)
        <p>{{ $suspect->name }}</p>
    @empty
        <p>Belum ada suspect.</p>
    @endforelse

    <hr>

    <h2>Evidences</h2>

    @forelse ($case->evidences as $evidence)
        <p>{{ $evidence->name }}</p>
    @empty
        <p>Belum ada evidence.</p>
    @endforelse

    <br>

    <a href="{{ route('cases.index') }}">
        Kembali
    </a>

</body>

</html>