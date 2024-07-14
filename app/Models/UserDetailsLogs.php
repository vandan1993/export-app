<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetailsLogs extends Model
{
    use HasFactory;

    protected $table = "user_details_logs";

    protected $fillable = [
        'user_id','action_performed','status','user_logs_created_at','user_logs_updated_at','created_at','updated_at'
    ];
}
