<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
#[Fillable([
    'name',
    'description',
])]
class EvidenceCategory extends Model
{
    public function evidences(){
        return $this->hasMany(Evidence::class,'evidence_category_id','id');
    }
}
