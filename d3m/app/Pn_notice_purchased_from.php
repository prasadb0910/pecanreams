<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_notice_purchased_from extends Model
{
    protected $fillable = ['fk_notice_id', 'purchased_from'];
}
