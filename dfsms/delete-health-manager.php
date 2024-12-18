<?php
session_start();
include('includes/config.php');

if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Check if the 'pid' is passed in the URL
    if (isset($_GET['pid'])) {
        // Get the encoded pid from the URL
        $encoded_pid = $_GET['pid'];

        // Decode the pid
        $decoded_pid = base64_decode($encoded_pid);

        // Output the decoded value for debugging (you can comment this out after debugging)
        echo "Decoded PID: " . $decoded_pid . "<br>";

        // Check if decoded PID is valid and numeric
        if (empty($decoded_pid) || !is_numeric($decoded_pid)) {
            echo "<script>alert('Invalid ID passed for deletion.');</script>";
            echo "<script>window.location.href='manage-health-managers.php'</script>";
        } else {
            // Query to delete the health manager from the database
            $query = mysqli_query($con, "DELETE FROM tblhealth_managers WHERE id='$decoded_pid'");

            if ($query) {
                echo "<script>alert('Health manager deleted successfully.');</script>";
                echo "<script>window.location.href='manage-health-managers.php'</script>";
            } else {
                echo "<script>alert('Error deleting health manager.');</script>";
                echo "<script>window.location.href='manage-health-managers.php'</script>";
            }
        }
    } else {
        echo "<script>alert('No ID provided to delete.');</script>";
        echo "<script>window.location.href='manage-health-managers.php'</script>";
    }
}
?>