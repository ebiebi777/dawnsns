@extends('layouts.login')

@section('content')

<form method = "post" action = "search">
  {{csrf_field()}}
  <input name = "search" type = "text">
  <button type="submit"><i class="fab fa-sistrix"></i></button>
</form>

@if(!empty($key))
<p>検索したワード：{{$key}}</p>
<a href="/search">戻る</a>
@endif

<table class='table table-hover'>
@foreach ($list as $list)
<tr>
  <td><img src="images/{{ $list->images }}"></td>
  <td>{{ $list->username }}</td>

  @if(!in_array($list->id,array_column($follows,'follow')))
    <td><button type="submit" class="btn btn-success pull-right">
    <a href="/follow/{{$list->id}}">フォローする</a>
      </button></td>
     @else
  <td>
    <button type="submit" class="btn btn-success pull-right">
    <a href="/unfollow/{{$list->id}}">フォローを外す</a>
    </button></td>
  </tr>
@endif

@endforeach
</table>

@endsection
