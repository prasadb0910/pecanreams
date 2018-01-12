<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_newspaper extends Model
{
    //fillable fields
    protected $fillable = ['paper_name', 'language', 'e_paper', 'frequency', 'area', 'price', 'status','news_type', 'created_by', 'updated_by'];

    public function Pn_notice()
    {
        return $this->hasMany('App\Pn_notice','id');
    }
}
