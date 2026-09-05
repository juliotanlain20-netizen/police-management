<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail Case</title>
</head>

<body>
    <h1>Detail Investigation Case</h1>

        @if (session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif
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

    <hr>

<h2>Suspects</h2>

@if ($case->suspects->isEmpty())
    <p>Belum ada suspect pada kasus ini.</p>
@else
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Name</th>
                <th>Identity Number</th>
                <th>Address</th>
                <th>Status</th>
                <th>Notes</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($case->suspects as $suspect)
                <tr>
                    <td>{{ $suspect->name }}</td>

                    <td>
                        {{ $suspect->identity_number ?? '-' }}
                    </td>

                    <td>{{ $suspect->address }}</td>

                    <td>{{ ucfirst($suspect->status) }}</td>

                    <td>
                        {{ $suspect->notes ?? '-' }}
                    </td>

                    <td>
                        <a href="{{ route('suspect.show', $suspect->id) }}">
                            Detail
                        </a>

                        |

                        <a href="{{ route('suspect.edit', $suspect->id) }}">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif


<hr>


<h2>Tambah Suspect</h2>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form
    action="{{ route('suspect.store', $case->id) }}"
    method="POST"
>
    @csrf

    <div>
        <label for="name">Name</label>

        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name') }}"
        >
    </div>

    <br>

    <div>
        <label for="identity_number">Identity Number</label>

        <input
            type="text"
            name="identity_number"
            id="identity_number"
            value="{{ old('identity_number') }}"
        >
    </div>

    <br>

    <div>
        <label for="address">Address</label>

        <input
            type="text"
            name="address"
            id="address"
            value="{{ old('address') }}"
        >
    </div>

    <br>

    <div>
        <label for="status">Status</label>

        <select name="status" id="status">

            <option
                value="identified"
                @selected(old('status') === 'identified')
            >
                Identified
            </option>

            <option
                value="wanted"
                @selected(old('status') === 'wanted')
            >
                Wanted
            </option>

            <option
                value="detained"
                @selected(old('status') === 'detained')
            >
                Detained
            </option>

            <option
                value="released"
                @selected(old('status') === 'released')
            >
                Released
            </option>

        </select>
    </div>

    <br>

    <div>
        <label for="notes">Notes</label>

        <textarea
            name="notes"
            id="notes"
        >{{ old('notes') }}</textarea>
    </div>

    <br>

    <button type="submit">
        Tambah Suspect
    </button>
</form>

    <hr>


<h2>Evidences</h2>

@if ($case->evidences->isEmpty())

    <p>Belum ada evidence.</p>

@else

    <table border="1" cellpadding="8">

        <thead>
            <tr>
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

            @foreach ($case->evidences as $evidence)

                <tr>

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
    
    <br>
    <hr>

<h3>Tambah Evidence</h3>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form
    action="{{ route('evidence.store', $case->id) }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf

    <div>
        <label for="evidence_code">Evidence Code</label>

        <input
            type="text"
            name="evidence_code"
            id="evidence_code"
            value="{{ old('evidence_code') }}"
        >
    </div>

    <br>

    <div>
        <label for="evidence_category_id">Category</label>

        <select
            name="evidence_category_id"
            id="evidence_category_id"
        >
            <option value="">Pilih Category</option>

            @foreach ($evidenceCategories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(old('evidence_category_id') == $category->id)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="name">Evidence Name</label>

        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name') }}"
        >
    </div>

    <br>

    <div>
        <label for="description">Description</label>

        <textarea
            name="description"
            id="description"
        >{{ old('description') }}</textarea>
    </div>

    <br>

    <div>
        <label for="storage_location">
            Storage Location
        </label>

        <input
            type="text"
            name="storage_location"
            id="storage_location"
            value="{{ old('storage_location') }}"
        >
    </div>

    <br>

    <div>
        <label for="attachments">
            Evidence Attachments
        </label>

        <input
            type="file"
            name="attachments[]"
            id="attachments"
            multiple
        >
    </div>

    <br>

    <button type="submit">
        Tambah Evidence
    </button>
</form>
<hr>
{{-- officer --}}
@forelse ($case->officers as $officer)
    <p>
        {{ $officer->user->name }}
    </p>
    <p>
        Status: {{ $officer->pivot->status }}
    </p>
    <p>
        Assigned:
        {{ \Carbon\Carbon::parse($officer->pivot->assigned_at)->format('d M Y, H:i') }}
    </p>
    @if (auth()->user()->hasPermission('case.assign_officer'))

    <form method="POST"
          action="{{ route('case.officers.update', [$case->id, $officer->id]) }}">
        @csrf
        @method('PATCH')
        @if ($officer->pivot->status === 'Active')
            <input type="hidden" name="status" value="Inactive">
            <button type="submit">
                Set Inactive
            </button>
        @else
            <input type="hidden" name="status" value="Active">
            <button type="submit">
                Set Active
            </button>
        @endif
    </form>
@endif
@empty
    <p>Belum ada officer yang ditugaskan.</p>
@endforelse
    <a href="{{ route('cases.index') }}">
        Kembali
    </a>
    
<hr>

<h4>Assign Officer</h4>
   @if (auth()->user()->hasPermission('case.assign_officer'))
<form method="POST"
      action="{{ route('case.officers.store', $case->id) }}">
    @csrf

    <select name="police_officer_id">
        <option value="">Pilih Officer</option>

        @foreach ($police as $officer)
            <option value="{{ $officer->id }}">
                {{ $officer->user->name }}
            </option>
        @endforeach
    </select>

    <button type="submit">
        Assign Officer
    </button>
</form>
@endif
</body>

</html>