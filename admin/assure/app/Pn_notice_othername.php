<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_notice_othername extends Model
{
    protected $fillable = ['fk_property_id', 'othername'];
}
