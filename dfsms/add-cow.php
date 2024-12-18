<?php
session_start();
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Add Cow Code
    if (isset($_POST['submit'])) {
        // Getting Post Values
        $name = $_POST['name'];
        $tagCode = $_POST['tag_code'];
        $breed = $_POST['breed'];
        $dob = $_POST['dob'];
        $category = $_POST['category'];
        $healthStatus = $_POST['health_status'];
        $lastVaccination = $_POST['last_vaccination'];
        $lastTreatment = $_POST['last_treatment'];
        $breedingStatus = $_POST['breeding_status'];
        $lastBreedingDate = $_POST['last_breeding_date'];
        $expectedDeliveryDate = $_POST['expected_delivery_date'];
        $numberOfCalves = $_POST['number_of_calves'];
        $totalMilkProduced = $_POST['total_milk_produced'];
        $notes = $_POST['notes'];

        // Insert into cows table
        $query = mysqli_query($con, "INSERT INTO cows (Name, Tag_Code, Breed, DOB, Category, Health_Status, Last_Vaccination, Last_Treatment, Breeding_Status, Last_Breeding_Date, Expected_Delivery_Date, Number_of_Calves, Total_Milk_Produced, Notes) 
                                     VALUES ('$name', '$tagCode', '$breed', '$dob', '$category', '$healthStatus', '$lastVaccination', '$lastTreatment', '$breedingStatus', '$lastBreedingDate', '$expectedDeliveryDate', '$numberOfCalves', '$totalMilkProduced', '$notes')");

        if ($query) {
            echo "<script>alert('Cow added successfully.');</script>";
            echo "<script>window.location.href='add-cow.php'</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
            echo "<script>window.location.href='add-cow.php'</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Add Cow</title>
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
                    <li class="breadcrumb-item"><a href="#">Cows</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Cow</li>
                </ol>
            </nav>

            <div class="container">
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add Cow</h4>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <form class="needs-validation" method="post" novalidate>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="name">Cow Name</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                                <div class="invalid-feedback">Please provide the cow's name.</div>
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="tag_code">Tag Code</label>
                                                <input type="text" class="form-control" id="tag_code" name="tag_code" required>
                                                <div class="invalid-feedback">Please provide a tag code.</div>
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
                                                <label for="category">Category</label>
                                                <select class="form-control" id="category" name="category" required>
                                                    <option value="">Select Category</option>
                                                    <option value="Lactating">Lactating</option>
                                                    <option value="Expectant">Expectant</option>
                                                    <option value="Delivered">Delivered</option>
                                                    <option value="Dry">Dry</option>
                                                    <option value="Young">Young</option>
                                                    <option value="Needing Breeding">Needing Breeding</option>
                                                </select>
                                                <div class="invalid-feedback">Please select a category.</div>
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="health_status">Health Status</label>
                                                <textarea class="form-control" id="health_status" name="health_status"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="last_vaccination">Last Vaccination Date</label>
                                                <input type="date" class="form-control" id="last_vaccination" name="last_vaccination">
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="last_treatment">Last Treatment</label>
                                                <textarea class="form-control" id="last_treatment" name="last_treatment"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="breeding_status">Breeding Status</label>
                                                <select class="form-control" id="breeding_status" name="breeding_status" required>
                                                    <option value="">Select Status</option>
                                                    <option value="Pregnant">Pregnant</option>
                                                    <option value="Ready for Breeding">Ready for Breeding</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                                <div class="invalid-feedback">Please select the breeding status.</div>
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="last_breeding_date">Last Breeding Date</label>
                                                <input type="date" class="form-control" id="last_breeding_date" name="last_breeding_date">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="expected_delivery_date">Expected Delivery Date</label>
                                                <input type="date" class="form-control" id="expected_delivery_date" name="expected_delivery_date">
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="number_of_calves">Number of Calves</label>
                                                <input type="number" class="form-control" id="number_of_calves" name="number_of_calves" min="0">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="total_milk_produced">Total Milk Produced (Liters)</label>
                                                <input type="number" class="form-control" id="total_milk_produced" name="total_milk_produced" step="0.01" min="0">
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="notes">Notes</label>
                                                <textarea class="form-control" id="notes" name="notes"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <button type="submit" name="submit" class="btn btn-primary">Add Cow</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendors/jquery/jquery-3.6.0.min.js"></script>
    <script src="dist/js/modernizr-3.6.0.min.js"></script>
    <script src="dist/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/script.js"></script>
</body>
</html>
