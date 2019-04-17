<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <title> Pecan Reams - <?php echo $notice_title; ?></title>

    <!-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> -->
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
</head>
<body>
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title, Date Of Notice & Description</th>
            </tr>
        </thead>
    </table>

    <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> -->

    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
     
    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // $('#example').DataTable( {
            //     "processing": true,
            //     "serverSide": true,
            //     "ajax": "objects.php",
            //     "columns": [
            //         { "data": "notice_file" },
            //         { "data": ["notice_title", "date_of_notice", "address", "notice_file"] }
            //     ]
            // } );

            $('#example').dataTable({
                "bProcessing": true,
                "sAjaxSource": "notice_data.php",
                "aoColumns": [
                                { mData: 'image' },
                                { mData: 'title' }
                            ],
                pagingType: "full_numbers"
            });
        });
    </script>
</body>
</html>