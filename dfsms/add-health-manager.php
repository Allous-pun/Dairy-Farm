<?php
session_start();
//error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Add Health Manager Code
    if (isset($_POST['submit'])) {
        // Getting Post Values
        $name = $_POST['name']; 
        $assignedAnimals = $_POST['assigned_animals'];   
        $startDate = $_POST['start_date'];

        // Insert into tblhealth_managers table
        $query = mysqli_query($con, "INSERT INTO tblhealth_managers(Name, AssignedAnimals, StartDate) 
                                      VALUES('$name', '$assignedAnimals', '$startDate')");
        
        if ($query) {
            echo "<script>alert('Health Manager added successfully.');</script>";   
            echo "<script>window.location.href='add-health-manager.php'</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";   
            echo "<script>window.location.href='add-health-manager.php'</script>";    
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Add Health Manager</title>
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
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
                    <li class="breadcrumb-item"><a href="#">Managers</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Health Manager</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add Health Manager</h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <form class="needs-validation" method="post" novalidate>
                                        
                                        <!-- Health Manager Name -->
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Health Manager Name</label>
                                                <input type="text" class="form-control" id="validationCustom03" placeholder="Health Manager Name" name="name" required>
                                                <div class="invalid-feedback">Please provide a valid health manager name.</div>
                                            </div>
                                        </div>

                                        <!-- Assigned Animals -->
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Assigned Animals</label>
                                                <input type="text" class="form-control" id="validationCustom03" placeholder="Assigned Animals (e.g. Cows, Heifers)" name="assigned_animals" required>
                                                <div class="invalid-feedback">Please provide a valid list of animals.</div>
                                            </div>
                                        </div>

                                        <!-- Start Date -->
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Start Date</label>
                                                <input type="date" class="form-control" id="validationCustom03" placeholder="Start Date" name="start_date" required>
                                                <div class="invalid-feedback">Please provide a valid start date.</div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php include_once('includes/footer.php');?>
            <!-- /Footer -->

        </div>
        <!-- /Main Content -->
    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="vendors/jquery-toggles/toggles.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
    <script src="dist/js/init.js"></script>
    <script src="dist/js/validation-data.js"></script>

</body>
</html>
