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
    <title>Cow Health Records</title>
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
                    <li class="breadcrumb-item active" aria-current="page">Cow Health Records</li>
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
                        Cow Health Records
                    </h4>
                </div>

                <div class="row">
                    <!-- Table Section -->
                    <div class="col-12">
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Health Records</h5>
                            <div class="table-wrap">
                                <table id="datable_1" class="table table-hover w-100 display pb-30">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cow Name</th>
                                            <th>Breed</th>
                                            <th>Last Treatment</th>
                                            <th>Last Vaccination</th>
                                            <th>Health Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($con, "SELECT Name, Breed, Last_Treatment, Last_Vaccination, Health_Status FROM cows");
                                        $cnt = 1;
                                        $healthy = 0;
                                        $unhealthy = 0;
                                        $healthCounts = []; // Store counts for bar chart
                                        while ($row = mysqli_fetch_array($query)) {
                                            $status = ucfirst(trim($row['Health_Status']));
                                            $healthCounts[$status] = ($healthCounts[$status] ?? 0) + 1;
                                            if (strtolower($status) === 'healthy') {
                                                $healthy++;
                                            } else {
                                                $unhealthy++;
                                            }
                                        ?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo $row['Name']; ?></td>
                                                <td><?php echo $row['Breed']; ?></td>
                                                <td><?php echo $row['Last_Treatment']; ?></td>
                                                <td><?php echo $row['Last_Vaccination']; ?></td>
                                                <td><?php echo $status; ?></td>
                                            </tr>
                                        <?php $cnt++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <!-- Pie Chart Section -->
                    <div class="col-md-6">
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Health Status Pie Chart</h5>
                            <canvas id="healthStatusChart" style="height: 300px;"></canvas>
                        </section>
                    </div>

                    <!-- Bar Graph Section -->
                    <div class="col-md-6">
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Health Status Distribution</h5>
                            <canvas id="healthBarChart" style="height: 300px;"></canvas>
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

        // Chart Data
        const healthData = {
            labels: ['Healthy', 'Unhealthy'],
            datasets: [{
                data: [<?php echo $healthy; ?>, <?php echo $unhealthy; ?>],
                backgroundColor: ['rgba(75, 192, 75, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                borderColor: ['rgba(75, 192, 75, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        };

        const ctx1 = document.getElementById('healthStatusChart').getContext('2d');
        const healthStatusChart = new Chart(ctx1, {
            type: 'pie',
            data: healthData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });

        // Bar Graph Data
        const healthBarData = {
            labels: <?php echo json_encode(array_keys($healthCounts)); ?>,
            datasets: [{
                label: 'Number of Cows',
                data: <?php echo json_encode(array_values($healthCounts)); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        const ctx2 = document.getElementById('healthBarChart').getContext('2d');
        const healthBarChart = new Chart(ctx2, {
            type: 'bar',
            data: healthBarData,
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
