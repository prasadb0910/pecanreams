<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_notice_count extends Model
{
    //fillable fields
    protected $fillable = ['fk_newspaper_id', 'date_of_notice', 'notice_count', 'non_relevant_notice_count', 'status', 'created_by', 'updated_by'];
}
