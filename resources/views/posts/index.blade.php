@extends('layouts.login')

@section('content')

{!! Form::open(['url' => '/post/create']) !!}
     <div class="form-group">
         {!! Form::input('text', 'newPost', null, ['required', 'class' => 'form-control', 'placeholder' => '投稿内容']) !!}
     </div>
     <button type="submit" class="btn btn-success pull-right">
       <img src="images/post.png">
     </button>
 {!! Form::close() !!}

 <table class='table table-hover'>
            @foreach ($list as $list)
            <tr>
                <td><img src="images/{{ $list->images }}"></td>
                <td>{{ $list->username }}</td>
                <td>{{ $list->posts }}</td>
                <td>{{ $list->created_at }}</td>
                <td>
                  <a href="" class="modalopen" data-target="modal{{$list->id}}" >
                    <img src="images/edit.png">
                  </a>
                </td>
                <td>
                  <a href="{{$list->id}}/delete">
                    <img src="images/trash.png">
                  </a>
                </td>
            </tr>

            <div class="updateform" id="modal{{$list->id}}">
        {!! Form::open(['url' => '/update']) !!}
       <div class="form-group">
         {!! Form::input('text', 'update', $list->posts, ['required', 'class' => 'form-control',]) !!}
         {!! Form::hidden('id', $list->id) !!}
        </div>
        <button type="submit" class="btn btn-success pull-right">
         <img src="images/edit.png">
     </button>
 {!! Form::close() !!}
 </div>
            @endforeach
        </table>


@endsection
