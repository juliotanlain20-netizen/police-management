<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Suspect</title>
</head>

<body>

    <h1>Edit Suspect</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form
        action="{{ route('suspect.update', $suspect->id) }}"
        method="POST"
    >
        @csrf
        @method('PATCH')

        <div>
            <label for="name">Name</label>

            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name', $suspect->name) }}"
            >
        </div>

        <br>

        <div>
            <label for="identity_number">
                Identity Number
            </label>

            <input
                type="text"
                name="identity_number"
                id="identity_number"
                value="{{ old('identity_number', $suspect->identity_number) }}"
            >
        </div>

        <br>

        <div>
            <label for="address">Address</label>

            <input
                type="text"
                name="address"
                id="address"
                value="{{ old('address', $suspect->address) }}"
            >
        </div>

        <br>

        <div>
            <label for="status">Status</label>

            <select
                name="status"
                id="status"
            >
                @foreach (['identified', 'wanted', 'detained', 'released'] as $status)
                    <option
                        value="{{ $status }}"
                        @selected(old('status', $suspect->status) === $status)
                    >
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <br>

        <div>
            <label for="notes">Notes</label>

            <textarea
                name="notes"
                id="notes"
            >{{ old('notes', $suspect->notes) }}</textarea>
        </div>

        <br>

        <button type="submit">
            Update Suspect
        </button>

        <a href="{{ route('suspect.show', $suspect->id) }}">
            Cancel
        </a>
    </form>

</body>

</html>