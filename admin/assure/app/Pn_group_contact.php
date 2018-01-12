<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_group_contact extends Model
{
    //fillable fields
    protected $fillable = ['fk_group_id', 'name', 'email', 'mobile'];
}
