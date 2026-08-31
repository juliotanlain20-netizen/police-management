    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>buat police baru dari admin</h1>
     @if ($errors->any())
<ul>@foreach ($errors->all() as $error)
   <li>{{$error}} </li>
@endforeach</ul>
@endif
    <form action="{{route('police.store')}}" method="POST">
        @csrf
            <div>
            <label for="user_id">User</label>

            <select name="user_id" id="user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }} - {{ $user->email }}- Role: {{ $user->roles->pluck('name')->implode(', ') }}
                    </option>
                @endforeach
            </select>
        </div>
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
        <div>
        <label for="nrp">nrp</label>
        <input name="nrp" id="nrp" type="text">
    </div>


    
<div>
    <label for="address">address</label>
    <input name="address" id="address" type="text">
    </div>
    <button type="submit" name="action"  value="submit">upload</button>
    </form>
</body>
</html>