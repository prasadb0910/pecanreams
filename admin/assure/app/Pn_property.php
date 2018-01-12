<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_property extends Model
{
	protected $table = 'pn_properties';

	// protected $fillable = ['owner_1', 'owner_2', 'property_name', 'purchased_from', 'property_type', 'description', 'building_name', 'society_name', 
	// 						'address', 'apartment_no', 'floor', 'wing', 'district', 'city', 'pincode', 'village', 
	// 						'taluka', 'post', 'division', 'state', 'country', 'google_map_address', 'sheet_no', 'room_no', 
	// 						'block_no', 'ward_no', 'khata_no', 'sr_no', 'plot_no', 'scheme_no', 'cts_no', 'survey_no', 
	// 						'gut_no', 'hissa_no', 'area', 'no_of_parking', 'guarantors', 'company_name', 'company_reg_no', 'certificate_no', 
	// 						'distinctive_no', 'folio_no', 'status', 'created_by', 'updated_by'];

	protected $fillable = ['legal_owner_name', 'property_name', 'purchased_from', 'property_type', 'description', 'building_name','society_name', 
							'address', 'apartment_no', 'floor', 'wing', 'district', 'city', 'pincode', 'village', 
							'taluka', 'post', 'division', 'state', 'country', 'google_map_address', 'sheet_no', 'room_no', 
							'block_no', 'ward_no', 'khata_no', 'sr_no', 'plot_no', 'scheme_no', 'cts_no', 'survey_no', 
							'gut_no', 'hissa_no', 'area', 'no_of_parking', 'guarantors', 'company_name', 'company_reg_no', 'certificate_no', 
							'distinctive_no', 'folio_no', 'parking_no', 'fk_group_id', 'status', 'created_by', 'updated_by'];
							
	public function Pn_group()
    {
        return $this->belongsTo('App\Pn_group','fk_group_id');
    }
}
