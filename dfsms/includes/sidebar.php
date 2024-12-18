<!-- Perfect Scrollbar CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.5/css/perfect-scrollbar.min.css">

<!-- Custom CSS for Sidebar -->
<style>
    .hk-nav {
    width: 250px !important; /* Fixed width for the sidebar */
    height: 100vh; /* Full height to cover the viewport */
    background: #fff; /* White background */
    border-right: 1px solid #ddd; /* Right border for separation */
    position: fixed; /* Keeps the sidebar in place while scrolling */
    top: 0; /* Aligns the sidebar to the top */
    left: 0; /* Aligns the sidebar to the left */
    overflow-y: auto; /* Enables vertical scrolling if content exceeds height */
    z-index: 1000; /* Ensures the sidebar is above other content */
}

</style>

<nav class="hk-nav hk-nav-light">
    <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
    <div class="nicescroll-bar">
        <div class="navbar-nav-wrap">
            <ul class="navbar-nav flex-column">

                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">
                    <i class="ion ion-ios-list-box"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>

                <hr class="nav-separator">


                <!-- Cows Section -->
<li class="nav-item">
    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#cows_drp">
        <i class="fa fa-github-alt"></i><!-- Replace with a suitable cow icon -->
        <span class="nav-link-text">Cows</span>
    </a>
    <ul id="cows_drp" class="nav flex-column collapse collapse-level-1">
        <!-- Add Cow -->
        <li class="nav-item">
            <a class="nav-link" href="add-cow.php">Add Cow</a>
        </li>
        <!-- Manage Cows -->
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#manage_cows_drp">
                Manage Cows
            </a>
            <ul id="manage_cows_drp" class="nav flex-column collapse collapse-level-2">
                <li class="nav-item">
                    <a class="nav-link" href="all-cows.php">All Cows</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="milk-production.php">Milk Production</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cow-health-records.php">Health Records</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="breeding-cycles.php">Breeding Cycles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calving-management.php">Calving Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="category-management.php">Category Management</a>
                </li>
            </ul>
        </li>
    </ul>
</li>

<hr class="nav-separator">
<!-- End of Cows Section -->

                                <!-- Bulls Section -->
                                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#bulls_drp">
                        <i class="fa fa-mars-stroke"></i> <!-- Use an appropriate icon -->
                        <span class="nav-link-text">Bulls</span>
                    </a>
                    <ul id="bulls_drp" class="nav flex-column collapse collapse-level-1">
                        <li class="nav-item">
                            <a class="nav-link" href="add-bull.php">Add Bull</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#manage_bulls_drp">
                                Manage Bulls
                            </a>
                            <ul id="manage_bulls_drp" class="nav flex-column collapse collapse-level-2">
                                <li class="nav-item">
                                    <a class="nav-link" href="all-bulls.php">All Bulls</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="health-records.php?pid=<?php echo base64_encode($bull_id); ?>">Health Records</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="weight-management.php">Weight Management</a>
                                </li>
                                
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- End of Bulls Section -->

                <hr class="nav-separator">

                                <!-- Managers Section -->
                                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#managers_drp">
                        <i class="ion ion-ios-people"></i>
                        <span class="nav-link-text">Managers</span>
                    </a>
                    <ul id="managers_drp" class="nav flex-column collapse collapse-level-1">
                        <!-- Herd Manager Section -->
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#herd_manager_drp">
                                <span class="nav-link-text">Herd Manager</span>
                            </a>
                            <ul id="herd_manager_drp" class="nav flex-column collapse collapse-level-2">
                                <li class="nav-item">
                                    <a class="nav-link" href="add-herd-manager.php">Add Herd Manager</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="manage-herd-managers.php">Manage Herd Managers</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Health Manager Section -->
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#health_manager_drp">
                                <span class="nav-link-text">Health Manager</span>
                            </a>
                            <ul id="health_manager_drp" class="nav flex-column collapse collapse-level-2">
                                <li class="nav-item">
                                    <a class="nav-link" href="add-health-manager.php">Add Health Manager</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="manage-health-managers.php">Manage Health Managers</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Fertility Manager Section -->
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#fertility_manager_drp">
                                <span class="nav-link-text">Fertility Manager</span>
                            </a>
                            <ul id="fertility_manager_drp" class="nav flex-column collapse collapse-level-2">
                                <li class="nav-item">
                                    <a class="nav-link" href="add-fertility-manager.php">Add Fertility Manager</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="manage-fertility-managers.php">Manage Fertility Managers</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Milk & Weight Manager Section -->
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#milk_weight_manager_drp">
                                <span class="nav-link-text">Milk & Weight Manager</span>
                            </a>
                            <ul id="milk_weight_manager_drp" class="nav flex-column collapse collapse-level-2">
                                <li class="nav-item">
                                    <a class="nav-link" href="add-milk-weight-manager.php">Add Milk & Weight Manager</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="manage-milk-weight-managers.php">Manage Milk & Weight Managers</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- End of Managers Section -->

                <hr class="nav-separator"> <!-- Adding the horizontal line -->

                                <!-- Feeds Section -->
<li class="nav-item">
    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#feeds_drp">
        <i class="fa fa-bullhorn"></i> <!-- Use an appropriate icon -->
        <span class="nav-link-text">Feeds</span>
    </a>
    <ul id="feeds_drp" class="nav flex-column collapse collapse-level-1">
        <!-- Add Feed -->
        <li class="nav-item">
            <a class="nav-link" href="add-feed.php">Add Feed</a>
        </li>
        <!-- Manage Feeds -->
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#manage_feeds_drp">
                Manage Feeds
            </a>
            <ul id="manage_feeds_drp" class="nav flex-column collapse collapse-level-2">
                <li class="nav-item">
                    <a class="nav-link" href="all-feeds.php">All Feeds</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stock-levels.php">Stock Levels</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="feeding-plans.php">Feeding Plans</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cost-management.php">Cost Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="purchase-history.php">Purchase History</a>
                </li>
            </ul>
        </li>
    </ul>
</li>
<!-- End of Feeds Section -->

<hr class="nav-separator"> <!-- Adding the horizontal line -->


                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#cats_drp">
                        <i class="ion ion-ios-copy"></i>
                        <span class="nav-link-text">Category</span>
                    </a>
                    <ul id="cats_drp" class="nav flex-column collapse collapse-level-1">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="add-category.php">Add</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="manage-categories.php">Manage</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#company_drp">
                        <i class="ion ion-ios-copy"></i>
                        <span class="nav-link-text">Company</span>
                    </a>
                    <ul id="company_drp" class="nav flex-column collapse collapse-level-1">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="add-company.php">Add</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="manage-companies.php">Manage</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#product_drp">
                        <i class="ion ion-ios-list-box"></i>
                        <span class="nav-link-text">Product</span>
                    </a>
                    <ul id="product_drp" class="nav flex-column collapse collapse-level-1">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="add-product.php">Add</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="manage-products.php">Manage</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="search-product.php">
                        <i class="glyphicon glyphicon-search"></i>
                        <span class="nav-link-text">Search Product</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="invoices.php">
                        <i class="ion ion-ios-list-box"></i>
                        <span class="nav-link-text">Invoices</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#reports_drp">
                        <i class="ion ion-ios-today"></i>
                        <span class="nav-link-text">Reports</span>
                    </a>
                    <ul id="reports_drp" class="nav flex-column collapse collapse-level-1">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="bwdate-report-ds.php">B/w Dates</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="sales-report-ds.php">Sales</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>


            </ul>
            <hr class="nav-separator">
        </div>
    </div>
</nav>


<!-- Perfect Scrollbar JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.5/perfect-scrollbar.min.js"></script>

<!-- Initialize Perfect Scrollbar -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Select the sidebar container
        const sidebar = document.querySelector('.nicescroll-bar');

        // Initialize Perfect Scrollbar
        const ps = new PerfectScrollbar(sidebar, {
            wheelSpeed: 1,
            wheelPropagation: true,
            minScrollbarLength: 20,
        });

        // Optional: Prevent native scrollbar display
        sidebar.style.overflow = 'hidden';
    });
</script>