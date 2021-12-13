<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //auth使うならかく


class FollowsController extends Controller
{
    public function followPost(){
$followerPost = \DB::table('posts') //post参照して
->leftjoin('users', 'posts.user_id', '=', 'users.id') //usersテーブルと結合して、users.idとpostsのidが一致が条件
->leftjoin('follows', 'follows.follow', '=', 'posts.user_id') //followsテーブルのfollowとusers.id一致が条件
->where('follows.follower', Auth::id()) //followsテーブルのfollowerに自分のIDが入っていることが条件
->select('posts.posts','posts.created_at','users.id','users.username','users.images')
->get();

$images = \DB::table('follows')
->join('users', 'follows.follow', '=', 'users.id')
->select('users.*','images')
->where('follows.follower', Auth::id())
->get();

return view('follows.followList',
['list'=> $followerPost,
'images'=> $images]); //viewでの名前はlist　中身は$
    }


    public function followProfile($id){
$Profile =\DB::table('users')
->where('id', $id)
->select('images','bio','username')
->get();

$list = \DB::table('users') //usersテーブルからもってきた
->where('id', $id)
->get(); //全部取得
$follows = \DB::table('follows') //フォロー切り替えボタンの為に配列化
->where('follower', Auth::id())
->get()
->toArray(); //配列化

$posts = \DB::table('posts')
->join('users', 'users.id', '=', 'posts.user_id') //usersテーブルのusers.idとpostsのidが一致が条件
->where('user_id', $id)
->orderBy('posts.created_at','desc')
->get(); //全部取得


return view('follows.followProfile',['Profile'=> $Profile,'list'=>$list, 'follows'=>$follows,'posts'=>$posts]);


    }

    public function follower(){
$follower = \DB::table('posts')
->leftjoin('users', 'posts.user_id', 'users.id')
->leftjoin('follows', 'follows.follower', 'posts.user_id')
->where('follows.follow', Auth::id())
->select('posts.posts','posts.created_at','users.id','users.username','users.images')
->get();

$images = \DB::table('follows')
->join('users', 'follows.follower', 'users.id')
->select('users.*','images')
->where('follows.follow', Auth::id())
->get();


return view('follows.followerList',['list'=> $follower,'images'=> $images]);}

}
