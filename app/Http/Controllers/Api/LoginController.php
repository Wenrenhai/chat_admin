<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
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

        $users = User::where('password', $request -> password)->get()->toArray();
        // dd($users);
        $bool = false;

        foreach($users as $user){
            if(in_array($request -> account, $user)){
                $bool=true;
            }
        }

        if($bool){
            return response() -> json([
                'status' => true,
                'message' => 'ojbk'
            ], 200);
        }else{
            return response() -> json([
                'status' => false,
                'message' => '账号或密码错误'
            ], 400);
        }


    }


}
