<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>INDEX DI ADMIN</h1>
    @if (session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif
    @foreach ($users as $user)
    <p>
    {{$user}}
    </p><br>
        
    @endforeach
</body>
</html>