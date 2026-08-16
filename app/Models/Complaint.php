<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'user_id',
    'category_id',
    'title',
    'description',
    'location',
    'incident_date',
    'status',
])]
class Complaint extends Model
{//kalau satu aja pake singular
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
//     hasMany(
//     ModelTujuan,
//     foreignKey_di_model_tujuan,
//     localKey_di_model_sekarang
// )
// belongsTo(
//     ModelTujuan,
//     foreignKey_di_model_sekarang,
//     ownerKey_di_model_tujuan
// )
    public function category(){
        return $this->belongsTo(ComplaintCategory::class, 'category_id','id');
    }
    public function attachments(){
        return $this->hasMany(ComplaintAttachment::class);
    }
    public function investigationCase(){
        return $this->hasOne(InvestigationCase::class, 'complaint_id','id');
    }
}
