<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'evidence_id',
    'file_name',
    'file_path',
    'mime_type',
    'file_size',
    'uploaded_at',
])]
class EvidenceAttachment extends Model
{
    public $timestamps = false;

    public function evidence()
    {
        return $this->belongsTo(Evidence::class);
    }
}
