<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $fillable = [
        'id','account', 'mobile', 'email','password','token','state','client_id'
    ];
}
