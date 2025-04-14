<?php 
include('server.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_preferences'])) {
    // Retrieve preferences from the form
    $first_pref = $_POST['first_pref'];
    $second_pref = $_POST['second_pref'];
    $third_pref = $_POST['third_pref'];

    // Check if user is logged in
    if (isset($_SESSION["Username"])) {
        $freelancer_username = $_SESSION["Username"];

        // Prepare SQL query to insert preferences
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

// Check if the user is logged in and set variables accordingly
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

// Fetch all jobs based on different search options
$sql = "SELECT * FROM job_offer WHERE valid=1 ORDER BY timestamp DESC";
$result = $conn->query($sql);

if (isset($_POST["s_title"])) {
    $t = $_POST["s_title"];
    $sql = "SELECT * FROM job_offer WHERE title='$t' AND valid=1";
    $result = $conn->query($sql);
}

if (isset($_POST["s_type"])) {
    $t = $_POST["s_type"];
    $sql = "SELECT * FROM job_offer WHERE type='$t' AND valid=1";
    $result = $conn->query($sql);
}

if (isset($_POST["s_employer"])) {
    $t = $_POST["s_employer"];
    $sql = "SELECT * FROM job_offer WHERE e_username='$t' AND valid=1";
    $result = $conn->query($sql);
}

if (isset($_POST["s_id"])) {
    $t = $_POST["s_id"];
    $sql = "SELECT * FROM job_offer WHERE job_id='$t' AND valid=1";
    $result = $conn->query($sql);
}

if (isset($_POST["recentJob"])) {
    $sql = "SELECT * FROM job_offer WHERE valid=1 ORDER BY timestamp DESC";
    $result = $conn->query($sql);
}

if (isset($_POST["oldJob"])) {
    $sql = "SELECT * FROM job_offer WHERE valid=1";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Job Offers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">
    <style>
        body { padding-top: 3%; margin: 0; }
        .card { box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background: #fff; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="index.php" class="navbar-brand">Projectworlds Freelance</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="allJob.php">Browse all jobs</a></li>
                    <li><a href="allFreelancer.php">Browse Freelancers</a></li>
                    <li><a href="allEmployer.php">Browse Employers</a></li>
                    <li class="dropdown" style="background:#000;padding:0 20px;">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <span class="glyphicon glyphicon-user"></span> <?php echo $username; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $linkPro; ?>">View Profile</a></li>
                            <li><a href="<?php echo $linkEditPro; ?>">Edit Profile</a></li>
                            <li><a href="message.php">Messages</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main Body -->
    <div style="padding:1% 3%;">
        <div class="row">
            <!-- Job Offers -->
            <div class="col-lg-9">
                <div class="card" style="padding:20px;">
                    <div class="panel panel-success">
                        <div class="panel-heading"><h3>All Job Offers</h3></div>
                        <div class="panel-body">
                            <table style="width:100%">
                                <tr>
                                    <th>Job Id</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Budget</th>
                                    <th>Employer</th>
                                    <th>Posted on</th>
                                </tr>
                                <?php 
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>{$row['job_id']}</td>
                                            <td>{$row['title']}</td>
                                            <td>{$row['type']}</td>
                                            <td>{$row['budget']}</td>
                                            <td>{$row['e_username']}</td>
                                            <td>{$row['timestamp']}</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No jobs to show</td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Preferences -->
            <div class="col-lg-3">
                <div class="card" style="padding:20px;">
                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Set Your Job Preferences</h3></div>
                        <div class="panel-body">
                            <form action="freelancer_preferences.php" method="post">
                            <div class="form-group">
    <label for="first_pref">1st Preference Job</label>
    <select name="first_pref" class="form-control" required>
        <option value="">Select</option>
        <?php 
        $job_query = $conn->query("SELECT * FROM job_offer WHERE valid=1");
        while ($job = $job_query->fetch_assoc()) {
            echo "<option value='{$job['job_id']}'>{$job['title']}</option>";
        }
        ?>
    </select>
</div>
<div class="form-group">
    <label for="second_pref">2nd Preference Job</label>
    <select name="second_pref" class="form-control" required>
        <option value="">Select</option>
        <?php 
        $job_query = $conn->query("SELECT * FROM job_offer WHERE valid=1");
        while ($job = $job_query->fetch_assoc()) {
            echo "<option value='{$job['job_id']}'>{$job['title']}</option>";
        }
        ?>
    </select>
</div>
<div class="form-group">
    <label for="third_pref">3rd Preference Job</label>
    <select name="third_pref" class="form-control" required>
        <option value="">Select</option>
        <?php 
        $job_query = $conn->query("SELECT * FROM job_offer WHERE valid=1");
        while ($job = $job_query->fetch_assoc()) {
            echo "<option value='{$job['job_id']}'>{$job['title']}</option>";
        }
        ?>
    </select>
</div>

                                <!-- Repeat for 2nd and 3rd preferences -->
                                <button type="submit" name="submit_preferences" class="btn btn-success">Save Preferences</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
