<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
#[Fillable(['name','description'])]
class ComplaintCategory extends Model
{
    public function complaints(){
        return $this->hasMany(Complaint::class,'category_id','id');
    }
}
