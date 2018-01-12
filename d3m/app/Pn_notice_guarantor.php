<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_notice_guarantor extends Model
{
    protected $fillable = ['fk_notice_id', 'guarantor'];
}
