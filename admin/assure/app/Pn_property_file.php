<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_property_file extends Model
{
	protected $fillable = ['file_name', 'file_path', 'output_file_name', 'output_file_path', 
							'status', 'created_by', 'updated_by', 'approved_by', 'approved_at'];
}
