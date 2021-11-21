<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //auth使うならかく

class UsersController extends Controller
{
    //
    public function profile(){
        return view('users.profile');
    }

    public function search(Request $request){
        $list = \DB::table('users') //usersテーブルからもってきた
        ->select('users.*', 'username', 'images') //usersの中からusernameとimagesだけもってくる
        ->where('id','<>',Auth::id()) //自分のIDを消す
        ->get(); //全部取得

        if (!empty($request -> input('search'))) { //検索機能　$requestのinputのsearchがあれば処理が走る
        $key = $request -> input('search'); //入力した内容をkeyへ
        $list = \DB::table('users')
        ->select('users.*')
        ->where('username','like','%'. $key .'%') //あいまい検索
        ->get(); //全部取得
        return view('users.search',['list'=>$list,'key'=>$key]); //keyがあったらsearch.blade処理が走るので戻るボタンが出る
        }
        return view('users.search',['list'=>$list]); //何もない時の処理
    }


}
