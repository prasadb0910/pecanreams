<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_property_guarantor extends Model
{
    protected $fillable = ['fk_property_id', 'guarantor'];
}
