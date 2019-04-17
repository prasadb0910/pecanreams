<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_file_notice_criteria extends Model
{
    protected $fillable = ['parameter', 'property', 'notice', 'pn_property_notice_id', 'matching_criteria'];
}
