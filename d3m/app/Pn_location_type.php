<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_location_type extends Model
{
    protected $fillable = ['location_type', 'status', 'created_by', 'updated_by'];

    public function Pn_notice_location_detail()
    {
        return $this->hasMany('App\Pn_notice_location_detail','id');
    }
}
