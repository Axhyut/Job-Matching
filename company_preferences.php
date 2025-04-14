<?php
include('server.php');

// Check if the company is logged in and the form is submitted
if (isset($_POST['submit_company_preferences'])) {
    $first_pref = $_POST['first_pref'];
    $second_pref = $_POST['second_pref'];
    $third_pref = $_POST['third_pref'];

    // Check if the user is logged in as a company
    if (isset($_SESSION["Username"]) && $_SESSION["Usertype"] == 2) { // Assuming 2 is for employers
        $company_username = $_SESSION["Username"];

        // Prepare SQL to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO company_preference (company_username, first_pref, second_pref, third_pref) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE first_pref=?, second_pref=?, third_pref=?");
        $stmt->bind_param("sssssss", $company_username, $first_pref, $second_pref, $third_pref, $first_pref, $second_pref, $third_pref);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Company preferences saved successfully.'); window.location.href = 'employer_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error saving preferences: " . $stmt->error . "'); window.location.href = 'company_preferences.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('You need to be logged in as a company to set preferences.'); window.location.href = 'login.php';</script>";
    }
}
?>
