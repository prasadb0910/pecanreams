<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_group extends Model
{
    //fillable fields
    protected $fillable = ['group_name', 'status', 'created_by', 'updated_by'];
}
