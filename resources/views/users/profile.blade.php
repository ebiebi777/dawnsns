@extends('layouts.login')

@section('content')



<form action='/update/profile' method='post' enctype="multipart/form-data">
    {{csrf_field()}}
username<input type="text" name="username" value="{{$user->username}}">
Mailadress<input type="text" name="mail" value="{{$user->mail}}">
password{{$user->password}}
newpassword<input type="text" name="newpass">
Bio<input type="text" name="bio" value="{{$user->bio}}">
Iconimage<input type="file" name="icon" value="{{$user->images}}">



<button type="submit" class="btn btn-success pull-right">
<p>更新</p>
</button>

</form>



@endsection
