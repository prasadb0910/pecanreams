<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_property_purchased_from extends Model
{
     protected $fillable = ['fk_property_id', 'purchased_from'];
}
