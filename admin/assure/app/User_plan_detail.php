<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_plan_detail extends Model
{
    //fillable fields
    protected $fillable = ['user_id', 'plan_name', 'no_of_properties', 'plan_expires_on', 'status', 'created_by', 'updated_by', 'approved_by', 'approved_at'];
}
