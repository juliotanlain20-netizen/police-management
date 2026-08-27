<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Detail Complaint</h1>

      <p><strong>ID:</strong> {{ $complaint->id }}</p>
    <p><strong>Judul:</strong> {{ $complaint->title }}</p>
    <p><strong>Kategori:</strong> {{ $complaint->category?->name }}</p>
    <p><strong>Deskripsi:</strong> {{ $complaint->description }}</p>
    <p><strong>Tanggal Kejadian:</strong> {{ $complaint->incident_date }}</p>
    <p><strong>Lokasi:</strong> {{ $complaint->location }}</p>
    <p><strong>Status:</strong> {{ $complaint->status }}</p>

   <h2>Attachments</h2>

@forelse ($complaint->attachments as $attachment)
    <p>
        {{ $attachment->file_name }}
        <button
            type="button"
            onclick="openAttachment(
                '{{ route('complaint.attachments.show', [$complaint->id, $attachment->id]) }}',
                '{{ $attachment->mime_type }}'
            )"
        >
            Lihat
        </button>
        <a href="{{ route('complaint.attachments.download', [
        $complaint->id,
        $attachment->id
    ]) }}">
        Download
    </a>
    
    </p>
@empty
    <p>Tidak ada attachment.</p>
@endforelse

<div id="attachmentModal" style="display: none;">
    <button type="button" onclick="closeAttachment()">
        Tutup
    </button>

    <div id="attachmentContent"></div>
</div>
    <a href="{{ route('complaint') }}">Kembali</a>


@if (
    auth()->id() === $complaint->user_id &&
    in_array($complaint->status, ['Draft', 'Need More Evidence'])
)
    <a href="{{ route('complaint.edit', $complaint->id) }}">
        Edit Complaint
    </a>
@endif
</body>
<script>
    function openAttachment(url, mimeType) {
        const modal = document.getElementById('attachmentModal');
        const content = document.getElementById('attachmentContent');

        content.innerHTML = '';

        if (mimeType.startsWith('image/')) {
            content.innerHTML = `
                <img src="${url}" style="max-width: 600px;">
            `;
        }

        if (mimeType.startsWith('video/')) {
            content.innerHTML = `
                <video controls style="max-width: 600px;">
                    <source src="${url}" type="${mimeType}">
                </video>
            `;
        }

        modal.style.display = 'block';
    }

    function closeAttachment() {
        document.getElementById('attachmentModal').style.display = 'none';
    }
</script>
</html>