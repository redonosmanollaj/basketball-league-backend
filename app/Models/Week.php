<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{

    protected $fillable = ['number','period'];
    public $timestamps = false;

    public function matches(){
        return $this->hasMany('App\Models\Match');
    }
}
