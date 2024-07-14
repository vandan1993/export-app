<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $table = "user_details";

    protected $fillable = [
        'user_id','email','name','password','status','user_created_at','user_updated_at','created_at','updated_at'
    ];
}
