@extends('layouts.login')

@section('content')

@foreach ($images as $image)
<a href="/followProfile/{{ $image->id }}">
<img src="images/{{ $image->images }}">
</a>
@endforeach


<table class='table table-hover'>
@foreach ($list as $list)

<tr>
<td><a href="/followProfile/{{$list->id}}"><img src="images/{{ $list->images }}"></a></td>
<td>{{ $list->username }}</td>
<td>{{ $list->posts }}</td>
<td>{{ $list->created_at }}</td>
</tr>

@endforeach
</table>


@endsection
