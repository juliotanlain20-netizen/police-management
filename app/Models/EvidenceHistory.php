<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'evidence_id',
    'user_id',
    'activity',
    'notes',
])]
class EvidenceHistory extends Model
{
    public function evidence(){
        return $this->belongsTo(Evidence::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
