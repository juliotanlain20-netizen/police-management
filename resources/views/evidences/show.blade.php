<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail Evidence</title>
</head>

<body>

    <h1>Detail Evidence</h1>

    <p>
        <strong>Evidence Code:</strong>
        {{ $evidence->evidence_code }}
    </p>

    <p>
        <strong>Name:</strong>
        {{ $evidence->name }}
    </p>

    <p>
        <strong>Category:</strong>
        {{ $evidence->category->name }}
    </p>

    <p>
        <strong>Case:</strong>
        {{ $evidence->investigationCase->case_number }}
    </p>

    <p>
        <strong>Description:</strong>
        {{ $evidence->description ?? '-' }}
    </p>

    <p>
        <strong>Storage Location:</strong>
        {{ $evidence->storage_location }}
    </p>

    <p>
        <strong>Status:</strong>
        {{ $evidence->status }}
    </p>

    <hr>

    <h2>Evidence Attachments</h2>

    @forelse ($evidence->attachments as $attachment)

        <div>
            <p>
                <strong>File:</strong>
                {{ $attachment->file_name }}
            </p>

            <p>
                <strong>Type:</strong>
                {{ $attachment->mime_type }}
            </p>

            <p>
                <strong>Size:</strong>
                {{ $attachment->file_size }} bytes
            </p>

            <p>
                <strong>Uploaded:</strong>
                {{ $attachment->uploaded_at }}
            </p>
        </div>

        <hr>

    @empty

        <p>Belum ada attachment untuk evidence ini.</p>

    @endforelse
    @if ($evidence->record_status === 'Valid')

    <form action="{{ route('evidence.void', $evidence->id) }}"
          method="POST">

        @csrf
        @method('PATCH')

        <label for="reason">Alasan Void</label>

        <textarea
            name="reason"
            id="reason"
            required
        ></textarea>

        <button type="submit">
            Void Evidence
        </button>

    </form>

@else

    <p>
        Evidence ini sudah Voided.
    </p>

@endif

    <a href="{{ route('evidence.index') }}">
        Kembali
    </a>

</body>

</html>