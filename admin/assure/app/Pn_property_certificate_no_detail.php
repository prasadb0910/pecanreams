<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_property_certificate_no_detail extends Model
{
      protected $fillable = ['fk_property_id', 'fk_certificate_no_type_id', 'certificate_no'];

    public function Pn_certificate_no_type()
    {
        return $this->belongsTo('App\Pn_certificate_no_type','fk_certificate_no_type_id');
    }
}
