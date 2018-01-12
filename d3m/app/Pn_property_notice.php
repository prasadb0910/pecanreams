<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_property_notice extends Model
{
	protected $fillable = ['fk_property_id', 'fk_notice_id', 'status', 'created_by', 'updated_by', 'approved_by', 'approved_at'];
}
