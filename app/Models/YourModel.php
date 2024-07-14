<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YourModel extends Model
{
    use HasFactory;

    protected $table = "your_model";

    protected $fillable = [
        'text',
        'duplex',
    ];
}
