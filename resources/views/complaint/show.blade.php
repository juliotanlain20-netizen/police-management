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
        </p>
    @empty
        <p>Tidak ada attachment.</p>
    @endforelse

    <a href="{{ route('complaint') }}">Kembali</a>
</body>
</html>