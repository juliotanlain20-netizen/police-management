<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'investigation_case_id',
    'evidence_category_id',
    'evidence_code',
    'name',
    'description',
    'storage_location',
    'status',
])]
class Evidence extends Model
{
    public function investigationCase()
    {
        return $this->belongsTo(InvestigationCase::class, 'investigation_case_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(EvidenceCategory::class, 'evidence_category_id', 'id');
    }
    public function evidenceHistory()
    {
        return $this->hasMany(EvidenceHistory::class);
    }
}
