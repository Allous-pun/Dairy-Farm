<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['aid']) == 0) {
    header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Category Management</title>
    <!-- Data Table CSS -->
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="hk-wrapper hk-vertical-nav">
        <!-- Top Navbar -->
        <?php include_once('includes/navbar.php'); include_once('includes/sidebar.php'); ?>

        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="#">Cows</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Category Management</li>
                </ol>
            </nav>

            <div class="container">
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title">
                        <span class="pg-title-icon">
                            <span class="feather-icon">
                                <i data-feather="activity"></i>
                            </span>
                        </span>
                        Category Management
                    </h4>
                </div>

                <!-- Add Category Section -->
                <div class="row">
                    <div class="col-12">
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Add New Category</h5>
                            <button class="btn btn-primary" id="addCategoryBtn">Add Category</button>
                            <div id="addCategoryDropdown" style="display: none; margin-top: 10px;">
                                <form method="POST" action="category-management.php">
                                    <input type="text" name="newCategory" class="form-control" placeholder="Enter new category" required />
                                    <button type="submit" name="addCategory" class="btn btn-success" style="margin-top: 10px;">Add</button>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="row">
                    <div class="col-12">
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Category Records</h5>
                            <div class="table-wrap">
                                <table id="datable_1" class="table table-hover w-100 display pb-30">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cow Name</th>
                                            <th>Tag Code</th>
                                            <th>Category</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch cows and their categories from the database
                                        $query = mysqli_query($con, "SELECT Cow_ID, Name, Tag_Code, Category FROM cows");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo $row['Name']; ?></td>
                                                <td><?php echo $row['Tag_Code']; ?></td>
                                                <td><?php echo $row['Category']; ?></td>
                                                <td>
                                                    <a href="edit-category.php?id=<?php echo $row['Cow_ID']; ?>" class="btn btn-warning">Edit</a>
                                                    <a href="category-management.php?delete=<?php echo $row['Cow_ID']; ?>" class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        <?php $cnt++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="dist/js/init.js"></script>

    <script>
        // Initialize DataTable with Search and Pagination
        $(document).ready(function() {
            $('#datable_1').DataTable();
        });

        // Toggle the category dropdown visibility
        document.getElementById("addCategoryBtn").addEventListener("click", function() {
            var dropdown = document.getElementById("addCategoryDropdown");
            dropdown.style.display = (dropdown.style.display === "none" || dropdown.style.display === "") ? "block" : "none";
        });
    </script>
</body>

</html>

<?php
// Add new category to cows table
if (isset($_POST['addCategory'])) {
    $newCategory = mysqli_real_escape_string($con, $_POST['newCategory']);
    
    // Check if the category already exists
    $checkQuery = "SHOW COLUMNS FROM cows LIKE 'Category'";
    $result = mysqli_query($con, $checkQuery);
    $row = mysqli_fetch_array($result);
    $enum_values = $row['Type'];

    // Update enum to include new category if it doesn't exist
    if (strpos($enum_values, "'$newCategory'") === false) {
        $query = "ALTER TABLE cows CHANGE COLUMN Category Category ENUM($enum_values, '$newCategory') NOT NULL";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Category added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding category!');</script>";
        }
    } else {
        echo "<script>alert('Category already exists!');</script>";
    }
}

// Delete category from cows table
if (isset($_GET['delete'])) {
    $cowId = $_GET['delete'];
    $query = "UPDATE cows SET Category='Needing Breeding' WHERE Cow_ID = '$cowId'";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Category deleted successfully!'); window.location='category-management.php';</script>";
    } else {
        echo "<script>alert('Error deleting category!'); window.location='category-management.php';</script>";
    }
}
?>

<?php } ?>
