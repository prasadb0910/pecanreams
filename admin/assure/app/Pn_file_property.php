<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pn_file_property extends Model
{
	protected $table = 'pn_file_properties';

	// protected $fillable = ['owner_1', 'owner_2', 'property_name', 'purchased_from', 'property_type', 'description', 'building_name', 'society_name', 
	// 						'address', 'apartment_no', 'floor', 'wing', 'district', 'city', 'pincode', 'village', 
	// 						'taluka', 'post', 'division', 'state', 'country', 'google_map_address', 'sheet_no', 'room_no', 
	// 						'block_no', 'ward_no', 'khata_no', 'sr_no', 'plot_no', 'scheme_no', 'cts_no', 'survey_no', 
	// 						'gut_no', 'hissa_no', 'area', 'no_of_parking', 'guarantors', 'company_name', 'company_reg_no', 'certificate_no', 
	// 						'distinctive_no', 'folio_no', 'status', 'created_by', 'updated_by'];

	protected $fillable = ['fk_file_id', 'owner_name', 'unit_no', 'cs_no', 'cts_no', 'gut_no', 'hissa_no', 
							'plot_no', 'wing', 'floor', 'society_name', 'area', 'village', 'address', 
							'road', 'division', 'post', 'taluka', 'city', 'pincode', 'state', 'status', 
							'created_by', 'updated_by', 'approved_by', 'approved_at'];
							
	public function Pn_property_file()
    {
        return $this->belongsTo('App\Pn_property_file','fk_file_id');
    }
}
