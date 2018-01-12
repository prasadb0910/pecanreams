<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_no_notice extends Model
{
    //fillable fields
    protected $fillable = ['fk_newspaper_id', 'date_of_notice', 'status', 'created_by', 'updated_by'];
}
