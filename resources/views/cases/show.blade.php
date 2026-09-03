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