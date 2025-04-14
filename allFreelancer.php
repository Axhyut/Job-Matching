<?php
include('server.php');

if (isset($_POST['submit_preferences'])) {
    $first_pref = $_POST['first_pref'];
    $second_pref = $_POST['second_pref'];
    $third_pref = $_POST['third_pref'];

    if (isset($_SESSION["Username"])) {
        $freelancer_username = $_SESSION["Username"];

        // Prepare SQL to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO freelancer_preference (freelancer_username, first_pref, second_pref, third_pref) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $freelancer_username, $first_pref, $second_pref, $third_pref);

        if ($stmt->execute()) {
            echo "<script>alert('Preferences saved successfully.'); window.location.href = 'freelancer_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error saving preferences: " . $stmt->error . "'); window.location.href = 'freelancer_preferences.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('You need to be logged in to set preferences.'); window.location.href = 'login.php';</script>";
    }
}

if (isset($_SESSION["Username"])) {
    $username = $_SESSION["Username"];
    if ($_SESSION["Usertype"] == 1) {
        $linkPro = "freelancerProfile.php";
        $linkEditPro = "editFreelancer.php";
        $linkBtn = "applyJob.php";
        $textBtn = "Apply for this job";
    } else {
        $linkPro = "employerProfile.php";
        $linkEditPro = "editEmployer.php";
        $linkBtn = "editJob.php";
        $textBtn = "Edit the job offer";
    }
} else {
    $username = "";
}

// Search functionality for freelancers
if (isset($_POST["s_username"])) {
    $t = $_POST["s_username"];
    $sql = "SELECT * FROM freelancer WHERE username='$t'";
    $result = $conn->query($sql);
} elseif (isset($_POST["s_name"])) {
    $t = $_POST["s_name"];
    $sql = "SELECT * FROM freelancer WHERE Name='$t'";
    $result = $conn->query($sql);
} elseif (isset($_POST["s_email"])) {
    $t = $_POST["s_email"];
    $sql = "SELECT * FROM freelancer WHERE email='$t'";
    $result = $conn->query($sql);
} else {
    $sql = "SELECT * FROM freelancer";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Freelancer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">
    <style>
        body { padding-top: 3%; margin: 0; }
        .card { box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background: #fff; }
    </style>
</head>
<body>

<!-- Main Body -->
<div style="padding:1% 3% 1% 3%;">
    <div class="row">
        <!-- Column 1 -->
        <div class="col-lg-9">
            <!-- Freelancer Profile Details -->
            <div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>All Freelancer</h3></div>
                    <div class="panel-body">
                        <h4>
                            <table style="width:100%">
                                <tr>
                                    <td>Username</td>
                                    <td>Name</td>
                                    <td>Professional Title</td>
                                    <td>Email</td>
                                    <td>Skill</td>
                                </tr>
                                <?php
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        $f_username = $row["username"];
                                        $Name = $row["Name"];
                                        $prof_title = $row["prof_title"];
                                        $email = $row["email"];
                                        $skills = $row["skills"];

                                        echo '
                                        <form action="allFreelancer.php" method="post">
                                        <input type="hidden" name="f_user" value="' . $f_username . '">
                                            <tr>
                                            <td><input type="submit" class="btn btn-link btn-lg" value="' . $f_username . '"></td>
                                            <td>' . $Name . '</td>
                                            <td>' . $prof_title . '</td>
                                            <td>' . $email . '</td>
                                            <td>' . $skills . '</td>
                                            </tr>
                                        </form>
                                        ';
                                    }
                                } else {
                                    echo "<tr></tr><tr><td></td><td>Nothing to show</td></tr>";
                                }
                                ?>
                            </table>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- End Freelancer Profile Details -->
        </div>
        <!-- End Column 1 -->
    </div>
</div>
<!-- End Main Body -->

<!-- Freelancer Preferences Form -->
<div class="container">
    <div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
        <div class="panel panel-info">
            <div class="panel-heading"><h3>Set Your Freelancer Preferences</h3></div>
            <div class="panel-body">
            <form action="company_preferences.php" method="post">
    <div class="form-group">
        <label for="first_pref">1st Preference Freelancer (Select Freelancer)</label>
        <select class="form-control" name="first_pref" id="first_pref" required>
            <option value="">Select Freelancer</option>
            <?php
            // Fetch freelancers from the database to populate the dropdown
            $sql = "SELECT username, Name FROM freelancer ORDER BY Name";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['username'] . "'>" . $row['Name'] . "</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="second_pref">2nd Preference Freelancer (Select Freelancer)</label>
        <select class="form-control" name="second_pref" id="second_pref">
            <option value="">Select Freelancer</option>
            <?php
            // Same as above, fetch freelancers for second preference
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['username'] . "'>" . $row['Name'] . "</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="third_pref">3rd Preference Freelancer (Select Freelancer)</label>
        <select class="form-control" name="third_pref" id="third_pref">
            <option value="">Select Freelancer</option>
            <?php
            // Fetch freelancers again for third preference
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['username'] . "'>" . $row['Name'] . "</option>";
            }
            ?>
        </select>
    </div>

    <center><button type="submit" name="submit_company_preferences" class="btn btn-success">Save Preferences</button></center>
</form>

            </div>
        </div>
    </div>
</div>
<!-- End Freelancer Preferences Form -->

<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
