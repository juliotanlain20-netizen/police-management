<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    @if ($errors->any())
<ul>@foreach ($errors->all() as $error)
   <li>{{$error}} </li>
@endforeach</ul>
@endif
    <form action="{{route('register')}} " method="POST">
    @csrf
    <label for="name">Name</label>
    <input name="name" id="name" type="text">
    <label for="phone">phone</label>
    <input name="phone" id="phone" type="text">
    <label for="email">Email</label>
    <input name="email" id="email" type="email">
    <label for="password">password</label>
    <input name="password" id="password" type="password">
    <label for="password_confirmation">password confirmation</label>
    <input name="password_confirmation" type="password">
    <button type="submit">register</button>
    </form>
</body>
</html>