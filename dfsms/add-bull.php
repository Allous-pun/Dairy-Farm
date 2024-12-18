<?php
session_start();
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Add Bull Code
    if (isset($_POST['submit'])) {
        // Getting Post Values
        $name = $_POST['name'];
        $category = $_POST['category'];
        $breed = $_POST['breed'];
        $dob = $_POST['dob'];
        $healthStatus = $_POST['health_status'];
        $lastVaccination = $_POST['last_vaccination'];
        $breedingStatus = $_POST['breeding_status'];
        $assignedCows = json_encode($_POST['assigned_cows']); // Encode array to JSON
        $weightRecord = json_encode($_POST['weight_record']); // Encode array to JSON
        $location = $_POST['location'];
        $treatmentHistory = $_POST['treatment_history'];
        $notes = $_POST['notes'];
        $nextCheckup = $_POST['next_checkup'];

        // Insert into bulls table
        $query = mysqli_query($con, "INSERT INTO bulls (Name, Category, Breed, DOB, Health_Status, Last_Vaccination, Breeding_Status, Assigned_Cows, Weight_Record, Location, Treatment_History, Notes, Next_Checkup) 
                                     VALUES ('$name', '$category', '$breed', '$dob', '$healthStatus', '$lastVaccination', '$breedingStatus', '$assignedCows', '$weightRecord', '$location', '$treatmentHistory', '$notes', '$nextCheckup')");

        if ($query) {
            echo "<script>alert('Bull added successfully.');</script>";
            echo "<script>window.location.href='add-bull.php'</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
            echo "<script>window.location.href='add-bull.php'</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Add Bull</title>
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="hk-wrapper hk-vertical-nav">
        <?php include_once('includes/navbar.php'); include_once('includes/sidebar.php'); ?>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>

        <div class="hk-pg-wrapper">
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="#">Bulls</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Bull</li>
                </ol>
            </nav>

            <div class="container">
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add Bull</h4>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <form class="needs-validation" method="post" novalidate>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="name">Bull Name</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                                <div class="invalid-feedback">Please provide the bull's name.</div>
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="category">Category</label>
                                                <select class="form-control" id="category" name="category" required>
                                                    <option value="">Select Category</option>
                                                    <option value="Young">Young</option>
                                                    <option value="Prime">Prime</option>
                                                    <option value="Old">Old</option>
                                                </select>
                                                <div class="invalid-feedback">Please select a category.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="breed">Breed</label>
                                                <input type="text" class="form-control" id="breed" name="breed" required>
                                                <div class="invalid-feedback">Please provide the breed.</div>
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="dob">Date of Birth</label>
                                                <input type="date" class="form-control" id="dob" name="dob" required>
                                                <div class="invalid-feedback">Please provide the date of birth.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="health_status">Health Status</label>
                                                <textarea class="form-control" id="health_status" name="health_status"></textarea>
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="last_vaccination">Last Vaccination Date</label>
                                                <input type="date" class="form-control" id="last_vaccination" name="last_vaccination">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="breeding_status">Breeding Status</label>
                                                <select class="form-control" id="breeding_status" name="breeding_status" required>
                                                    <option value="">Select Status</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                                <div class="invalid-feedback">Please select the breeding status.</div>
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="location">Location</label>
                                                <input type="text" class="form-control" id="location" name="location" required>
                                                <div class="invalid-feedback">Please provide the location.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="assigned_cows">Assigned Cows</label>
                                                <input type="text" class="form-control" id="assigned_cows" name="assigned_cows" placeholder="Enter cow IDs separated by commas">
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="weight_record">Weight Records</label>
                                                <input type="text" class="form-control" id="weight_record" name="weight_record" placeholder="Enter weights separated by commas">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="treatment_history">Treatment History</label>
                                                <textarea class="form-control" id="treatment_history" name="treatment_history"></textarea>
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="notes">Notes</label>
                                                <textarea class="form-control" id="notes" name="notes"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="next_checkup">Next Checkup Date</label>
                                                <input type="date" class="form-control" id="next_checkup" name="next_checkup">
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
        </div>
    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/init.js"></script>
    <script src="dist/js/validation-data.js"></script>
</body>
</html>
