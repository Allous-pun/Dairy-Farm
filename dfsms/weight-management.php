<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['aid']==0)) {
    header('location:logout.php');
} else {
    $rno = mt_rand(10000, 99999);  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Bulls Management</title>
    <!-- Data Table CSS -->
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <!-- Chart.js for Pie Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    
    <!-- HK Wrapper -->
    <div class="hk-wrapper hk-vertical-nav">

        <!-- Top Navbar -->
        <?php include_once('includes/navbar.php');
        include_once('includes/sidebar.php');
        ?>

        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <!-- Breadcrumb -->
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="#">Bulls</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Management</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">

                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="user"></i></span></span>Bulls Management</h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <!-- Table (Left Column) -->
                    <div class="col-xl-8">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap">
                                        <div class="hk-row mb-3">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="search_bull" placeholder="Search by name, breed, or category">
                                            </div>
                                        </div>
                                        <table id="datable_1" class="table table-hover w-100 display pb-30">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>Breed</th>
                                                    <th>DOB</th>
                                                    <th>Health Status</th>
                                                    <th>Location</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bull_table_body">
<?php
// Fetch bulls data from database
$query = mysqli_query($con, "SELECT * FROM bulls");
$cnt = 1;
while ($row = mysqli_fetch_array($query)) {
    $health_status = !empty($row['Health_Status']) ? $row['Health_Status'] : 'N/A';
?>
<tr>
    <td><?php echo $cnt; ?></td>
    <td><?php echo $row['Name']; ?></td>
    <td><?php echo $row['Category']; ?></td>
    <td><?php echo $row['Breed']; ?></td>
    <td><?php echo $row['DOB']; ?></td>
    <td><?php echo $health_status; ?></td>
    <td><?php echo $row['Location']; ?></td>
</tr>
<?php
$cnt++;
}
?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- /Table -->

                    <!-- Pie Chart (Right Column) -->
                    <div class="col-xl-4">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="pie-chart-container">
                                        <canvas id="breedingStatusChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- /Pie Chart -->

                </div>
                <!-- /Row -->

            </div>
            <!-- /Container -->

            <!-- Footer -->
            <?php include_once('includes/footer.php'); ?>
            <!-- /Footer -->
        </div>
        <!-- /Main Content -->
    </div>
    <!-- /HK Wrapper -->

    <!-- Scripts -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/dataTables-data.js"></script>
    <script src="dist/js/init.js"></script>

    <!-- Script to handle search functionality -->
    <script>
        $(document).ready(function() {
            $('#search_bull').on('input', function() {
                var searchValue = $(this).val().toLowerCase();
                $('#bull_table_body tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                });
            });
        });
    </script>

    <!-- Chart.js to create the Pie Chart -->
    <script>
        // Data for Breeding Status Pie Chart
        <?php
        $activeCount = 0;
        $inactiveCount = 0;
        $bullsQuery = mysqli_query($con, "SELECT * FROM bulls");

        while ($row = mysqli_fetch_array($bullsQuery)) {
            if ($row['Breeding_Status'] == 'Active') {
                $activeCount++;
            } else if ($row['Breeding_Status'] == 'Inactive') {
                $inactiveCount++;
            }
        }
        ?>

        var ctx = document.getElementById('breedingStatusChart').getContext('2d');
        var breedingStatusChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Active', 'Inactive'],
                datasets: [{
                    label: 'Breeding Status',
                    data: [<?php echo $activeCount; ?>, <?php echo $inactiveCount; ?>],
                    backgroundColor: ['#28a745', '#dc3545'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' bulls';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
<?php } ?>
