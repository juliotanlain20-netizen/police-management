<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
#[Fillable(['name','description'])]
class Rank extends Model
{
    public function policeOfficers(){
        return $this->hasMany(PoliceOfficer::class) ;
    }
}
