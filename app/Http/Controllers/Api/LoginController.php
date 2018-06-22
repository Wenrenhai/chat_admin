<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\MyClass\Common;
class LoginController extends Controller
{
    public function login(Request $request){
        if(!isset($request -> credentials)){
            return response() -> json([
                'status' => false,
                'message' => '请传递登录凭证'
            ], 400);
        }
        if(!isset($request -> password)){
            return response() -> json([
                'status' => false,
                'message' => '请输入密码'
            ]);
        }

        $users = User::where('password', $request -> password)->get();
        $bool = false;
        $login_user = null;
        foreach($users as $user){
            $v = $user -> toArray();
            if(in_array($request -> credentials, $v)){
                $login_user = $user;
                $bool = true;
            }
        }

        if($bool){
            $token = Common::create_user_token($login_user);
            if($token){
                return response() -> json([
                    'status' => true,
                    'data' => [
                        'token' => $token
                    ],
                    'message' => 'ojbk'
                ], 200);

            }else{
                return response() -> json([
                    'status' => false,
                    'message' => '登录失败'
                ],400);
            }
        }else{
            return response() -> json([
                'status' => false,
                'message' => '账号或密码错误'
            ], 400);
        }


    }


}
