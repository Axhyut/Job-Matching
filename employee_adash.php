<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit();
}

include('server.php'); // Include database connection

// Fetch employers
$employers = $conn->query("SELECT * FROM employer");

// Fetch scores for each employer (if applicable)
function getEmployerScores($conn, $username) {
    $sql = "SELECT * FROM company_scores WHERE freelancer_username = '$username'";
    return $conn->query($sql);
}

// Fetch job postings for each employer
function getEmployerJobs($conn, $username) {
    $sql = "SELECT * FROM job_offer WHERE e_username = '$username'";
    return $conn->query($sql);
}

// Handle score submission (if applicable)
if (isset($_POST['submit_score'])) {
    $freelancer_username = $_POST['freelancer_username'];
    $score = $_POST['score'];
    $comments = $_POST['comments'];
    $admin_username = $_SESSION['admin'];

    // Insert the score and comments into the company_scores table
    $sql = "INSERT INTO company_scores (freelancer_username, admin_username, score, comments, created_at) 
            VALUES ('$freelancer_username', '$admin_username', '$score', '$comments', NOW())";
    if ($conn->query($sql) === TRUE) {
        echo "Score submitted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
</head>
<body>
    <h2>Employer Profiles</h2>
    <table border="1">
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Job Details</th>
            <th>Profile Summary</th>
            <th>Score Employer</th>
            <th>Previous Scores</th>
        </tr>
        <?php while ($employer = $employers->fetch_assoc()): ?>
        <tr>
            <td><?php echo $employer['username']; ?></td>
            <td><?php echo $employer['Name']; ?></td>
            <td><?php echo $employer['email']; ?></td>
            <td>
                <!-- Display Job Details -->
                <h4>Job Details:</h4>
                <?php 
                $jobs = getEmployerJobs($conn, $employer['username']);
                if ($jobs && $jobs->num_rows > 0): 
                    while ($job = $jobs->fetch_assoc()): ?>
                    <p>Job Title: <?php echo $job['title']; ?></p>
                    <p>Description: <?php echo $job['description']; ?></p>
                    <p>Budget: <?php echo $job['budget']; ?></p>
                    <p>Skills: <?php echo $job['skills']; ?></p>
                    <hr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No job postings yet.</p>
                <?php endif; ?>
            </td>
            <td><?php echo $employer['profile_sum']; ?></td>
            <td>
                <!-- Score Submission Form -->
                <form action="" method="POST">
                    <input type="hidden" name="freelancer_username" value="<?php echo $employer['username']; ?>">
                    <label for="score">Score (0-100):</label>
                    <input type="number" name="score" min="0" max="100" required><br>
                    <label for="comments">Comments:</label>
                    <textarea name="comments"></textarea><br>
                    <button type="submit" name="submit_score">Submit Score</button>
                </form>
            </td>
            <td>
                <!-- Display Existing Scores -->
                <h4>Previous Scores:</h4>
                <?php 
                $scores = getEmployerScores($conn, $employer['username']);
                if ($scores->num_rows > 0):
                    while ($score = $scores->fetch_assoc()): ?>
                    <p>Score: <?php echo $score['score']; ?>/100</p>
                    <p>Comments: <?php echo $score['comments']; ?></p>
                    <hr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No scores yet.</p>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="admin_logout.php">Logout</a>
</body>
</html>
