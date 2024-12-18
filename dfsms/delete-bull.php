<?php
session_start();
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Debug: print the GET data to check if 'pid' is present
    if (isset($_GET['pid'])) {
        echo "PID is: " . $_GET['pid']; // Debugging line, you can remove it later
    } else {
        echo "No PID found in URL"; // Debugging line, you can remove it later
    }

    // Check if the 'pid' (Bull_ID) is passed in the URL
    if (isset($_GET['pid'])) {
        // Get the Bull_ID directly from the URL
        $bull_id = $_GET['pid'];

        // Check if the Bull_ID is valid and numeric
        if (empty($bull_id) || !is_numeric($bull_id)) {
            echo "<script>alert('Invalid Bull ID passed for deletion.');</script>";
            // Redirect to the bulls management page
            echo "<script>window.location.href='all-bulls.php'</script>";
        } else {
            // Query to delete the bull from the database
            $query = mysqli_query($con, "DELETE FROM bulls WHERE Bull_ID='$bull_id'");

            if ($query) {
                echo "<script>alert('Bull deleted successfully.');</script>";
                // Redirect to the bulls list page
                echo "<script>window.location.href='all-bulls.php'</script>";
            } else {
                echo "<script>alert('Error deleting bull.');</script>";
                // Redirect to the bulls list page
                echo "<script>window.location.href='all-bulls.php'</script>";
            }
        }
    } else {
        echo "<script>alert('No Bull ID provided to delete.');</script>";
        // Redirect to the bulls list page
        echo "<script>window.location.href='all-bulls.php'</script>";
    }
}
?>
