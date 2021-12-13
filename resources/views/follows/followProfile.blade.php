@extends('layouts.login')

@section('content')


@foreach ($Profile as $Profile)
<td><img src="{{asset('images/'.$Profile->images)}}"></td>
Name{{ $Profile->username }}
bio{{ $Profile->bio }}
@endforeach

<table class='table table-hover'>
@foreach ($list as $list)

  @if(!in_array($list->id,array_column($follows,'follow')))
    <td><button type="submit" class="btn btn-success pull-right">
    <a href="/follow/{{$list->id}}">フォローする</a>
      </button></td>
     @else
  <td>
    <button type="submit" class="btn btn-success pull-right">
    <a href="/unfollow/{{$list->id}}">はずす</a>
    </button></td>
@endif

@endforeach
</table>

@foreach ($posts as $post)
<tr>
<td><img src="{{asset('images/'.$post->images)}}"></td>
<td>{{ $post->username }}</td>
<td>{{ $post->posts }}</td>
<td>{{ $post->created_at }}</td>
<td>
</tr>
@endforeach






@endsection
