<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "fmarket");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch company scores
$companyQuery = "SELECT freelancer_username, score FROM company_scores";
$companyResult = $conn->query($companyQuery);

if (!$companyResult) {
    die("Company Query failed: " . $conn->error);
}

$companies = [];
if ($companyResult->num_rows > 0) {
    echo "<strong>Company Scores:</strong><br>";
    while ($row = $companyResult->fetch_assoc()) {
        $companies[$row['freelancer_username']] = $row['score'];
        echo "Company: " . $row['freelancer_username'] . " - Score: " . $row['score'] . "<br>";
    }
} else {
    echo "No company scores found.<br>";
}

// Fetch freelancer scores
$freelancerQuery = "SELECT freelancer_username, score FROM freelancer_scores";
$freelancerResult = $conn->query($freelancerQuery);

if (!$freelancerResult) {
    die("Freelancer Query failed: " . $conn->error);
}

$freelancers = [];
if ($freelancerResult->num_rows > 0) {
    echo "<br><strong>Freelancer Scores:</strong><br>";
    while ($row = $freelancerResult->fetch_assoc()) {
        $freelancers[$row['freelancer_username']] = $row['score'];
        echo "Freelancer: " . $row['freelancer_username'] . " - Score: " . $row['score'] . "<br>";
    }
} else {
    echo "No freelancer scores found.<br>";
}

// Close connection
$conn->close();
?>
