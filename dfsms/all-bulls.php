<?php
session_start();
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Fetch all bulls
    $filterCategory = isset($_GET['category']) ? $_GET['category'] : '';
    $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

    $query = "SELECT Bull_ID, Name, Category, Breed, Health_Status FROM bulls WHERE 1=1";

    // Apply category filter
    if (!empty($filterCategory)) {
        $query .= " AND Category = '$filterCategory'";
    }

    // Apply search filter
    if (!empty($searchKeyword)) {
        $query .= " AND (Name LIKE '%$searchKeyword%' OR Breed LIKE '%$searchKeyword%')";
    }

    $result = mysqli_query($con, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>All Bulls</title>
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <!-- Include Bootstrap CSS if not already included -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="hk-wrapper hk-vertical-nav">
        <?php include_once('includes/navbar.php'); include_once('includes/sidebar.php'); ?>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>

        <div class="hk-pg-wrapper">
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="#">Bulls</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Bulls</li>
                </ol>
            </nav>

            <div class="container">
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="list"></i></span></span>All Bulls</h4>
                </div>

                <!-- Filters and Search -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <form method="get">
                            <label for="category">Filter by Category</label>
                            <select class="form-control" id="category" name="category" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                <option value="Young" <?= $filterCategory == 'Young' ? 'selected' : '' ?>>Young</option>
                                <option value="Prime" <?= $filterCategory == 'Prime' ? 'selected' : '' ?>>Prime</option>
                                <option value="Old" <?= $filterCategory == 'Old' ? 'selected' : '' ?>>Old</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form method="get">
                            <label for="search">Search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Enter name or breed" value="<?= $searchKeyword ?>" />
                            <button type="submit" class="btn btn-primary mt-2">Search</button>
                        </form>
                    </div>
                </div>

                <!-- Bulls Table -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <table id="bullsTable" class="table table-hover w-100">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Breed</th>
                                                <th>Health Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                                <tr>
                                                    <td><?= $row['Bull_ID'] ?></td>
                                                    <td><?= htmlspecialchars($row['Name']) ?></td>
                                                    <td><?= htmlspecialchars($row['Category']) ?></td>
                                                    <td><?= htmlspecialchars($row['Breed']) ?></td>
                                                    <td><?= htmlspecialchars($row['Health_Status']) ?></td>
                                                    <td>
                                                        <a href="view-bull.php?id=<?= $row['Bull_ID'] ?>" class="btn btn-info btn-sm">View</a>
                                                        <a href="edit-bull.php?id=<?= $row['Bull_ID'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                        <a href="delete-bull.php?id=<?= $row['Bull_ID'] ?>" onclick="return confirm('Are you sure you want to delete this bull?')" class="btn btn-danger btn-sm">Remove</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

            <!-- Footer Section (Ensure it's at the bottom) -->
            <footer class="footer">
                <div class="container">
                    <span class="text-muted">© 2024 Dairy Farm Management. All Rights Reserved.</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- Include Bootstrap JS and necessary dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- DataTables JS -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#bullsTable').DataTable();
        });
    </script>
</body>
</html>
