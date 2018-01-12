<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_property_legal_owner_name extends Model
{
    protected $fillable = ['fk_property_id', 'legal_owner_name'];
}
