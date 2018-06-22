<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Validation_Code;
use App\MyClass\Ucpaas;
use App\MyClass\Common;
use App\User;
use Mail;
class RegisterController extends Controller
{
    /**
     * 发送注册验证短信
     * @param  Request $request 表单提交的数据
     * @return array           状态
     */
    public function sendMobile(Request $request)
	{
        if(!isset($request -> to)){
            return response() -> json([
                'status' => false,
                'message' => '请输入注册方式'
            ], 400);
        }
		if(!User::where('mobile', $request -> to) -> count()){
	        $code = Common::create_validation_code(4);
		    $Ucpaas = new Ucpaas(['accountsid'=>'a9aa2f9778f671a04dd9a7dfe0adfe3f','token'=>'febb13be2e62da104443573c87ec118c']);
			$r = $Ucpaas -> SendSms('6e60094d6ea64144854f65a6a274a46a',284579,config('app.name').','.$code,$request->to,'');
	        // if(true){
		    if(json_decode($r,true)['code']=='000000'){
			    return Validation_Code::storage($request,$code);
	        }else{
		        return response() -> json([
			        'status'=>false,
				    'message'=>'发送失败'
	            ], 400);
			}
		}else{
			return response() -> json([
				'status' => false,
				'message' => '手机号已经被注册'
			], 400);
		}
    }

    public function sendEmail(Request $request){
        if(!isset($request -> to)){
            return response() -> json([
                'status' => false,
                'message' => '请输入注册方式'
            ], 400);
        }
        if(!User::where('email', $request -> to) -> count()){
            $code = Common::create_validation_code(4);

            Mail::send('email.register',['app_name'=>config('app.name'),'code'=>$code],function($message) use ($request){
                $message -> to($request -> to)->subject('注册验证');
            });

            return Validation_Code::storage($request,$code);
            // return response() -> json([
            //     'status' => false,
            //     'message' => '发送成功'
            // ]);
        }else{
            return response() -> json([
                'status' => false,
                'message' => '邮箱已经被注册了'
            ], 400);
        }
    }

    public function validation(Request $request){
        // return 'x';
        //判断注册方式
        $type = 'email';
        if(isset($request -> mobile)){
            $type = 'mobile';
        }else if(!isset($request -> email)){
            return response() -> json([
                'status' => false,
                'message' => '请传递注册方式'
            ], 400);
        }

        //验证数据
        if(!isset($request -> code)){
            return response() -> json([
                'status' => false,
                'message' => '请传递验证码'
            ], 400);
        }



        if(!isset($request -> password)){
            return response() -> json([
                'status' => false,
                'message' => '请输入密码'
            ], 400);
        }


        //查看是否被注册
        if(!User::where($type, $request[$type]) -> count()){
            $code = Validation_Code::where('uuid', $request -> uuid)->first();
            if($code['code']==$request -> code){
                if($code['to']!=$request[$type]){
                    return response() -> json([
                        'status' => false,
                        'message' => '注册方式与验证码不符'
                    ], 400);
                }
                if(time()>$code['overdue_time']){
                    return response() -> json([
                        'status' => false,
                        'message' => '验证码已过期,请重新获取'
                    ], 400);
                }
                return self::create($request);
            }else{
                return response() -> json([
                    'status' => false,
                    'message' => '验证码错误'
                ], 400);
            }
        }else{
            $arr = [
                'email' => '邮箱',
                'mobile' => '手机号'
            ];
            return response() -> json([
                'status' => false,
                'message' => '此'.$arr[$type].'已经被注册'
            ], 400);
        }
    }

    public static function create($request){

        $type = 'email';
        if(isset($request -> mobile)){
            $type = 'mobile';
        }

        $account = Common::create_account();
        // return response() -> json([
        //     'status' => false,
        //     'message' => 'hahahahh-'.$account
        // ], 400);
        $bool = User::create([
            'account' => $account,
            $type => $request[$type],
            'password' => $request -> password
        ]);
        if($bool){

            return response() -> json([
                'status' => true,
                'data' => [
                    'account' => $account
                ],
                'message' => '注册成功'
            ], 200);
        }else{

            return response() -> json([
                'status' => false,
                'message' => '注册失败'
            ], 400);
        }
    }

}
