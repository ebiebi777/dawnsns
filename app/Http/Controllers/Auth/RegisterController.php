<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255',
            'mail' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

//バリデーション
public function store(array $val)
{
return Validator::make($val, [ //
'username' => 'required|min:4|max:12',
'mail' => 'required|min:4|max:50|unique:users',
'password' => ['required', 'unique:users', 'regex:/^[0-9a-zA-Z]{4,12}+$/'],
'password-confirm' => ['required', 'same:password', 'regex:/^[0-9a-zA-Z]{4,12}+$/'] //「数字の0～9」「英語のa～z」「英語のA～Z」「文字数4~12」
], [
'required' => '必須項目です',
'min' => '4文字以上で入力してください',
'max' => '12文字以内で入力してください',
'unique' => 'すでに使われています',
'same' => 'パスワードが異なります',
'regex' =>'半角英数字4～12文字でお願いします'
]);
}


    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'mail' => $data['mail'],
            'password' => bcrypt($data['password']),
        ]);
    }

    // public function registerForm(){
    //     return view("auth.register");
    // }

    public function register(Request $request){ //新規登録
if ($request->isMethod('post')) { //postできてるかどうか
$data = $request->input(); //inputでrequestされてきたデータが$dataに入る

$validate = $this->store($data); //storeに$data飛ばす　終わったら帰ってきて下の処理が走る
if ($validate->fails()) {
return redirect('/register')->withErrors($validate)->withInput(); //バリデーションがエラーで戻った時に値を保持
} else {
$this->create($data); //大丈夫だったらcreateに処理を飛ばしている

return redirect('added')->with('data', $data['username']); //addedにリダイレクトdateにusernameを渡す
}
}
return view('auth.register');
}

    public function added(){
        return view('auth.added');
    }
}
