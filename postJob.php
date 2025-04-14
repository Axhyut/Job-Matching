<?php 
// Include the database connection file
include('server.php');

// Check if the user is logged in
if (isset($_SESSION["Username"])) {
    $username = $_SESSION["Username"];
} else {
    $username = "";
    // Redirect to login if the user is not logged in
    header("location: index.php");
    exit;
}

// Function to sanitize user inputs
function test_input($data) {
    global $conn; // Use the global database connection
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data); // Prevent SQL injection
}

// Handle form submission
if (isset($_POST["postJob"])) {
    // Sanitize inputs
    $title = test_input($_POST["title"]);
    $type = test_input($_POST["type"]);
    $description = test_input($_POST["description"]);
    $budget = test_input($_POST["budget"]);
    $skills = test_input($_POST["skills"]);
    $special_skill = test_input($_POST["special_skill"]);
 

    // SQL query to insert job offer
    $sql = "INSERT INTO job_offer (title, type, description, budget, skills, special_skill, e_username, valid) 
            VALUES ('$title', '$type', '$description', '$budget', '$skills', '$special_skill', '$username', 1)";

    if ($conn->query($sql) === TRUE) {
        // Store the inserted job ID in the session
        $_SESSION["job_id"] = $conn->insert_id;

        // Redirect to job details page
        //header("location: jobDetails.php");
        exit;
    } else {
        // Output SQL error for debugging
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Post a Job</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrapValidator.css">

    <style>
        body { padding-top: 3%; margin: 0; }
        .card { 
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); 
            background: #fff; 
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top" id="my-navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
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
                <li class="dropdown" style="background: #000; padding: 0 20px;">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-user"></span> <?php echo $username; ?>
                    </a>
                    <ul class="dropdown-menu list-group list-group-item-info">
                        <a href="employerProfile.php" class="list-group-item"><span class="glyphicon glyphicon-home"></span> View profile</a>
                        <a href="editEmployer.php" class="list-group-item"><span class="glyphicon glyphicon-inbox"></span> Edit Profile</a>
                        <a href="message.php" class="list-group-item"><span class="glyphicon glyphicon-envelope"></span> Messages</a>
                        <a href="logout.php" class="list-group-item"><span class="glyphicon glyphicon-ok"></span> Logout</a>
                    </ul>
                </li>
            </ul>
        </div>      
    </div>  
</nav>
<!-- End Navbar -->

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h2>Post A Job Offer</h2>
            </div>

            <form id="registrationForm" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Job Title</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="title" required />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Job Type</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="type" required />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Job Description</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="description" required />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Budget</label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control" name="budget" required />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Required Skills</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="skills" required />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Special Requirement</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="special_skill" />
                    </div>
                </div>
               
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button type="submit" name="postJob" class="btn btn-info btn-lg">Post</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="text-center" style="padding: 4%; background: #222; color: #fff; margin-top: 20px;">
    <div class="row">
        <div class="col-lg-3">
            <h3>Quick Links</h3>
            <p><a href="index.php">Home</a></p>
            <p><a href="allJob.php">Browse all jobs</a></p>
            <p><a href="allFreelancer.php">Browse Freelancers</a></p>
            <p><a href="allEmployer.php">Browse Employers</a></p>
        </div>
        <div class="col-lg-3">
            <h3>About Us</h3>
            <p>Projectworlds</p>
            <p>Raipur, Chhattisgarh</p>
            <p>Gajen Pradhan</p>
            <p>&copy; 2020</p>
        </div>
        <div class="col-lg-3">
            <h3>Contact Us</h3>
            <p>Projectworlds Bhilai +917000830947</p>
            <p>Chhattisgarh, India</p>
            <p>&copy; 2020</p>
        </div>
        <div class="col-lg-3">
            <h3>Social Contact</h3>
            <p style="font-size: 20px; color: #3B579D;"><i class="fab fa-facebook-square"> Facebook</i></p>
            <p style="font-size: 20px; color: #D34438;"><i class="fab fa-google-plus-square"> Google</i></p>
            <p style="font-size: 20px; color: #1DA1F2;"><i class="fab fa-twitter-square"> Twitter</i></p>
            <p style="font-size: 20px; color: #007BB5;"><i class="fab fa-linkedin"> Linkedin</i></p>
        </div>
    </div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="dist/js/bootstrapValidator.js"></script>

</body>
</html>
