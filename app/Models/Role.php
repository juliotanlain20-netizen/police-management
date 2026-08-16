<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
#[Fillable(['name','description'])]
class Role extends Model
{
    public function users(){
        return $this->belongsToMany(User::class,'role_user','role_id','user_id');
    }
    public function permissions(){
        return $this->belongsToMany(Permission::class,'permission_role','role_id','permission_id');
    }
}
