<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "fmarket");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch company preferences using prepared statements
$companyQuery = $conn->prepare("SELECT company_username, first_pref, second_pref, third_pref FROM company_preference");
if ($companyQuery === false) {
    die("Error in preparing company query: " . $conn->error);
}
$companyQuery->execute();
$companyResult = $companyQuery->get_result();

if (!$companyResult) {
    die("Company Query failed: " . $companyQuery->error);
}

$companies = [];
if ($companyResult->num_rows > 0) {
    while ($row = $companyResult->fetch_assoc()) {
        $companies[$row['company_username']] = [
            'preferences' => [$row['first_pref'], $row['second_pref'], $row['third_pref']],
            'score' => 0 // Initialize score, will fetch from company_scores later
        ];
    }
} else {
    echo "No company preferences found.<br>";
}

// Fetch freelancer preferences using prepared statements
$freelancerQuery = $conn->prepare("SELECT freelancer_username, first_pref, second_pref, third_pref FROM freelancer_preference");
if ($freelancerQuery === false) {
    die("Error in preparing freelancer query: " . $conn->error);
}
$freelancerQuery->execute();
$freelancerResult = $freelancerQuery->get_result();

if (!$freelancerResult) {
    die("Freelancer Query failed: " . $freelancerQuery->error);
}

$freelancers = [];
if ($freelancerResult->num_rows > 0) {
    while ($row = $freelancerResult->fetch_assoc()) {
        $freelancers[$row['freelancer_username']] = [
            'preferences' => [$row['first_pref'], $row['second_pref'], $row['third_pref']],
            'score' => 0 // Initialize score, will fetch from freelancer_scores later
        ];
    }
} else {
    echo "No freelancer preferences found.<br>";
}

// Fetch company scores using prepared statements
$companyScoresQuery = $conn->prepare("SELECT freelancer_username, score FROM company_scores");
if ($companyScoresQuery === false) {
    die("Error in preparing company scores query: " . $conn->error);
}
$companyScoresQuery->execute();
$companyScoresResult = $companyScoresQuery->get_result();

if (!$companyScoresResult) {
    die("Company Scores Query failed: " . $companyScoresQuery->error);
}

if ($companyScoresResult->num_rows > 0) {
    while ($row = $companyScoresResult->fetch_assoc()) {
        // Assign the fetched score to the company, match by company username, not freelancer
        if (isset($companies[$row['freelancer_username']])) {
            $companies[$row['freelancer_username']]['score'] = $row['score'];
        }
    
}
} else {
    echo "No company scores found.<br>";
}

// Fetch freelancer scores using prepared statements
$freelancerScoresQuery = $conn->prepare("SELECT freelancer_username, score FROM freelancer_scores");
if ($freelancerScoresQuery === false) {
    die("Error in preparing freelancer scores query: " . $conn->error);
}
$freelancerScoresQuery->execute();
$freelancerScoresResult = $freelancerScoresQuery->get_result();

if (!$freelancerScoresResult) {
    die("Freelancer Scores Query failed: " . $freelancerScoresQuery->error);
}

if ($freelancerScoresResult->num_rows > 0) {
    while ($row = $freelancerScoresResult->fetch_assoc()) {
        // Assign the fetched score to the freelancer
        if (isset($freelancers[$row['freelancer_username']])) {
            $freelancers[$row['freelancer_username']]['score'] = $row['score'];
        }
    }
} else {
    echo "No freelancer scores found.<br>";
}

// Gale-Shapley Algorithm with Score Comparison
$matches = []; // To store the final matches
$freelancerMatches = []; // Keep track of matched freelancers
$freeCompanies = array_keys($companies); // All companies are initially free

// Define a threshold score difference for matching
$scoreThreshold = 5;

while (!empty($freeCompanies)) {
    $company = array_shift($freeCompanies); // Pick the first free company
    $preferences = $companies[$company]['preferences']; // Get the company's preferences
    $companyScore = $companies[$company]['score']; // Get the company's score

    foreach ($preferences as $freelancer) {
        // If the freelancer is not matched yet, match with the company
        if (!isset($freelancerMatches[$freelancer])) {
            $freelancerScore = $freelancers[$freelancer]['score']; // Get the freelancer's score

            // Compare scores to see if they are within the threshold
            if (abs($companyScore - $freelancerScore) <= $scoreThreshold) {
                // If their scores are close enough, proceed with the match
                $matches[$company] = $freelancer;
                $freelancerMatches[$freelancer] = $company;
                break;
            }
        } else {
            // If the freelancer is already matched, check preferences and score
            $currentCompany = $freelancerMatches[$freelancer];
            $freelancerPreferences = $freelancers[$freelancer]['preferences'];

            // Compare preferences and scores
            if (array_search($company, $freelancerPreferences) < array_search($currentCompany, $freelancerPreferences)) {
                // If freelancer prefers the new company more and scores are close, update the match
                $freelancerScore = $freelancers[$freelancer]['score'];
                if (abs($companyScore - $freelancerScore) <= $scoreThreshold) {
                    // If the scores are within the threshold
                    $matches[$company] = $freelancer;
                    $freelancerMatches[$freelancer] = $company;

                    // Make the previous company free again
                    unset($matches[$currentCompany]);
                    $freeCompanies[] = $currentCompany;
                    break;
                }
            }
        }
    }
}

// Display Matches
echo "<br><br><strong>Final Matches:</strong><br>";
foreach ($matches as $company => $freelancer) {
    echo "Company: " . $company . " is matched with Freelancer: " . $freelancer . "<br>";
}

// Close connection
$conn->close();
?>
