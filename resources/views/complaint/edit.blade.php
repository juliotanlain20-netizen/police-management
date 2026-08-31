<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1> edit complaint</h1>
    {{$complaint}}
    
    <form action="{{route('complaint.update', $complaint)}}" method="post">
        @csrf
        @method('PUT')
        <div>
        <label for="title">title</label>
        <input type="text" name="title" id="title" value="{{$complaint->title}}">
        </div>
        
        <div>
        <label for="category_id">category</label>
        
        <select name="category_id" id="category_id">
            @foreach ($categories as $category)
            <option value="{{$category->id}}"
                {{$category->id==$complaint->category_id? 'selected':''}}>
                {{$category->name}}
            </option>
            @endforeach
        </select>
        </div>
        
        <div>
        <label for="description">description</label>
        <input type="text" name="description" id="description" value="{{$complaint->description}}">
        </div>
        
        <div>
        <label for="incident_date">incident_date</label>
        <input type="date" name="incident_date" id="incident_date" value="{{$complaint->incident_date}}">
        </div>
        
        <div>
        <label for="location">location</label>
        <input type="text" name="location" id="location" value="{{$complaint->location}}">
        </div>

        <button type="submit" value="save" name="action">save change</button>
        @if (in_array($complaint->status, ['Draft', 'Need More Evidence']))
    <button type="submit" name="action" value="submit">

        @if ($complaint->status === 'Draft')
            Submit Complaint
        @else
            Resubmit Complaint
        @endif
    </button>
@endif
    </form>
    <h2>Tambah Attachment</h2>

<form
    action="{{ route('complaint.attachments.store', $complaint->id) }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf

    <input type="file" name="attachment">

    <button type="submit">
        Tambah Attachment
    </button>
</form>
<h2>Attachments</h2>

@forelse ($complaint->attachments as $attachment)
    <p>
        {{ $attachment->file_name }}

        <form
            action="{{ route('complaint.attachments.destroy', [
                $complaint->id,
                $attachment->id
            ]) }}"
            method="POST"
            style="display: inline;"
        >
            @csrf
            @method('DELETE')

            <button type="submit">
                Hapus
            </button>
        </form>
    </p>
@empty
    <p>Tidak ada attachment.</p>
@endforelse
    
</body>
</html>