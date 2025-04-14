<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit();
}

include('server.php'); // Include database connection

// Fetch freelancers
$freelancers = $conn->query("SELECT * FROM freelancer");

// Handle score submission
if (isset($_POST['submit_score'])) {
    $freelancer_username = $_POST['freelancer_username'];
    $score = $_POST['score'];
    $comments = $_POST['comments'];
    $admin_username = $_SESSION['admin'];

    // Insert the score and comments into the database
    $sql = "INSERT INTO freelancer_scores (freelancer_username, admin_username, score, comments) 
            VALUES ('$freelancer_username', '$admin_username', '$score', '$comments')";
    if ($conn->query($sql) === TRUE) {
        echo "Score submitted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch scores for each freelancer
function getFreelancerScores($conn, $username) {
    $sql = "SELECT * FROM freelancer_scores WHERE freelancer_username = '$username'";
    return $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Dashboard</title>
</head>
<body>
    <h2>Freelancer Profiles</h2>
    <table border="1">
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Professional Title</th>
            <th>Skills</th>
            <th>Profile Summary</th>
            <th>Education</th>
            <th>Experience</th>
            <th>Resume Link</th>
            <th>Certificate Link</th>
            <th>Score Freelancer</th>
            <th>Previous Scores</th>
        </tr>
        <?php while ($freelancer = $freelancers->fetch_assoc()): ?>
        <tr>
            <td><?php echo $freelancer['username']; ?></td>
            <td><?php echo $freelancer['email']; ?></td>
            <td><?php echo $freelancer['gender']; ?></td>
            <td><?php echo $freelancer['address']; ?></td>
            <td><?php echo $freelancer['prof_title']; ?></td>
            <td><?php echo $freelancer['skills']; ?></td>
            <td><?php echo $freelancer['profile_sum']; ?></td>
            <td><?php echo $freelancer['education']; ?></td>
            <td><?php echo $freelancer['experience']; ?></td>
            <td><a href="<?php echo htmlspecialchars($freelancer['resume_link']); ?>" target="_blank">View Resume</a></td>
            <td><a href="<?php echo htmlspecialchars($freelancer['certificate_link']); ?>" target="_blank">View Certificate</a></td>
            <td>
                <!-- Score Submission Form -->
                <form action="" method="POST">
                    <input type="hidden" name="freelancer_username" value="<?php echo $freelancer['username']; ?>">
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
                $scores = getFreelancerScores($conn, $freelancer['username']);
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
