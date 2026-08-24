    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>buat COMPLAINT baru</h1>
     @if ($errors->any())
<ul>@foreach ($errors->all() as $error)
   <li>{{$error}} </li>
@endforeach</ul>
@endif
    <form action="{{route('complaint.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="title">title</label>
        <input name="title" id="title" type="text">

        <label for="category_id">category</label>
        
        <select name="category_id" id="category_id">
            @foreach ($categories as $category)
            <option value="{{$category->id}}">
                {{$category->name}}
            </option>
                
            @endforeach
        </select>

    <label for="description">description</label>
    <input name="description" id="description" type="text">
    
    <label for="incident_date">Incidedent_date</label>
    <input name="incident_date" id="incident_date" type="date">

    <label for="location">location</label>
    <input name="location" id="location" type="text">

    <label for="attachments[]">attachments</label>
    <input type="file" name="attachments[]" id="attachments" multiple>
    <small>Maksimal 10 MB per file.</small>

    <button type="submit" name="action"  value="save">simpan</button>
    <button type="submit" name="action"  value="submit">upload</button>
    </form>
</body>
</html>