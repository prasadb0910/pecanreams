<?php

use Illuminate\Database\Seeder;
use App\Pn_property_no_type;
use App\Pn_location_type;
use App\Pn_certificate_no_type;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pn_property_no_type::create([
        	'property_no_type' => 'Sheet No',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_property_no_type::create([
        	'property_no_type' => 'Room No',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_property_no_type::create([
        	'property_no_type' => 'Block No',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_property_no_type::create([
        	'property_no_type' => 'Ward No',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_property_no_type::create([
        	'property_no_type' => 'Khata No',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_property_no_type::create([
        	'property_no_type' => 'Sr No',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_property_no_type::create([
        	'property_no_type' => 'Plot No',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_property_no_type::create([
        	'property_no_type' => 'Scheme No',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_property_no_type::create([
        	'property_no_type' => 'Unit No',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_property_no_type::create([
        	'property_no_type' => 'CTS No',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_property_no_type::create([
        	'property_no_type' => 'Survey No',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_property_no_type::create([
        	'property_no_type' => 'Gut No',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_property_no_type::create([
        	'property_no_type' => 'Hissa No',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);

        Pn_location_type::create([
            'location_type' => 'Division',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_location_type::create([
            'location_type' => 'Taluka',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_location_type::create([
            'location_type' => 'Post',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_location_type::create([
            'location_type' => 'District',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_location_type::create([
            'location_type' => 'Village',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);

        Pn_certificate_no_type::create([
            'certificate_no_type' => 'Certificate no',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_certificate_no_type::create([
            'certificate_no_type' => 'Distinctive no',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
        Pn_certificate_no_type::create([
            'certificate_no_type' => 'Folio no',
            'status' => 'approved',
            'created_by' => '1',
            'updated_by' => '1'
        ]);
    }
}
