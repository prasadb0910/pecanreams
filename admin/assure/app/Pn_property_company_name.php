<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_property_company_name extends Model
{
    protected $fillable = ['fk_property_id', 'company_name'];
}
