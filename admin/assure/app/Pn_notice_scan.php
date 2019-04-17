<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_notice_scan extends Model
{
    //fillable fields
    protected $fillable = ['date_of_notice', 'notice_file', 'fk_newspaper_id', 'page_number', 'section', 'status', 'created_by', 'updated_by'];

    public function Pn_newspaper()
    {
        return $this->belongsTo('App\Pn_newspaper','fk_newspaper_id');
    }
}
