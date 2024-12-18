<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Milk Production</title>
    <!-- Data Table CSS -->
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <script src="vendors/chart.js/Chart.min.js"></script>

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
                    <li class="breadcrumb-item active" aria-current="page">Milk Production</li>
                </ol>
            </nav>

            <div class="container">
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title">
                        <span class="pg-title-icon">
                            <span class="feather-icon">
                                <i data-feather="bar-chart-2"></i>
                            </span>
                        </span>
                        Milk Production
                    </h4>
                </div>

                <div class="row">
                    <!-- Table Section -->
                    <div class="col-xl-6">
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Milk Production Data</h5>
                            <div class="table-wrap">
                                <table id="datable_1" class="table table-hover w-100 display pb-30">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cow Name</th>
                                            <th>Tag Code</th>
                                            <th>Breed</th>
                                            <th>Total Milk Produced (Liters)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($con, "SELECT Name, Tag_Code, Breed, Total_Milk_Produced FROM cows");
                                        $cnt = 1;
                                        $cowNames = [];
                                        $milkData = [];
                                        while ($row = mysqli_fetch_array($query)) {
                                            $cowNames[] = $row['Name'];
                                            $milkData[] = $row['Total_Milk_Produced'];
                                        ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo $row['Name']; ?></td>
                                            <td><?php echo $row['Tag_Code']; ?></td>
                                            <td><?php echo $row['Breed']; ?></td>
                                            <td><?php echo $row['Total_Milk_Produced']; ?></td>
                                        </tr>
                                        <?php $cnt++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>

                    <!-- Graph Section -->
                    <div class="col-xl-6">
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Milk Production Graph</h5>
                            <canvas id="milkProductionChart" style="height: 300px;"></canvas>
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
    <script src="vendors/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="dist/js/init.js"></script>

    <script>
        // Chart Data
        const cowNames = <?php echo json_encode($cowNames); ?>;
        const milkData = <?php echo json_encode($milkData); ?>;

        const ctx = document.getElementById('milkProductionChart').getContext('2d');
        const milkProductionChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: cowNames,
                datasets: [{
                    label: 'Milk Produced (Liters)',
                    data: milkData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
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
