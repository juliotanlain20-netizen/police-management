<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'complaint_id',
    'file_name',
    'file_path',
    'mime_type',
    'file_size',
])]
class ComplaintAttachment extends Model
{
    public function complaint(){
        return $this->belongsTo(Complaint::class);
    }
}
