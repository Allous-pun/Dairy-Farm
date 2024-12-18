<?php
session_start();
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Fetch all feeding plans
    $filterAnimalType = isset($_GET['animal_type']) ? $_GET['animal_type'] : '';
    $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

    $query = "SELECT Feed_ID, Feed_Name, Feeding_Frequency, Animal_Type, Remarks FROM FeedManagement WHERE 1=1";

    // Apply animal type filter
    if (!empty($filterAnimalType)) {
        $query .= " AND Animal_Type = '$filterAnimalType'";
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
    <title>Feeding Plans</title>
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
                    <li class="breadcrumb-item"><a href="#">Feeding Plans</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Feeding Plans</li>
                </ol>
            </nav>

            <div class="container">
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="list"></i></span></span>All Feeding Plans</h4>
                </div>

                <!-- Filters and Search -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <form method="get">
                            <label for="animal_type">Filter by Animal Type</label>
                            <select class="form-control" id="animal_type" name="animal_type" onchange="this.form.submit()">
                                <option value="">All Animal Types</option>
                                <option value="Cows" <?= $filterAnimalType == 'Cows' ? 'selected' : '' ?>>Cows</option>
                                <option value="Bulls" <?= $filterAnimalType == 'Bulls' ? 'selected' : '' ?>>Bulls</option>
                                <option value="Heifers" <?= $filterAnimalType == 'Heifers' ? 'selected' : '' ?>>Heifers</option>
                                <option value="All" <?= $filterAnimalType == 'All' ? 'selected' : '' ?>>All</option>
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

                <!-- Feeding Plan Table -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <table id="feedingPlansTable" class="table table-hover w-100">
                                        <thead>
                                            <tr>
                                                <th>Feed Name</th>
                                                <th>Feeding Frequency</th>
                                                <th>Animal Type</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row['Feed_Name']) ?></td>
                                                    <td><?= htmlspecialchars($row['Feeding_Frequency']) ?></td>
                                                    <td><?= htmlspecialchars($row['Animal_Type']) ?></td>
                                                    <td><?= htmlspecialchars($row['Remarks']) ?></td>
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
            $('#feedingPlansTable').DataTable();
        });
    </script>
</body>
</html>
