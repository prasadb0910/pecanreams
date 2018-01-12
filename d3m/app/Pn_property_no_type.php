<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_property_no_type extends Model
{
    protected $fillable = ['property_no_type', 'status', 'created_by', 'updated_by'];

    public function Pn_notice_property_no_detail()
    {
        return $this->hasMany('App\Pn_notice_property_no_detail','id');
    }
}
