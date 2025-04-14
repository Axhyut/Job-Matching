<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "fmarket");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch company preferences
$companyQuery = "SELECT company_username, first_pref, second_pref, third_pref FROM company_preference";
$companyResult = $conn->query($companyQuery);

if (!$companyResult) {
    die("Company Query failed: " . $conn->error);
}

$companies = [];
if ($companyResult->num_rows > 0) {
    echo "Company Preferences:<br>";
    while ($row = $companyResult->fetch_assoc()) {
        $companies[$row['company_username']] = [
            $row['first_pref'],
            $row['second_pref'],
            $row['third_pref']
        ];
        echo "Company: " . $row['company_username'] . " -> First: " . $row['first_pref'] . ", Second: " . $row['second_pref'] . ", Third: " . $row['third_pref'] . "<br>";
    }
} else {
    echo "No company preferences found.<br>";
}

// Fetch freelancer preferences
$freelancerQuery = "SELECT freelancer_username, first_pref, second_pref, third_pref FROM freelancer_preference";
$freelancerResult = $conn->query($freelancerQuery);

if (!$freelancerResult) {
    die("Freelancer Query failed: " . $conn->error);
}

$freelancers = [];
if ($freelancerResult->num_rows > 0) {
    echo "<br>Freelancer Preferences:<br>";
    while ($row = $freelancerResult->fetch_assoc()) {
        $freelancers[$row['freelancer_username']] = [
            $row['first_pref'],
            $row['second_pref'],
            $row['third_pref']
        ];
        echo "Freelancer: " . $row['freelancer_username'] . " -> First: " . $row['first_pref'] . ", Second: " . $row['second_pref'] . ", Third: " . $row['third_pref'] . "<br>";
    }
} else {
    echo "No freelancer preferences found.<br>";
}

// Gale-Shapley Algorithm
$matches = []; // To store the final matches
$freelancerMatches = []; // Keep track of matched freelancers
$freeCompanies = array_keys($companies); // All companies are initially free

while (!empty($freeCompanies)) {
    $company = array_shift($freeCompanies); // Pick the first free company
    $preferences = $companies[$company]; // Get the company's preferences

    foreach ($preferences as $freelancer) {
        // If the freelancer is not matched yet, match with the company
        if (!isset($freelancerMatches[$freelancer])) {
            $matches[$company] = $freelancer;
            $freelancerMatches[$freelancer] = $company;
            break;
        } else {
            // If the freelancer is already matched, check preferences
            $currentCompany = $freelancerMatches[$freelancer];
            $freelancerPreferences = $freelancers[$freelancer];

            // If the freelancer prefers the new company, update the match
            if (array_search($company, $freelancerPreferences) < array_search($currentCompany, $freelancerPreferences)) {
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

// Display Matches
echo "<br><br><strong>Final Matches:</strong><br>";
foreach ($matches as $company => $freelancer) {
    echo "Company: " . $company . " is matched with Freelancer: " . $freelancer . "<br>";
}

// Close connection
$conn->close();
?>
