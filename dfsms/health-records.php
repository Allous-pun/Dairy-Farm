<?php
session_start();
// error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    $rno = mt_rand(10000, 99999);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Health Records</title>
    <!-- Data Table CSS -->
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <!-- DataTables Buttons CSS -->
    <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- HK Wrapper -->
    <div class="hk-wrapper hk-vertical-nav">

        <!-- Top Navbar -->
        <?php include_once('includes/navbar.php');
        include_once('includes/sidebar.php');
        ?>

        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <!-- Breadcrumb -->
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="#">Bulls</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Health Records</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">

                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="users"></i></span></span>Health Records</h4>
                </div>
                <!-- /Title -->

                <!-- Search and Download Section -->
                <div class="hk-sec-wrapper">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <!-- Search Box -->
                            <input type="text" id="searchBox" class="form-control" placeholder="Search Bull Health Records" />
                        </div>
                        <div class="col-sm-6 text-right">
                            <!-- Download Button with Dropdown -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" id="downloadReportBtn">
                                    <i class="icon-download"></i> Download Report
                                </button>
                                
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap">
                                        <table id="datable_1" class="table table-hover w-100 display pb-30">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Bull Name</th>
                                                    <th>Date of Birth</th>
                                                    <th>Health Status</th>
                                                    <th>Last Vaccination</th>
                                                    <th>Weight Record</th>
                                                    <th>Treatment History</th>
                                                    <th>Notes</th>
                                                    <th>Next Checkup</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Query to fetch bull data excluding certain fields
                                                $query = mysqli_query($con, "SELECT Bull_ID, Name, DOB, Health_Status, Last_Vaccination, Weight_Record, Treatment_History, Notes, Next_Checkup FROM bulls");
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $cnt; ?></td>
                                                        <td><?php echo $row['Name']; ?></td>
                                                        <td><?php echo $row['DOB']; ?></td>
                                                        <td><?php echo $row['Health_Status']; ?></td>
                                                        <td><?php echo $row['Last_Vaccination']; ?></td>
                                                        <td><?php echo json_encode($row['Weight_Record']); ?></td>
                                                        <td><?php echo $row['Treatment_History']; ?></td>
                                                        <td><?php echo $row['Notes']; ?></td>
                                                        <td><?php echo $row['Next_Checkup']; ?></td>
                                                    </tr>
                                                <?php
                                                    $cnt++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- /Row -->

            </div>
            <!-- /Container -->

            <!-- Footer -->
            <?php include_once('includes/footer.php'); ?>
            <!-- /Footer -->
        </div>
        <!-- /Main Content -->
    </div>
    <!-- /HK Wrapper -->

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="vendors/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="dist/js/dataTables-data.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="vendors/jquery-toggles/toggles.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
    <script src="dist/js/init.js"></script>

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>

    <!-- Additional dependencies for buttons (e.g., jszip, pdfmake) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- Custom Script for Search and Download -->
    <script>
    $(document).ready(function () {
        // Check if the table is already initialized and destroy it before reinitializing
        if ($.fn.dataTable.isDataTable('#datable_1')) {
            $('#datable_1').DataTable().destroy();
        }

        // Initialize the DataTable with Buttons extension
        var table = $('#datable_1').DataTable({
            dom: 'Bfrtip',  // This will allow the buttons to be placed but we will handle their display via the dropdown
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'] // Initialize the required buttons here
        });

        // Create a custom dropdown to hold the export buttons dynamically
        var exportDropdown = $('<div class="btn-group" />')
            .append('<button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Download Report</button>')
            .append('<div class="dropdown-menu" aria-labelledby="exportDropdown"></div>');

        // Append the dropdown to the page (make sure you're replacing the previous button properly)
        $('#downloadReportBtn').replaceWith(exportDropdown);

        // Reinitialize DataTable buttons into the dropdown
        table.buttons().container().appendTo('.dropdown-menu');

        // Search functionality
        $('#searchBox').on('keyup', function () {
            table.search(this.value).draw();
        });
    });
    </script>

</body>

</html>
<?php } ?>
