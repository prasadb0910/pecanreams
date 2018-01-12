<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_certificate_no_type extends Model
{
    protected $fillable = ['certificate_no_type', 'status', 'created_by', 'updated_by'];

    public function Pn_notice_certificate_no_detail()
    {
        return $this->hasMany('App\Pn_notice_certificate_no_detail','id');
    }
}
