<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
</head>
<body>
    <h1>LOGIN</h1>
    @if (session('success'))
    <p>{{session('success')}} </p>
    @endif
    @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{$error}} </li>
        
        @endforeach
    </ul>
    
    @endif
    <form action="{{route('login.store')}} " method="POST">
    @csrf
        <label for="email">Email</label>
    <input name="email" id="email" type="email">
    <label for="password">password</label>
    <input name="password" id="password" type="password">
    <button type="submit">Login</button>
    </form>
    
</body>
</html>