<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['aid']) == 0) {
    header('location:logout.php');
} else {
    // Initialize variables for form handling
    $bull_details = [];
    
    // Check if a bull name is submitted for search
    if (isset($_POST['search'])) {
        $name = $_POST['bull_name'];

        // Validate input
        if (empty($name)) {
            echo "<script>alert('Please enter a bull name to search.');</script>";
            exit;
        }

        // Fetch bull data based on the name
        $query = mysqli_query($con, "SELECT * FROM bulls WHERE Name = '$name'");

        if (mysqli_num_rows($query) > 0) {
            $bull_details = mysqli_fetch_assoc($query);
        } else {
            echo "<script>alert('No bull found with the given name.');</script>";
            exit;
        }
    }

    // Update bull details upon form submission
    if (isset($_POST['update'])) {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $breed = $_POST['breed'];
        $dob = $_POST['dob'];
        $health_status = $_POST['health_status'];
        $last_vaccination = $_POST['last_vaccination'];
        $breeding_status = $_POST['breeding_status'];
        $location = $_POST['location'];

        // Update query
        $update_query = "UPDATE bulls SET 
            Name = '$name', 
            Category = '$category', 
            Breed = '$breed', 
            DOB = '$dob', 
            Health_Status = '$health_status', 
            Last_Vaccination = '$last_vaccination', 
            Breeding_Status = '$breeding_status', 
            Location = '$location'
            WHERE Name = '$name'";

        if (mysqli_query($con, $update_query)) {
            echo "<script>alert('Bull details updated successfully.');</script>";
            echo "<script>window.location.href='all-bulls.php'</script>";
        } else {
            echo "<script>alert('Failed to update bull details.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bull</title>

    <!-- DataTable and Bootstrap CSS for consistent styling -->
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/toggles/toggles.css" rel="stylesheet" type="text/css" />
    <link href="vendors/toggles/toggles-light.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="hk-wrapper hk-vertical-nav">
        <?php include_once('includes/navbar.php'); include_once('includes/sidebar.php'); ?>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        
        <div class="hk-pg-wrapper">
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="#">Bulls</a></li>
                    <li class="breadcrumb-item"><a href="all-bulls.php">All Bulls</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Bull</li>
                </ol>
            </nav>

            <div class="container">
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="edit"></i></span></span>Edit Bull</h4>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <!-- Search form to enter Bull name -->
                            <form method="POST" class="form-inline">
                                <div class="form-group">
                                    <label for="bull_name" class="mr-2">Enter Bull Name</label>
                                    <input type="text" name="bull_name" id="bull_name" class="form-control mb-2" required>
                                </div>
                                <button type="submit" name="search" class="btn btn-primary mb-2">Search Bull</button>
                            </form>

                            <?php if (!empty($bull_details)) { ?>
                                <!-- Display form with bull details for editing -->
                                <form method="POST">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" value="<?php echo $bull_details['Name']; ?>" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select name="category" id="category" class="form-control" required>
                                            <option value="Young" <?php if ($bull_details['Category'] == 'Young') echo 'selected'; ?>>Young</option>
                                            <option value="Prime" <?php if ($bull_details['Category'] == 'Prime') echo 'selected'; ?>>Prime</option>
                                            <option value="Old" <?php if ($bull_details['Category'] == 'Old') echo 'selected'; ?>>Old</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="breed">Breed</label>
                                        <input type="text" name="breed" id="breed" value="<?php echo $bull_details['Breed']; ?>" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" name="dob" id="dob" value="<?php echo $bull_details['DOB']; ?>" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="health_status">Health Status</label>
                                        <textarea name="health_status" id="health_status" class="form-control"><?php echo $bull_details['Health_Status']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_vaccination">Last Vaccination</label>
                                        <input type="date" name="last_vaccination" id="last_vaccination" value="<?php echo $bull_details['Last_Vaccination']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="breeding_status">Breeding Status</label>
                                        <select name="breeding_status" id="breeding_status" class="form-control" required>
                                            <option value="Active" <?php if ($bull_details['Breeding_Status'] == 'Active') echo 'selected'; ?>>Active</option>
                                            <option value="Inactive" <?php if ($bull_details['Breeding_Status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="location">Location</label>
                                        <input type="text" name="location" id="location" value="<?php echo $bull_details['Location']; ?>" class="form-control" required>
                                    </div>
                                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                                    <a href="all-bulls.php" class="btn btn-secondary">Cancel</a>
                                </form>
                            <?php } ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>

    <!-- DataTable JS Initialization -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="vendors/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize the DataTable for any table if needed
            $('#bulls_table').DataTable({
                responsive: true,
                search: true
            });
        });
    </script>
</body>
</html>
