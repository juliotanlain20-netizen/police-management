<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
#[Fillable(['author_id','title','content','thumbnail','status','published_at'])]
class News extends Model
{
    public function author(){
        return $this->belongsTo(User::class, 'author_id','id');
    }
}
