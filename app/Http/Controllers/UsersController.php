<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //auth使うならかく

class UsersController extends Controller
{
    //
    public function profile(Request $request){
        $user = \DB::table('users')
        ->where('id',Auth::id())
        ->first(); //getはたくさんの情報、一個だけなのでfirst

        if( $request->isMethod('post')){ //POSTメソッドか判定
            $date = $request->input(); //送信データが$dateに入る
            $file = $request->file('icon');

            if(!empty($file)){
            $filename = $file->getClientOriginalName(); //画像名抜きだし
            $file->storeAs("images", $filename ,'file'); //保存　どこか　名前　処理の流れ

            \DB::table('users')
            ->where('id',Auth::id())
            ->update([
                'images' => $filename,
            ]);
            }

            if(!empty($date['newpass'])){ //newpassにあったら
            \DB::table('users')
            ->where('id',Auth::id())
            ->update([
                'password' => bcrypt($date['newpass']), //ハッシュ化
            ]);
            }

            \DB::table('users')
            ->where('id', Auth::id()) //条件
            ->update([
                'username' => $date['username'], //左がカラム
                'mail' => $date['mail'],
                'bio' => $date['bio'],
            ]); //どの項目更新するか
            return redirect('/profile');
        }
        return view('users.profile',['user'=>$user]);
    }

    public function search(Request $request){
        $list = \DB::table('users') //usersテーブルからもってきた
        ->select('users.*', 'username', 'images') //usersの中からusernameとimagesだけもってくる
        ->where('id','<>',Auth::id()) //自分のIDを消す
        ->get(); //全部取得

        $follows = \DB::table('follows') //フォロー切り替えボタンの為に配列化
        ->where('follower', Auth::id())
        ->get()
        ->toArray(); //配列化

        if (!empty($request -> input('search'))) { //検索機能　$requestのinputのsearchがあれば処理が走る searchがname属性
        $key = $request -> input('search'); //入力した内容をkeyへ
        $list = \DB::table('users')
        ->select('users.*')
        ->where('username','like','%'. $key .'%') //あいまい検索
        ->get(); //全部取得
        return view('users.search',['list'=>$list,'key'=>$key, 'follows'=>$follows]); //keyがあったらsearch.blade処理が走るので戻るボタンが出る
        }
        return view('users.search',['list'=>$list, 'follows'=>$follows]); //何もない時の処理
    }

}
