<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'complaint_id',
    'case_number',
    'title',
    'description',
    'status',
    'priority',
])]
class InvestigationCase extends Model
{
    public function complaint(){
        return $this->belongsTo(Complaint::class);
    }
    public function histories(){
        return $this->hasMany(CaseHistory::class);
    }
    public function evidences(){
        return $this->hasMany(Evidence::class,'investigation_case_id','id');
    }
    public function officers(){
        return $this->belongsToMany(PoliceOfficer::class,'case_officers','investigation_case_id', 'police_officer_id' );
    }

}
