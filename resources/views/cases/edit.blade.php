<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Investigation Case</title>
</head>

<body>

    <h1>Edit Investigation Case</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form
        action="{{ route('cases.update', $case->id) }}"
        method="POST"
    >
        @csrf
        @method('PATCH')

        <div>
            <label for="case_number">
                Case Number
            </label>

            <input
                type="text"
                name="case_number"
                id="case_number"
                value="{{ $case->case_number }}"
            >
        </div>

        <div>
            <label for="title">
                Title
            </label>

            <input
                type="text"
                name="title"
                id="title"
                value="{{ $case->title }}"
            >
        </div>

        <div>
            <label for="description">
                Description
            </label>

            <textarea
                name="description"
                id="description"
            >{{ $case->description }}</textarea>
        </div>

        <div>
            <label for="priority">
                Priority
            </label>

            <select name="priority" id="priority">
                <option value="Low" {{ $case->priority === 'Low' ? 'selected' : '' }}>
                    Low
                </option>

                <option value="Medium" {{ $case->priority === 'Medium' ? 'selected' : '' }}>
                    Medium
                </option>

                <option value="High" {{ $case->priority === 'High' ? 'selected' : '' }}>
                    High
                </option>
            </select>
        </div>

        <div>
            <label for="status">
                Status
            </label>

            <select name="status" id="status">
                <option value="Open" {{ $case->status === 'Open' ? 'selected' : '' }}>
                    Open
                </option>

                <option value="In Progress" {{ $case->status === 'In Progress' ? 'selected' : '' }}>
                    In Progress
                </option>

                <option value="Closed" {{ $case->status === 'Closed' ? 'selected' : '' }}>
                    Closed
                </option>
            </select>
        </div>

        <button type="submit">
            Save Change
        </button>
    </form>

    <br>

    <a href="{{ route('cases.show', $case->id) }}">
        Kembali
    </a>

</body>

</html>