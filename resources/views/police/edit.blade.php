<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>edit police</h1>
    @if ($errors->any())
<ul>@foreach ($errors->all() as $error)
   <li>{{$error}} </li>
@endforeach</ul>
@endif
    <form action="{{route('police.update',['id' => $police->id])}}" method="POST">
        @csrf
        @method('PUT')
        <p>Nama: {{ $police->user->name }}</p>
<p>Email: {{ $police->user->email }}</p>
            <div>
            <label for="unit_id">unit</label>

            <select name="unit_id" id="unit_id">
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">
                        {{ $unit->name }}                     </option>
                @endforeach
            </select>
        </div>

<div>
    <label for="rank_id">ranks</label>
<select name="rank_id" id="rank_id">
    
            @foreach ($ranks as $rank)
            <option value="{{$rank->id}}">
                {{$rank->name}}
            </option>
                
            @endforeach
        </select>
        </div>
        <div>
        <label for="nrp">nrp</label>
        <input name="nrp" id="nrp" type="text">
    </div>


    
<div>
    <label for="address">address</label>
    <input name="address" id="address" type="text">
    </div>
    <div>
        <div>
    <label for="status">Status:</label>

    <select name="status" id="status">
        <option value="Active"
            {{ $police->status === 'Active' ? 'selected' : '' }}>
            Active
        </option>

        <option value="Inactive"
            {{ $police->status === 'Inactive' ? 'selected' : '' }}>
            Inactive
        </option>
    </select>
</div>
        
    <button type="submit" name="action"  value="submit">upload</button>
    </form>
</body>
</html>