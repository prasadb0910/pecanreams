<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_notice_type extends Model
{
    //fillable fields
    protected $fillable = ['notice_type', 'status', 'created_by', 'updated_by'];

    public function Pn_notice()
    {
        return $this->hasMany('App\Pn_notice','id');
    }
}
