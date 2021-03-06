<?php

namespace App\Http\Controllers;

use App\Follow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View; //Viewがshereが使える
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

public function __construct(){ //全体

// $this->middleware('auth');
$this->middleware(function ($request, $next) //全部やり終わってからviewに返す為に$request, $next
{
//ログインユーザー名
$username = Auth::user(); //ログインユーザーの情報が$usernameに入る 全部入っちゃう
//フォロワーのカウント
$countFollower = Follow::where('follow', '=', Auth::id())
->count(); //countメソッド
//フォローのカウント
$countFollow = Follow::where('follower', '=', Auth::id())
->count();
$userimage = Auth::user()->images;

//全ビューで共通で使えるよう渡してあげる。むっちゃ素敵。
View::share('username', $username['username']); //view側に渡してあげる
View::share('userimage', $userimage);
View::share('countFollower', $countFollower);
View::share('countFollow', $countFollow);

return $next($request);
});
}
}
