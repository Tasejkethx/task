<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded=[];

    public function employees(){
        return $this->belongsToMany(Employee::class)->withPivot("department_name");
    }
}
