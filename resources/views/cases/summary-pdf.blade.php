<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Case Summary</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        h2 {
            margin-top: 25px;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #777;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background: #eeeeee;
            text-align: left;
        }

        .info-table td:first-child {
            width: 30%;
            font-weight: bold;
        }

        .muted {
            color: #666;
        }
    </style>
</head>

<body>

    <h1>CASE SUMMARY</h1>

    <p style="text-align: center;">
        {{ $case->case_number }}
    </p>


    {{-- INFORMASI CASE --}}

    <h2>1. Informasi Kasus</h2>

    <table class="info-table">
        <tr>
            <td>Nomor Kasus</td>
            <td>{{ $case->case_number }}</td>
        </tr>

        <tr>
            <td>Judul</td>
            <td>{{ $case->title }}</td>
        </tr>

        <tr>
            <td>Deskripsi</td>
            <td>{{ $case->description }}</td>
        </tr>

        <tr>
            <td>Status</td>
            <td>{{ $case->status }}</td>
        </tr>

        <tr>
            <td>Prioritas</td>
            <td>{{ $case->priority }}</td>
        </tr>

        <tr>
            <td>Dibuka</td>
            <td>
                {{ $case->opened_at
                    ? \Carbon\Carbon::parse($case->opened_at)->format('d-m-Y H:i')
                    : '-' }}
            </td>
        </tr>

        <tr>
            <td>Ditutup</td>
            <td>
                {{ $case->closed_at
                    ? \Carbon\Carbon::parse($case->closed_at)->format('d-m-Y H:i')
                    : '-' }}
            </td>
        </tr>
    </table>


    {{-- COMPLAINT --}}

    <h2>2. Pengaduan Asal</h2>

    @if ($case->complaint)

        <table class="info-table">
            <tr>
                <td>Judul</td>
                <td>{{ $case->complaint->title }}</td>
            </tr>

            <tr>
                <td>Kategori</td>
                <td>{{ $case->complaint->category?->name ?? '-' }}</td>
            </tr>

            <tr>
                <td>Deskripsi</td>
                <td>{{ $case->complaint->description }}</td>
            </tr>

            <tr>
                <td>Tanggal Kejadian</td>
                <td>{{ $case->complaint->incident_date }}</td>
            </tr>

            <tr>
                <td>Lokasi</td>
                <td>{{ $case->complaint->location }}</td>
            </tr>

            <tr>
                <td>Status Complaint</td>
                <td>{{ $case->complaint->status }}</td>
            </tr>
        </table>

        <p>
            <strong>Attachment Complaint:</strong>
            {{ $case->complaint->attachments->count() }}
        </p>

    @else
        <p>Tidak ada data complaint.</p>
    @endif


    {{-- OFFICERS --}}

    <h2>3. Penyidik / Officer</h2>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Status Assignment</th>
                <th>Ditugaskan Pada</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($case->officers as $officer)

                <tr>
                    <td>
                        {{ $officer->user?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $officer->pivot->status }}
                    </td>

                    <td>
                        {{ $officer->pivot->assigned_at ?? '-' }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="3">
                        Belum ada officer yang ditugaskan.
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>


    {{-- SUSPECT --}}

    <h2>4. Suspect</h2>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Nomor Identitas</th>
                <th>Alamat</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($case->suspects as $suspect)

                <tr>
                    <td>{{ $suspect->name }}</td>

                    <td>
                        {{ $suspect->identity_number ?? '-' }}
                    </td>

                    <td>{{ $suspect->address }}</td>

                    <td>{{ $suspect->status }}</td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">
                        Belum ada suspect.
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>


    {{-- EVIDENCE --}}

    <h2>5. Barang Bukti</h2>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Record</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($case->evidences as $evidence)

                <tr>
                    <td>{{ $evidence->evidence_code }}</td>

                    <td>{{ $evidence->name }}</td>

                    <td>
                        {{ $evidence->category?->name ?? '-' }}
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
                </tr>

            @empty

                <tr>
                    <td colspan="6">
                        Belum ada barang bukti.
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>


    {{-- HISTORY --}}

    <h2>6. Riwayat Kasus</h2>

    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Aktivitas</th>
                <th>User</th>
                <th>Catatan</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($case->histories as $history)

                <tr>
                    <td>
                        {{ $history->created_at
                            ? $history->created_at->format('d-m-Y H:i')
                            : '-' }}
                    </td>

                    <td>
                        {{ $history->activity }}
                    </td>

                    <td>
                        {{ $history->user?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $history->notes ?? '-' }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">
                        Belum ada riwayat kasus.
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>


    <p class="muted" style="margin-top: 30px;">
        Dokumen ini merupakan ringkasan data kasus yang dihasilkan oleh sistem.
    </p>

</body>

</html>