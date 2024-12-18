<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Search for the Bull by Name
    $bull_name = '';
    $result = null; // Initialize result variable
    if (isset($_POST['search'])) {
        $bull_name = $_POST['bull_name']; // Get the name from the form
        $query = "SELECT * FROM bulls WHERE Name LIKE '%$bull_name%'";
        $result = mysqli_query($con, $query);

        // If no bull found
        if (mysqli_num_rows($result) == 0) {
            echo "<script>alert('No bulls found with the provided name.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Search Bulls</title>
    <!-- Data Table CSS -->
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- Include custom styles for sidebar and footer -->
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="hk-wrapper hk-vertical-nav">
        <?php include_once('includes/navbar.php'); include_once('includes/sidebar.php'); ?>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>

        <div class="hk-pg-wrapper">
            <!-- Breadcrumb -->
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="#">Bulls</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Search Bulls</li>
                </ol>
            </nav>

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="search"></i></span></span>Search Bulls</h4>
                </div>

                <!-- Search Form -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <form method="POST" class="form-inline">
                                <div class="form-group mr-3">
                                    <label for="bull_name" class="mr-2">Bull Name:</label>
                                    <input type="text" name="bull_name" id="bull_name" value="<?php echo $bull_name; ?>" class="form-control">
                                </div>
                                <button type="submit" name="search" class="btn btn-primary">Search</button>
                            </form>

                            <?php if (isset($_POST['search']) && mysqli_num_rows($result) > 0): ?>
                                <!-- Bulls Table -->
                                <div class="table-wrap mt-4">
                                    <table id="bulls_table" class="table table-hover w-100 display pb-30">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Breed</th>
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
                                            <?php $cnt = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                                                <tr>
                                                    <td><?php echo $cnt; ?></td>
                                                    <td><?php echo $row['Name']; ?></td>
                                                    <td><?php echo $row['Category']; ?></td>
                                                    <td><?php echo $row['Breed']; ?></td>
                                                    <td><?php echo $row['DOB']; ?></td>
                                                    <td><?php echo $row['Health_Status']; ?></td>
                                                    <td><?php echo $row['Last_Vaccination']; ?></td>
                                                    <td><?php echo $row['Weight_Record']; ?></td>
                                                    <td><?php echo $row['Treatment_History']; ?></td>
                                                    <td><?php echo $row['Notes']; ?></td>
                                                    <td><?php echo $row['Next_Checkup']; ?></td>
                                                </tr>
                                            <?php $cnt++; endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>

    <!-- JS & DataTable initialization -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="vendors/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize the DataTable for the bull search result
            $('#bulls_table').DataTable({
                responsive: true,
                search: true
            });
        });
    </script>
</body>
</html>
