<?php
session_start();
//error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['aid']==0)) {
  header('location:logout.php');
  } else{ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Dashboard</title>
    <link href="vendors/vectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" type="text/css" />
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">

    <style>
        .hk-pg-wrapper {
            margin-left: 300px; /* Pushes the content to the right to avoid overlap with the sidebar */
            padding: 20px; /* Adds spacing inside the content area */
            background-color: #f8f9fa; /* Light gray background for contrast */
            min-height: 100vh; /* Ensures the content area covers the full viewport */
            transition: margin-left 0.3s ease; /* Smooth transition for responsiveness */
            margin-top: 40px !important;
        }

    </style>
</head>

<body>
    
	
	<!-- HK Wrapper -->
	<div class="hk-wrapper hk-vertical-nav">

<?php include_once('includes/navbar.php');
include_once('includes/sidebar.php');
?>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->
        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container-fluid mt-xl-50 mt-sm-30 mt-15">
                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hk-row">

<?php
$query=mysqli_query($con,"select id from tblcategory");
$listedcat=mysqli_num_rows($query);
?>

<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Categories</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo $listedcat;?></span>
<small class="d-block">Listed Categories</small>
</div>
</div>
</div>
</div>
							

<?php
$ret=mysqli_query($con,"select id from tblcompany");
$listedcomp=mysqli_num_rows($ret);
?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Companies</span>
</div>
<div>
</div>
</div>

<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo $listedcomp;?></span></span>
<small class="d-block">Listed Companies</small>
</div>
</div>
</div>
</div>
							
<?php
$sql=mysqli_query($con,"select id from tblproducts");
$listedproduct=mysqli_num_rows($sql);
?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Products</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo $listedproduct;?></span>
<small class="d-block">Listed Products</small>
</div>
</div>
</div>
</div>
<?php
$query=mysqli_query($con,"select sum(tblorders.Quantity*tblproducts.ProductPrice) as tt  from tblorders join tblproducts on tblproducts.id=tblorders.ProductId ");
$row=mysqli_fetch_array($query);
?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Total Sales</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo number_format($row['tt'],2);?></span>
<small class="d-block">Total sales till date</small>
</div>
</div>
</div>
</div>	

<?php
$qury=mysqli_query($con,"select sum(tblorders.Quantity*tblproducts.ProductPrice) as tt  from tblorders join tblproducts on tblproducts.id=tblorders.ProductId where date(tblorders.InvoiceGenDate)>=(DATE(NOW()) - INTERVAL 7 DAY)");
$row=mysqli_fetch_array($qury);
?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Last 7 Days Sales</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo number_format($row['tt'],2);?></span>
<small class="d-block">Last 7 Days Total Sales</small>
</div>
</div>
</div>
</div>

<?php
$qurys=mysqli_query($con,"select sum(tblorders.Quantity*tblproducts.ProductPrice) as tt  from tblorders join tblproducts on tblproducts.id=tblorders.ProductId where date(tblorders.InvoiceGenDate)=CURDATE()-1");
$rw=mysqli_fetch_array($qurys);
?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Yesterday Sales</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo number_format($rw['tt'],2);?></span>
<small class="d-block">Yesterday Total Sales</small>
</div>
</div>
</div>
</div>

<?php
$quryss=mysqli_query($con,"select sum(tblorders.Quantity*tblproducts.ProductPrice) as tt  from tblorders join tblproducts on tblproducts.id=tblorders.ProductId where date(tblorders.InvoiceGenDate)=CURDATE()");
$rws=mysqli_fetch_array($quryss);
?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Today's Sales</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo number_format($rws['tt'],2);?></span>
<small class="d-block">Today's Total Sales</small>
</div>
</div>
</div>
</div>


<?php
// Herd Managers
$herdManagersQuery = mysqli_query($con, "SELECT COUNT(id) AS totalManagers, SUM(LENGTH(AssignedHerd) - LENGTH(REPLACE(AssignedHerd, ',', '')) + 1) AS totalAnimals FROM tblherd_managers");
$herdManagersData = mysqli_fetch_array($herdManagersQuery);

// Health Managers
$healthManagersQuery = mysqli_query($con, "SELECT COUNT(id) AS totalManagers, SUM(LENGTH(AssignedAnimals) - LENGTH(REPLACE(AssignedAnimals, ',', '')) + 1) AS totalAnimals FROM tblhealth_managers");
$healthManagersData = mysqli_fetch_array($healthManagersQuery);

// Fertility Managers
$fertilityManagersQuery = mysqli_query($con, "SELECT COUNT(id) AS totalManagers, SUM(LENGTH(AssignedAnimals) - LENGTH(REPLACE(AssignedAnimals, ',', '')) + 1) AS totalAnimals FROM tblfertility_managers");
$fertilityManagersData = mysqli_fetch_array($fertilityManagersQuery);

// Milk & Weight Managers
$milkWeightManagersQuery = mysqli_query($con, "SELECT COUNT(id) AS totalManagers, SUM(LENGTH(AssignedAnimals) - LENGTH(REPLACE(AssignedAnimals, ',', '')) + 1) AS totalAnimals FROM tblmilk_weight_managers");
$milkWeightManagersData = mysqli_fetch_array($milkWeightManagersQuery);
?>

<div class="col-lg-3 col-md-6">
    <div class="card card-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-5">
                <div>
                    <i class="feather icon-users text-primary"></i> <!-- Icon for Herd Managers -->
                    <span class="d-block font-15 text-dark font-weight-500">Herd Managers</span>
                </div>
            </div>
            <div class="text-center">
                <span class="d-block display-4 text-dark mb-5"><?php echo $herdManagersData['totalManagers']; ?></span>
                <small class="d-block">Total Managers</small>
                <span class="d-block"><?php echo $herdManagersData['totalAnimals']; ?> Animals Managed</span>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="card card-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-5">
                <div>
                    <i class="feather icon-heart text-success"></i> <!-- Icon for Health Managers -->
                    <span class="d-block font-15 text-dark font-weight-500">Health Managers</span>
                </div>
            </div>
            <div class="text-center">
                <span class="d-block display-4 text-dark mb-5"><?php echo $healthManagersData['totalManagers']; ?></span>
                <small class="d-block">Total Managers</small>
                <span class="d-block"><?php echo $healthManagersData['totalAnimals']; ?> Animals Monitored</span>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="card card-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-5">
                <div>
                    <i class="feather icon-activity text-warning"></i> <!-- Icon for Fertility Managers -->
                    <span class="d-block font-15 text-dark font-weight-500">Fertility Managers</span>
                </div>
            </div>
            <div class="text-center">
                <span class="d-block display-4 text-dark mb-5"><?php echo $fertilityManagersData['totalManagers']; ?></span>
                <small class="d-block">Total Managers</small>
                <span class="d-block"><?php echo $fertilityManagersData['totalAnimals']; ?> Animals Monitored</span>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="card card-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-5">
                <div>
                    <i class="feather icon-bar-chart-2 text-danger"></i> <!-- Icon for Milk & Weight Managers -->
                    <span class="d-block font-15 text-dark font-weight-500">Milk & Weight Managers</span>
                </div>
            </div>
            <div class="text-center">
                <span class="d-block display-4 text-dark mb-5"><?php echo $milkWeightManagersData['totalManagers']; ?></span>
                <small class="d-block">Total Managers</small>
                <span class="d-block"><?php echo $milkWeightManagersData['totalAnimals']; ?> Animals Monitored</span>
            </div>
        </div>
    </div>
</div>


<?php
// Cows
$cowsQuery = mysqli_query($con, "SELECT COUNT(Cow_ID) AS totalCows FROM cows");
$cowsData = mysqli_fetch_array($cowsQuery);

// Bulls
$bullsQuery = mysqli_query($con, "SELECT COUNT(Bull_ID) AS totalBulls FROM bulls");
$bullsData = mysqli_fetch_array($bullsQuery);

// Healthy Cows
$healthyCowsQuery = mysqli_query($con, "SELECT COUNT(Cow_ID) AS totalHealthyCows FROM cows WHERE Health_Status = 'Healthy'");
$healthyCowsData = mysqli_fetch_array($healthyCowsQuery);

// Healthy Bulls
$healthyBullsQuery = mysqli_query($con, "SELECT COUNT(Bull_ID) AS totalHealthyBulls FROM bulls WHERE Health_Status = 'Healthy'");
$healthyBullsData = mysqli_fetch_array($healthyBullsQuery);

// Heifers
$heifersQuery = mysqli_query($con, "SELECT COUNT(Cow_ID) AS totalHeifers FROM cows WHERE Category = 'Young'");
$heifersData = mysqli_fetch_array($heifersQuery);

// Lactating Cows
$lactatingCowsQuery = mysqli_query($con, "SELECT COUNT(Cow_ID) AS totalLactatingCows FROM cows WHERE Category = 'Lactating'");
$lactatingCowsData = mysqli_fetch_array($lactatingCowsQuery);
?>

<div class="col-lg-3 col-md-6">
    <div class="card card-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-5">
                <div>
                    <i class="fa fa-github-alt"></i> <!-- Icon for Cows -->
                    <span class="d-block font-15 text-dark font-weight-500">All Cows</span>
                </div>
            </div>
            <div class="text-center">
                <span class="d-block display-4 text-dark mb-5"><?php echo $cowsData['totalCows']; ?></span>
                <small class="d-block">Total Cows</small>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="card card-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-5">
                <div>
                    <i class="fa fa-mars-stroke"></i><!-- Icon for Bulls -->
                    <span class="d-block font-15 text-dark font-weight-500">All Bulls</span>
                </div>
            </div>
            <div class="text-center">
                <span class="d-block display-4 text-dark mb-5"><?php echo $bullsData['totalBulls']; ?></span>
                <small class="d-block">Total Bulls</small>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="card card-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-5">
                <div>
                    <i class="feather icon-heart text-success"></i> <!-- Icon for Healthy Cows -->
                    <span class="d-block font-15 text-dark font-weight-500">Healthy Cows</span>
                </div>
            </div>
            <div class="text-center">
                <span class="d-block display-4 text-dark mb-5"><?php echo $healthyCowsData['totalHealthyCows']; ?></span>
                <small class="d-block">Healthy Cows</small>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="card card-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-5">
                <div>
                    <i class="fa fa-mars-stroke"></i> <!-- Icon for Healthy Bulls -->
                    <span class="d-block font-15 text-dark font-weight-500">Healthy Bulls</span>
                </div>
            </div>
            <div class="text-center">
                <span class="d-block display-4 text-dark mb-5"><?php echo $healthyBullsData['totalHealthyBulls']; ?></span>
                <small class="d-block">Healthy Bulls</small>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="card card-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-5">
                <div>
                    <i class="fa fa-github-alt"></i> <!-- Icon for Heifers -->
                    <span class="d-block font-15 text-dark font-weight-500">Heifers</span>
                </div>
            </div>
            <div class="text-center">
                <span class="d-block display-4 text-dark mb-5"><?php echo $heifersData['totalHeifers']; ?></span>
                <small class="d-block">Total Heifers</small>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="card card-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-5">
                <div>
                    <i class="fa fa-github-alt"></i> <!-- Icon for Lactating Cows -->
                    <span class="d-block font-15 text-dark font-weight-500">Lactating Cows</span>
                </div>
            </div>
            <div class="text-center">
                <span class="d-block display-4 text-dark mb-5"><?php echo $lactatingCowsData['totalLactatingCows']; ?></span>
                <small class="d-block">Lactating Cows</small>
            </div>
        </div>
    </div>
</div>






</div>
					
            </div>
            <!-- /Container -->
			
            <!-- Footer -->
<?php include_once('includes/footer.php');?>
            <!-- /Footer -->
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="vendors/jquery-toggles/toggles.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
	<script src="vendors/waypoints/lib/jquery.waypoints.min.js"></script>
	<script src="vendors/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
    <script src="vendors/vectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="vendors/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="dist/js/vectormap-data.js"></script>
    <script src="vendors/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
    <script src="vendors/apexcharts/dist/apexcharts.min.js"></script>
	<script src="dist/js/irregular-data-series.js"></script>
    <script src="dist/js/init.js"></script>
	
</body>

</html>
<?php } ?>