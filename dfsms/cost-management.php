<?php
session_start();
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['aid']) == 0) {
    header('location:logout.php');
    exit();
} else {
    // Filters and Parameters
    $filterFeedType = isset($_GET['feed_type']) ? $_GET['feed_type'] : '';
    $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
    $timePeriod = isset($_GET['time_period']) ? $_GET['time_period'] : 'monthly'; // Default to monthly

    // Query to fetch feed data
    $query = "SELECT Feed_Type, SUM(Current_Stock * Cost_Per_Unit) AS Total_Cost 
              FROM FeedManagement 
              WHERE 1=1";

    // Apply filters
    if (!empty($filterFeedType)) {
        $query .= " AND Feed_Type = '$filterFeedType'";
    }
    if (!empty($searchKeyword)) {
        $query .= " AND (Feed_Name LIKE '%$searchKeyword%' OR Animal_Type LIKE '%$searchKeyword%')";
    }
    $query .= " GROUP BY Feed_Type";

    $result = mysqli_query($con, $query);

    // Prepare data for the chart
    $feedTypes = [];
    $feedCosts = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $feedTypes[] = $row['Feed_Type'];
            $feedCosts[] = $row['Total_Cost'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cost Management</title>
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="hk-wrapper hk-vertical-nav">
        <?php include_once('includes/navbar.php'); include_once('includes/sidebar.php'); ?>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>

        <div class="hk-pg-wrapper">
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="#">Cost Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Feed Costs</li>
                </ol>
            </nav>

            <div class="container">
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="list"></i></span></span>Feed Cost Management</h4>
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
                    <div class="col-md-4">
                        <form method="get">
                            <label for="time_period">Select Time Period</label>
                            <select class="form-control" id="time_period" name="time_period" onchange="this.form.submit()">
                                <option value="monthly" <?= $timePeriod == 'monthly' ? 'selected' : '' ?>>Monthly</option>
                                <option value="yearly" <?= $timePeriod == 'yearly' ? 'selected' : '' ?>>Yearly</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Pie Chart for Feed Costs -->
                <div class="row">
                    <div class="col-xl-12">
                    <div class="row">
    <div class="col-xl-12">
        <!-- Table for Feed Data -->
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Feed Data Overview</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="feedsTable">
                    <thead>
                        <tr>
                            <th>Feed Type</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && mysqli_num_rows($result) > 0): ?>
                            <?php 
                            // Reset result pointer to fetch data for table
                            mysqli_data_seek($result, 0);
                            while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['Feed_Type']) ?></td>
                                    <td><?= number_format($row['Total_Cost'], 2) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Feed Cost Distribution (<?= ucfirst($timePeriod) ?>)</h5>
                            <canvas id="costPieChart"></canvas>
                        </section>
                    </div>
                </div>
            </div>

            <!-- Footer Section -->
            <footer class="footer">
                <div class="container">
                    <span class="text-muted">© 2024 Dairy Farm Management. All Rights Reserved.</span>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>

    <script>
        // Initialize DataTables
        $(document).ready(function () {
            $('#feedsTable').DataTable();
        });

        // Pie Chart for Feed Costs
        var ctx = document.getElementById('costPieChart').getContext('2d');
        var costPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?= json_encode($feedTypes) ?>,
                datasets: [{
                    data: <?= json_encode($feedCosts) ?>,
                    backgroundColor: ['#FF5733', '#33FF57', '#3357FF'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });
    </script>
</body>
</html>
