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

        <button type="submit" value="save">save change</button>
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
    
</body>
</html>