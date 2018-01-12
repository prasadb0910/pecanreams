<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_notice_company_name extends Model
{
    protected $fillable = ['fk_notice_id', 'company_name'];
}
