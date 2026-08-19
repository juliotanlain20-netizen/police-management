<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
#[Fillable([
    'complaint_id',
    'file_name',
    'file_path',
    'mime_type',
    'file_size',
])]
class ComplaintAttachment extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function complaint(){
        return $this->belongsTo(Complaint::class);
    }
}
