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
    <title>Calf Management</title>
    <!-- Data Table CSS -->
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <li class="breadcrumb-item active" aria-current="page">Calf Management</li>
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
                        Calf Management
                    </h4>
                </div>

                <div class="row">
                    <!-- Table Section -->
                    <div class="col-12">
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Cows and Calves</h5>
                            <div class="table-wrap">
                                <table id="datable_1" class="table table-hover w-100 display pb-30">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cow Name</th>
                                            <th>Tag Code</th>
                                            <th>Breed</th>
                                            <th>Number of Calves</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query to fetch cows details including the number of calves
                                        $query = mysqli_query($con, "SELECT Name, Tag_Code, Breed, Number_of_Calves FROM cows");
                                        $cnt = 1;
                                        $calfCounts = []; // Store counts of cows based on the number of calves
                                        while ($row = mysqli_fetch_array($query)) {
                                            $numOfCalves = $row['Number_of_Calves'];
                                            
                                            // Track number of cows for each calf count
                                            if (isset($calfCounts[$numOfCalves])) {
                                                $calfCounts[$numOfCalves]++;
                                            } else {
                                                $calfCounts[$numOfCalves] = 1;
                                            }
                                        ?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo $row['Name']; ?></td>
                                                <td><?php echo $row['Tag_Code']; ?></td>
                                                <td><?php echo $row['Breed']; ?></td>
                                                <td><?php echo $row['Number_of_Calves']; ?></td>
                                            </tr>
                                        <?php $cnt++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <!-- Bar Graph Section -->
                    <div class="col-md-6">
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Number of Calves Distribution</h5>
                            <canvas id="calfBarChart" style="height: 300px;"></canvas>
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

        // Bar Graph Data for Number of Calves
        const calfData = {
            labels: <?php echo json_encode(array_keys($calfCounts)); ?>,
            datasets: [{
                label: 'Number of Cows',
                data: <?php echo json_encode(array_values($calfCounts)); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        const ctx2 = document.getElementById('calfBarChart').getContext('2d');
        const calfBarChart = new Chart(ctx2, {
            type: 'bar',
            data: calfData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>

<?php } ?>
