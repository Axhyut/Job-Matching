<!-- freelancer_preferences.php -->
<?php
session_start();
include('db_connection.php');  // Include database connection

// Check if freelancer is logged in
if (!isset($_SESSION["Username"])) {
    echo "<script>alert('You need to be logged in to set preferences.'); window.location.href = 'login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Job Preferences</title>
    <link rel="stylesheet" href="path_to_your_css_file.css">
</head>
<body>
    <div class="container">
        <div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
            <div class="panel panel-info">
                <div class="panel-heading"><h3>Set Your Job Preferences</h3></div>
                <div class="panel-body">
                    <form action="freelancer_preferences.php" method="post">
                        <div class="form-group">
                            <label for="first_pref">1st Preference Job (Select Job)</label>
                            <select class="form-control" name="first_pref" id="first_pref" required>
                                <option value="">Select Job</option>
                                <?php
                                // Fetch all job offers from the database
                                $sql = "SELECT job_id, title FROM job_offer WHERE valid=1 ORDER BY timestamp DESC";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['job_id'] . "'>" . $row['title'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="second_pref">2nd Preference Job (Select Job)</label>
                            <select class="form-control" name="second_pref" id="second_pref">
                                <option value="">Select Job</option>
                                <?php
                                // Fetch job offers again for second preference
                                $result = $conn->query($sql); // Re-run the query for available jobs
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['job_id'] . "'>" . $row['title'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="third_pref">3rd Preference Job (Select Job)</label>
                            <select class="form-control" name="third_pref" id="third_pref">
                                <option value="">Select Job</option>
                                <?php
                                // Fetch job offers again for third preference
                                $result = $conn->query($sql); // Re-run the query for available jobs
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['job_id'] . "'>" . $row['title'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <center><button type="submit" name="submit_preferences" class="btn btn-success">Save Preferences</button></center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
