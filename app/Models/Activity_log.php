<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'activity',
    'ip_address',
])]
class Activity_log extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
}
