<?php
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$table = 'pn_notices';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case object
// parameter names
$columns = array(
    array( 
        'db' => 'notice_file',  
        'dt' => 'notice_file',
        'formatter' => function( $d, $row ) {
            return '<a href="admin/public/uploads/notices/'.$d.'" target="_new"><img src="admin/public/uploads/notices/'.$d.'" style="width: 120px; height: 135px;"></a>';
        }
    ),
    array( 
        'db' => 'notice_title', 
        'dt' => 'notice_title',
        'formatter' => function( $d, $row ) {
            return '<div style="font-weight: bold; font-size: 15px;">'.$d['notice_title'].'</div>
                    <div>'.date('d/m/Y',$d['date_of_notice']).'</div>
                    <div style="line-height: 15px;">'.$d['address'].'</div>
                    <div>
                        <a href="admin/public/uploads/notices/'.$d['notice_file'].'" target="_new">Read More</a>
                    </div>';
        }
    ),
);
 
// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'property_schema',
    'host' => 'localhost'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);