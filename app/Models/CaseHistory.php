<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'investigation_case_id',
    'user_id',
    'activity',
    'notes',
])]
class CaseHistory extends Model
{
    public function investigationCases(){
        return $this->belongsTo(InvestigationCase::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
