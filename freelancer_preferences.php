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

        // Check if preferences already exist in the table
        $stmt_check = $conn->prepare("SELECT * FROM freelancer_preference WHERE freelancer_username = ?");
        $stmt_check->bind_param("s", $freelancer_username);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        // If preferences already exist, update them
        if ($result_check->num_rows > 0) {
            $stmt_update = $conn->prepare("UPDATE freelancer_preference SET first_pref = ?, second_pref = ?, third_pref = ? WHERE freelancer_username = ?");
            $stmt_update->bind_param("iiis", $first_pref, $second_pref, $third_pref, $freelancer_username);

            if ($stmt_update->execute()) {
                echo "<script>alert('Preferences updated successfully.'); window.location.href = 'freelancer_dashboard.php';</script>";
            } else {
                echo "<script>alert('Error updating preferences: " . $stmt_update->error . "'); window.location.href = 'freelancer_preferences.php';</script>";
            }
            $stmt_update->close();
        } else {
            // Insert new preferences if they don't exist
            $stmt_insert = $conn->prepare("INSERT INTO freelancer_preference (freelancer_username, first_pref, second_pref, third_pref) VALUES (?, ?, ?, ?)");
            $stmt_insert->bind_param("siii", $freelancer_username, $first_pref, $second_pref, $third_pref);

            if ($stmt_insert->execute()) {
                echo "<script>alert('Preferences saved successfully.'); window.location.href = 'freelancer_dashboard.php';</script>";
            } else {
                echo "<script>alert('Error saving preferences: " . $stmt_insert->error . "'); window.location.href = 'freelancer_preferences.php';</script>";
            }
            $stmt_insert->close();
        }

        $stmt_check->close();
    } else {
        echo "<script>alert('You need to be logged in to set preferences.'); window.location.href = 'login.php';</script>";
    }
}

// Fetch all jobs based on different search options
$sql = "SELECT j.job_id, j.title, j.type, j.budget, j.e_username, j.timestamp, e.company_name 
        FROM job_offer j 
        JOIN employer e ON j.e_username = e.username 
        WHERE j.valid=1 ORDER BY j.timestamp DESC";
$result = $conn->query($sql);

// Handle filters
if (isset($_POST["s_title"])) {
    $t = $_POST["s_title"];
    $sql = "SELECT j.job_id, j.title, j.type, j.budget, j.e_username, j.timestamp, e.company_name 
            FROM job_offer j 
            JOIN employer e ON j.e_username = e.username 
            WHERE j.title='$t' AND j.valid=1";
    $result = $conn->query($sql);
}

if (isset($_POST["s_type"])) {
    $t = $_POST["s_type"];
    $sql = "SELECT j.job_id, j.title, j.type, j.budget, j.e_username, j.timestamp, e.company_name 
            FROM job_offer j 
            JOIN employer e ON j.e_username = e.username 
            WHERE j.type='$t' AND j.valid=1";
    $result = $conn->query($sql);
}

if (isset($_POST["s_employer"])) {
    $t = $_POST["s_employer"];
    $sql = "SELECT j.job_id, j.title, j.type, j.budget, j.e_username, j.timestamp, e.company_name 
            FROM job_offer j 
            JOIN employer e ON j.e_username = e.username 
            WHERE j.e_username='$t' AND j.valid=1";
    $result = $conn->query($sql);
}

if (isset($_POST["s_id"])) {
    $t = $_POST["s_id"];
    $sql = "SELECT j.job_id, j.title, j.type, j.budget, j.e_username, j.timestamp, e.company_name 
            FROM job_offer j 
            JOIN employer e ON j.e_username = e.username 
            WHERE j.job_id='$t' AND j.valid=1";
    $result = $conn->query($sql);
}

if (isset($_POST["recentJob"])) {
    $sql = "SELECT j.job_id, j.title, j.type, j.budget, j.e_username, j.timestamp, e.company_name 
            FROM job_offer j 
            JOIN employer e ON j.e_username = e.username 
            WHERE j.valid=1 ORDER BY j.timestamp DESC";
    $result = $conn->query($sql);
}

if (isset($_POST["oldJob"])) {
    $sql = "SELECT j.job_id, j.title, j.type, j.budget, j.e_username, j.timestamp, e.company_name 
            FROM job_offer j 
            JOIN employer e ON j.e_username = e.username 
            WHERE j.valid=1";
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
                                    <th>Company Name</th>
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
                                            <td>".$row['company_name']."</td>
                                            <td>".$row['title']."</td>
                                            <td>".$row['type']."</td>
                                            <td>".$row['budget']."</td>
                                            <td>".$row['e_username']."</td>
                                            <td>".$row['timestamp']."</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No job offers found</td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar -->
            <div class="col-lg-3">
                <!-- Filters -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="allJob.php" method="post">
                            <h5>Search Job Offers:</h5>
                            <input type="text" class="form-control" name="s_title" placeholder="Search by Title">
                            <input type="text" class="form-control" name="s_type" placeholder="Search by Type">
                            <input type="text" class="form-control" name="s_employer" placeholder="Search by Employer">
                            <input type="text" class="form-control" name="s_id" placeholder="Search by Job ID">
                            <button type="submit" class="btn btn-info">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
