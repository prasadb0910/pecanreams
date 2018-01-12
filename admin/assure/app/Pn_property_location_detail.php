<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_property_location_detail extends Model
{
   protected $fillable = ['fk_property_id', 'fk_location_type_id', 'property_no'];

    public function Pn_location_type()
    {
        return $this->belongsTo('App\Pn_location_type','fk_location_type_id');
    }
}
