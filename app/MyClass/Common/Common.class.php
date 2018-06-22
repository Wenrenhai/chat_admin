<?php
namespace App\MyClass;
use App\App;
use App\User;
class Common{
    /**
     * 创建验证码
     * @param  [integer] $bit [位数最大8位超出默认取最大]
     * @return [string]      [验证码]
     */
    public static function create_validation_code($bit){
        $code = substr(md5(uniqid()),rand(0,28),$bit);
        return $code;
	}

	public static function create_account(){
		$account = '';

		for($i = 0; $i <= App::first() -> account_bit; $i++){
			$account .= rand(0,9);
		}

		if(User::where('account', $account)->count()){
			$account = self::create_account();
		}
		return $account;
	}

    public static function create_user_token($user){
        $token = md5(time().$user->credentials.$user->login_uuid);
        if($user->update(['token'=>$token])){
            return $token;
        }else{
            return false;
        }

    }

}
