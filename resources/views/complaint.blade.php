<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>COMPLAINT</h1>
     @if ($errors->any())
<ul>@foreach ($errors->all() as $error)
   <li>{{$error}} </li>
@endforeach</ul>
@endif
    <form action="{{route('complaint.store')}}" method="POST">
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
    
    <label for="incident_date">Email</label>
    <input name="incident_date" id="incident_date" type="date">

    <label for="location">location</label>
    <input name="location" id="location" type="text">
    

    <button type="submit">register</button>
    </form>
    
</body>
</html>