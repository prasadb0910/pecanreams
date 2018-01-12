<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_notice_property_no_detail extends Model
{
    protected $fillable = ['fk_notice_id', 'fk_property_no_type_id', 'property_no'];

    public function Pn_property_no_type()
    {
        return $this->belongsTo('App\Pn_property_no_type','fk_property_no_type_id');
    }
}