<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidationCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validation__codes', function (Blueprint $table) {
            // $table->increments('id');
            $table->string('uuid')->comment('客户端唯一标识');
            $table->string('to')->comment('注册方式 手机号或者邮箱');
            $table->string('code')->comment('验证码');
            $table->integer('overdue_time')->comment('过期时间');
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
        Schema::dropIfExists('validation__codes');
    }
}
