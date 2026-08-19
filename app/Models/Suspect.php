<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
#[Fillable([
    'investigation_case_id',
    'name',
    'identity_number',
    'address',
    'status',
    'notes',
])]
class Suspect extends Model
{
    public function case(){
        return $this->belongsTo(InvestigationCase::class, 'investigation_case_id', 'id');
    }
}
