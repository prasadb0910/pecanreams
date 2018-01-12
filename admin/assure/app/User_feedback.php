<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_feedback extends Model
{
    //fillable fields
    protected $fillable = ['name', 'email', 'mobile', 'message', 'status', 'created_by', 'updated_by', 'type_of_feedback'];
}
