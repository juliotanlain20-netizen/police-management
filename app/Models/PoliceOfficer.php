<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'rank_id',
    'unit_id',
    'nrp',
    'phone',
    'address',
    'status',
])]
class PoliceOfficer extends Model
{
    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function cases(){
        return $this->belongsToMany(InvestigationCase::class,'case_officers', 'police_officer_id', 'investigation_case_id');
    }

}
