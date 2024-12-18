<?php
session_start();
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Fetch all feeds
    $filterFeedType = isset($_GET['feed_type']) ? $_GET['feed_type'] : '';
    $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

    $query = "SELECT Feed_ID, Feed_Name, Feed_Type, Current_Stock, Stock_Unit, Minimum_Stock_Level FROM FeedManagement WHERE 1=1";

    // Apply feed type filter
    if (!empty($filterFeedType)) {
        $query .= " AND Feed_Type = '$filterFeedType'";
    }

    // Apply search filter
    if (!empty($searchKeyword)) {
        $query .= " AND (Feed_Name LIKE '%$searchKeyword%' OR Animal_Type LIKE '%$searchKeyword%')";
    }

    $result = mysqli_query($con, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>All Feeds</title>
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
                    <li class="breadcrumb-item"><a href="#">Feeds</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Feeds</li>
                </ol>
            </nav>

            <div class="container">
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="list"></i></span></span>All Feeds</h4>
                </div>

                <!-- Filters and Search -->
                <div class="row mb-3">
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <form method="get">
                            <label for="search">Search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Enter feed name or animal type" value="<?= $searchKeyword ?>" />
                            <button type="submit" class="btn btn-primary mt-2">Search</button>
                        </form>
                    </div>
                </div>

                <!-- Feeds Table -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <table id="feedsTable" class="table table-hover w-100">
                                        <thead>
                                            <tr>
                                                <th>Feed Name</th>
                                                <th>Current Stock</th>
                                                <th>Stock Unit</th>
                                                <th>Minimum Stock Level</th>
                                                <th>Stock Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_assoc($result)) { 
                                                // Check if stock is low
                                                $stockStatus = ($row['Current_Stock'] < $row['Minimum_Stock_Level']) ? '<span class="badge badge-danger">Low Stock</span>' : '<span class="badge badge-success">Sufficient Stock</span>';
                                            ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row['Feed_Name']) ?></td>
                                                    <td><?= htmlspecialchars($row['Current_Stock']) ?> <?= htmlspecialchars($row['Stock_Unit']) ?></td>
                                                    <td><?= htmlspecialchars($row['Stock_Unit']) ?></td>
                                                    <td><?= htmlspecialchars($row['Minimum_Stock_Level']) ?> <?= htmlspecialchars($row['Stock_Unit']) ?></td>
                                                    <td><?= $stockStatus ?></td>
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
            $('#feedsTable').DataTable();
        });
    </script>
</body>
</html>
