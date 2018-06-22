<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account')->comment('账号');
            $table->string('mobile')->nullable()->comment('手机号');
            $table->string('email')->nullable()->comment('邮箱');
            $table->string('password')->comment('密码');
            $table->string('token')->nullable()->comment('验证一下啊');
            $table->integer('state')->default(0)->comment('0未激活,1禁止登陆,2在线,3下线');
            $table->string('login_uuid')->nullable()->comment('登录此账号的设备标识');
            $table->string('client_id')->nullable()->comment('当前登陆的客户端id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
