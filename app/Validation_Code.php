<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Validation_Code extends Model
{
    protected $fillable = [
        'uuid', 'code', 'to', 'overdue_time'
    ];

    public static function storage($request,$code){
        if(!isset($request -> uuid)){
            return response() -> json([
                'status' => false,
                'message' => '请传递客户端标识'
            ], 200);
        }else{
            $uuid = $request -> uuid;
        }
        if(!isset($code)){
            return response() -> json([
                'status' => false,
                'message' => '请传验证码'
            ], 200);
        }
        $bool = false;
        if(self::where(['uuid' => $uuid]) -> count()){
            $bool=(bool)self::where(['uuid' => $uuid])->update([
            // 'uuid' => $uuid,
            'code' => $code,
            'to' => $request -> to,
            'overdue_time' => time()+180
            ]);
        }else{
            $bool=(bool)self::create([
                'uuid' => $uuid,
                'code' => $code,
                'to' => $request -> to,
                'overdue_time' => time()+180
            ]);
        }
        if($bool){
            return response()->json([
                'status'=>true,
                'message'=>'发送成功'
            ], 200);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'发送失败'
            ], 200);
        }
    }
}
