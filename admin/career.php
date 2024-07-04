<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once 'api/config.php';

if(!isset($_SESSION['nj_admin'])){

    header('Location: '.$admin_url.'login.php');

    die('check');

}

$stmt = $conn->prepare("SELECT * FROM career ORDER BY id DESC");

$stmt->execute();

$result = $stmt->get_result();

// echo "<pre>";
// print_r($stmt);
// exit;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Career List</title>
  
    <link href="assets/admin/css/sb-admin-2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/admin/css/newdatatable.css" />
    <link rel="stylesheet" type="text/css" href="assets/admin/css/custom.css" />
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php'; ?>              

                <!-- Begin Page Content -->
                <div class="container-fluid pt-5">

                    <div id="receipt" style="display: none;"></div>

                    <!-- Page Heading -->
                    <a href="javascript:history.back()" style="float:right;" class="btn btn-primary">Back</a>
                    <h1 class="h3 mb-2 text-gray-800">Career List

                    </h1>

                    <div class="card shadow mb-4">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="99%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Mobile Number</th>
                                            <th>Email</th>
                                            <th>Position</th>
                                            <th>File</th>
                                            <th>Date & Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $counter = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            $counter = ++$counter;
                                            $created_at = date_format(date_create($row['created_at']), "d-m-Y ");
                                            echo '<tr>

                                                <td data-id="' . $row['id'] . '">' . $counter . '</td>
                                                <td>' . ucfirst($row['name']) . ' </td>
                                                <td>' . $row['mobile'] . ' </td>
                                                <td>' . $row['email'] . ' </td>
                                                <td>' . $row['position'] . ' </td>
                                                <td><a href="'.$base_url.'' . $row['resume'] . '" target=_blank>View</a> </td>
                                                <td>' . $created_at . ' </td>';
                                            }
                                        ?>
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
    </div>

    <script src="assets/js/jquery.min.js?v3.4.1"></script>

    <script src="assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="assets/admin/js/newdatatable.js"></script>

    <script type="text/javascript">
       /* $('#dataTable thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#dataTable thead');*/

        $('#dataTable').dataTable({

            dom: 'Bfrtip',

            "aLengthMenu": [

                [25, 100, 200],

                [25, 100, 200, "All"]

            ],

            "buttons": [

                'csv', 'excel'

            ],
        });
    </script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js">

    </script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script>

    </script>

</body>

</html>