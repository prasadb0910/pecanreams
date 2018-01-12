<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_notice_legal_owner_name extends Model
{
    protected $fillable = ['fk_notice_id', 'legal_owner_name'];
}
