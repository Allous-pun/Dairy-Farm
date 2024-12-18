<?php
session_start();
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Add Feed Code
    if (isset($_POST['submit'])) {
        // Getting Post Values
        $feedName = $_POST['feed_name'];
        $feedType = $_POST['feed_type'];
        $nutritionalComposition = $_POST['nutritional_composition'];
        $currentStock = $_POST['current_stock'];
        $stockUnit = $_POST['stock_unit'];
        $minimumStockLevel = $_POST['minimum_stock_level'];
        $costPerUnit = $_POST['cost_per_unit'];
        $supplierName = $_POST['supplier_name'];
        $lastPurchaseDate = $_POST['last_purchase_date'];
        $quantityPerDay = $_POST['quantity_per_day'];
        $feedingFrequency = $_POST['feeding_frequency'];
        $animalType = $_POST['animal_type'];
        $remarks = $_POST['remarks'];

        // Insert into FeedManagement table
        $query = mysqli_query($con, "INSERT INTO FeedManagement (Feed_Name, Feed_Type, Nutritional_Composition, Current_Stock, Stock_Unit, Minimum_Stock_Level, Cost_Per_Unit, Supplier_Name, Last_Purchase_Date, Quantity_Per_Day, Feeding_Frequency, Animal_Type, Remarks) 
                                     VALUES ('$feedName', '$feedType', '$nutritionalComposition', '$currentStock', '$stockUnit', '$minimumStockLevel', '$costPerUnit', '$supplierName', '$lastPurchaseDate', '$quantityPerDay', '$feedingFrequency', '$animalType', '$remarks')");

        if ($query) {
            echo "<script>alert('Feed added successfully.');</script>";
            echo "<script>window.location.href='add-feed.php'</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
            echo "<script>window.location.href='add-feed.php'</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Add Feed</title>
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
                    <li class="breadcrumb-item"><a href="#">Feed Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Feed</li>
                </ol>
            </nav>

            <div class="container">
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add Feed</h4>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <form class="needs-validation" method="post" novalidate>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="feed_name">Feed Name</label>
                                                <input type="text" class="form-control" id="feed_name" name="feed_name" required>
                                                <div class="invalid-feedback">Please provide the feed name.</div>
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="feed_type">Feed Type</label>
                                                <select class="form-control" id="feed_type" name="feed_type" required>
                                                    <option value="">Select Feed Type</option>
                                                    <option value="Forage">Forage</option>
                                                    <option value="Grain">Grain</option>
                                                    <option value="Supplements">Supplements</option>
                                                </select>
                                                <div class="invalid-feedback">Please select the feed type.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="nutritional_composition">Nutritional Composition</label>
                                                <textarea class="form-control" id="nutritional_composition" name="nutritional_composition"></textarea>
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="current_stock">Current Stock</label>
                                                <input type="number" class="form-control" id="current_stock" name="current_stock" required>
                                                <div class="invalid-feedback">Please provide the current stock.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="stock_unit">Stock Unit</label>
                                                <select class="form-control" id="stock_unit" name="stock_unit" required>
                                                    <option value="">Select Unit</option>
                                                    <option value="kg">kg</option>
                                                    <option value="bags">bags</option>
                                                    <option value="liters">liters</option>
                                                </select>
                                                <div class="invalid-feedback">Please select the stock unit.</div>
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="minimum_stock_level">Minimum Stock Level</label>
                                                <input type="number" class="form-control" id="minimum_stock_level" name="minimum_stock_level" required>
                                                <div class="invalid-feedback">Please provide the minimum stock level.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="cost_per_unit">Cost Per Unit</label>
                                                <input type="number" class="form-control" id="cost_per_unit" name="cost_per_unit" required>
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="supplier_name">Supplier Name</label>
                                                <input type="text" class="form-control" id="supplier_name" name="supplier_name">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="last_purchase_date">Last Purchase Date</label>
                                                <input type="date" class="form-control" id="last_purchase_date" name="last_purchase_date">
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="quantity_per_day">Quantity Per Day</label>
                                                <input type="number" class="form-control" id="quantity_per_day" name="quantity_per_day" required>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="feeding_frequency">Feeding Frequency</label>
                                                <select class="form-control" id="feeding_frequency" name="feeding_frequency" required>
                                                    <option value="">Select Frequency</option>
                                                    <option value="Once">Once</option>
                                                    <option value="Twice">Twice</option>
                                                    <option value="Thrice">Thrice daily</option>
                                                </select>
                                                <div class="invalid-feedback">Please select the feeding frequency.</div>
                                            </div>
                                            <div class="col-md-6 mb-10">
                                                <label for="animal_type">Animal Type</label>
                                                <select class="form-control" id="animal_type" name="animal_type" required>
                                                    <option value="">Select Animal Type</option>
                                                    <option value="Cows">Cows</option>
                                                    <option value="Bulls">Bulls</option>
                                                    <option value="Heifers">Heifers</option>
                                                    <option value="All">All</option>
                                                </select>
                                                <div class="invalid-feedback">Please select the animal type.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="remarks">Remarks</label>
                                                <textarea class="form-control" id="remarks" name="remarks"></textarea>
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
            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>

    <script src="vendors/jquery/jquery.min.js"></script>
    <script src="dist/js/main.js"></script>
</body>
</html>
