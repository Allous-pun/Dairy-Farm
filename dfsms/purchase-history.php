<?php
session_start();
include('includes/config.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (strlen($_SESSION['aid']) == 0) {
    header('location:logout.php');
    exit();
} else {
    // Filters and Parameters
    $filterFeedType = isset($_GET['feed_type']) ? $_GET['feed_type'] : '';
    $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

    // Query to fetch feed management data
    $query = "SELECT Feed_Name, Feed_Type, Last_Purchase_Date, Current_Stock, Cost_Per_Unit 
              FROM FeedManagement 
              WHERE 1=1";

    // Apply filters
    if (!empty($filterFeedType)) {
        $query .= " AND Feed_Type = '" . mysqli_real_escape_string($con, $filterFeedType) . "'";
    }
    if (!empty($searchKeyword)) {
        $query .= " AND (Feed_Name LIKE '%" . mysqli_real_escape_string($con, $searchKeyword) . "%' 
                       OR Feed_Type LIKE '%" . mysqli_real_escape_string($con, $searchKeyword) . "%')";
    }
    if (!empty($startDate) && !empty($endDate)) {
        $query .= " AND Last_Purchase_Date BETWEEN '" . mysqli_real_escape_string($con, $startDate) . "' 
                                         AND '" . mysqli_real_escape_string($con, $endDate) . "'";
    }

    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed Management</title>
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="hk-wrapper hk-vertical-nav">
        <!-- Include Navbar -->
        <?php include_once('includes/navbar.php'); include_once('includes/sidebar.php'); ?>

        <!-- Sidebar -->
       
        <!-- Content Wrapper -->
        <div class="hk-pg-wrapper">
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="#">Cost Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Feed Management</li>
                </ol>
            </nav>

            <div class="container">
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title">
                        <span class="pg-title-icon">
                            <span class="feather-icon"><i data-feather="list"></i></span>
                        </span>
                        Feed Management
                    </h4>
                </div>

                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <form method="get">
                            <label for="feed_type">Filter by Feed Type</label>
                            <select class="form-control" id="feed_type" name="feed_type" onchange="this.form.submit()">
                                <option value="">All Feed Types</option>
                                <option value="Forage" <?= $filterFeedType == 'Forage' ? 'selected' : '' ?>>Forage</option>
                                <option value="Grain" <?= $filterFeedType == 'Grain' ? 'selected' : '' ?>>Grain</option>
                                <option value="Supplements" <?= $filterFeedType == 'Supplements' ? 'selected' : '' ?>>Supplements</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form method="get">
                            <label for="search">Search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Enter feed name or type" value="<?= htmlspecialchars($searchKeyword) ?>" />
                            <button type="submit" class="btn btn-primary mt-2">Search</button>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form method="get">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= htmlspecialchars($startDate) ?>" />
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form method="get">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= htmlspecialchars($endDate) ?>" />
                            <button type="submit" class="btn btn-primary mt-2">Apply</button>
                        </form>
                    </div>
                </div>

                <!-- Table for Feed Management -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Feed Management Log</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="feedManagementTable">
                                    <thead>
                                        <tr>
                                            <th>Feed Name</th>
                                            <th>Feed Type</th>
                                            <th>Last Purchase Date</th>
                                            <th>Current Stock</th>
                                            <th>Cost Per Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result && mysqli_num_rows($result) > 0): ?>
                                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row['Feed_Name']) ?></td>
                                                    <td><?= htmlspecialchars($row['Feed_Type']) ?></td>
                                                    <td><?= htmlspecialchars($row['Last_Purchase_Date']) ?></td>
                                                    <td><?= htmlspecialchars($row['Current_Stock']) ?></td>
                                                    <td><?= number_format($row['Cost_Per_Unit'], 2) ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5">No records found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="container">
                    <span class="text-muted">© 2024 Dairy Farm Management. All Rights Reserved.</span>
                </div>
            </footer>
        </div>
    </div>

    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script>
        // Initialize DataTable
        $(document).ready(function () {
            $('#feedManagementTable').DataTable();
        });

        // Initialize Feather icons
        feather.replace();
    </script>
</body>
</html>
