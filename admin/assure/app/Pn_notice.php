<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_notice extends Model
{
    //fillable fields
    protected $fillable = ['notice_title', 'date_of_notice', 'notice_file', 'details', 'fk_newspaper_id', 'days_for_respond', 
    						'issued_by', 'reason_for_notice', 'issued_for', 'subject_matter', 'name_of_property', 
    						'date_of_purchase', 'property_status', 'property_type', 'property_description', 'building_name', 
    						'unit_no', 'floor', 'wing', 'address', 'landmark', 'village', 'city', 'pincode', 
    						'state', 'country', 'google_map_address', 'cts_no', 'survey_number', 
    						'area', 'parking', 'legal_owner_name', 'legal_owner_pan', 'legal_owner_address', 
    						'company_name', 'company_registration_no', 'fk_notice_type_id', 'status', 'created_by', 'updated_by', 
                            'society_name','page_number'];

    public function Pn_newspaper()
    {
        return $this->belongsTo('App\Pn_newspaper','fk_newspaper_id');
    }

    public function Pn_notice_type()
    {
        return $this->belongsTo('App\Pn_notice_type','fk_notice_type_id');
    }
}
