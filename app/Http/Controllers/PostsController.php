<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostsController extends Controller
{
    //
    public function index(){
        $list = \DB::table('posts')
        ->join('users', 'users.id', '=', 'posts.user_id') //usersテーブルのusers.idとpostsのidが一致が条件
        ->select('posts.*', 'username', 'images')
        ->orderBy('posts.created_at','desc')
        ->get(); //全部取得
        return view('posts.index',['list'=>$list]); //viewでの名前はlist　中身は$list
    }

    public function create(Request $request){ //ユーザーからリクエストされたものを$requestにいれてる
    $create = $request->input('newPost'); //インプットされたもの　name属性newPost
    \DB::table('posts')->insert([
            'posts' => $create, //左がカラム　右入れる内容
            'user_id' => Auth::id(), //認証されたユーザーのID
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect('/top');
    }

     public function update(Request $request){
        $id = $request->input('id');
        $up_post = $request->input('update');
        \DB::table('posts')
            ->where('id', $id) //条件
            ->update(
                ['posts' => $up_post] //どの項目更新するか
            );

        return redirect('/top');
        }

    public function delete($delete)
    {
        \DB::table('posts')
            ->where('id', $delete) //選択された投稿ID（$delete）とidが一緒か
            ->delete();
        return redirect('/top');
    }

    public function follow($follow)
    {
    \DB::table('follows')
    ->insert([
    'follow' => $follow, //相手のid 左がカラム　右入れる内容
    'follower' => Auth::id(), //自分のID
     ]);
     return redirect('/search');
    }

     public function unfollow($unfollow){
    \DB::table('follows')
    ->where('follow', $unfollow) //相手のid
    ->where('follower', Auth::id()) //自分のid
    ->delete();
    return redirect('/search');
     }


}
