<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Evidence</title>
</head>

<body>

    <h1>Edit Evidence</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form
        action="{{ route('evidence.update', $evidence->id) }}"
        method="POST"
    >
        @csrf
        @method('PATCH')

        <label for="evidence_code">Evidence Code</label>
        <input
            type="text"
            name="evidence_code"
            id="evidence_code"
            value="{{ old('evidence_code', $evidence->evidence_code) }}"
        >

        <br>

        <label for="evidence_category_id">Category</label>

        <select
            name="evidence_category_id"
            id="evidence_category_id"
        >
            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(
                        old('evidence_category_id', $evidence->evidence_category_id)
                        == $category->id
                    )
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <br>

        <label for="name">Name</label>
        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $evidence->name) }}"
        >

        <br>

        <label for="description">Description</label>
        <textarea
            name="description"
            id="description"
        >{{ old('description', $evidence->description) }}</textarea>

        <br>

        <label for="storage_location">Storage Location</label>
        <input
            type="text"
            name="storage_location"
            id="storage_location"
            value="{{ old('storage_location', $evidence->storage_location) }}"
        >

        <br>

        <label for="status">Status</label>

        <select name="status" id="status">
            @foreach (['Stored', 'Borrowed', 'Returned', 'Destroyed'] as $status)
                <option
                    value="{{ $status }}"
                    @selected(old('status', $evidence->status) === $status)
                >
                    {{ $status }}
                </option>
            @endforeach
        </select>

        <br>

        <button type="submit">
            Update Evidence
        </button>

    </form>

</body>

</html>