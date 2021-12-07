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
->get();

$images = \DB::table('follows')
->join('users', 'follows.id', '=', 'users.id')
->select('users.*','images')
->where('follows.follower', Auth::id())
->get();

return view('follows.followList',
['list'=> $followerPost,
'images'=> $images]); //viewでの名前はlist　中身は$
    }


    public function followProfile(){



        return view('follows.followProfile');
    }



}
