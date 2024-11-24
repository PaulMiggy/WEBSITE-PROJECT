<?php
// bookform.php

// Database connection details
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "book_db"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and capture form data
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $address = sanitizeInput($_POST['address']);
    $package = sanitizeInput($_POST['package']);
    $location = sanitizeInput($_POST['location']);
    $guest = sanitizeInput($_POST['guest']);
    $arrival = sanitizeInput($_POST['arrival']); // Arrival date
    $departure = sanitizeInput($_POST['departure']); // Departure date

    // Initialize the schedule variable
    $schedule = [];

    // Determine the schedule based on the selected package
    switch ($package) {
        case "Cultural Immersion":
            $schedule = [
                "Day 1: Orientation and welcome lunch, Traditional dance performance.",
                "Day 2: Cooking class, Visit to local artisan workshops, Dinner at a local restaurant.",
                "Day 3: Guided tour of the local market, Farewell lunch."
            ];
            break;
        case "Beach Getaway":
            $schedule = [
                "Day 1: Welcome drinks, Beach games.",
                "Day 2: Snorkeling tour, Lunch at a beachfront restaurant, Sunset cruise.",
                "Day 3: Free day for relaxation, Optional water sports activities."
            ];
            break;
        case "Wellness Retreat":
            $schedule = [
                "Day 1: Welcome yoga session, Healthy dinner.",
                "Day 2: Spa treatments, Guided meditation, Nature walk.",
                "Day 3: Yoga class, Healthy cooking workshop."
            ];
            break;
        case "Adventure Tour":
            $schedule = [
                "Day 1: Briefing for activities, Beach bonfire.",
                "Day 2: Zip-lining, Hiking, Dinner at a local restaurant.",
                "Day 3: Scuba diving, Free time to explore."
            ];
            break;
        case "Island Hopping":
            $schedule = [
                "Day 1: Welcome dinner.",
                "Day 2: Island hopping tour, Snorkeling, Beach picnic.",
                "Day 3: Free time for exploration, Optional kayaking."
            ];
            break;
        case "Food Tour":
            $schedule = [
                "Day 1: Welcome dinner at a local restaurant.",
                "Day 2: Food tasting tour, Visit to a local market.",
                "Day 3: Cooking demonstration, Free time for personal exploration."
            ];
            break;
        case "Historical Tour":
            $schedule = [
                "Day 1: Historical overview, Welcome dinner.",
                "Day 2: Guided tour of historical sites, Visit to museums.",
                "Day 3: Heritage walk, Free time for personal exploration."
            ];
            break;
        case "Staycation Package":
            $schedule = [
                "Day 1: Welcome drinks, Spa services.",
                "Day 2: Fine dining experience, City tour.",
                "Day 3: Relaxation day, Optional activities."
            ];
            break;
        default:
            $schedule[] = "No activities scheduled for this package.";
    }

    // If the duration is greater than 3, add personal time
    $duration = (int)$_POST['duration'];
    if ($duration > 3) {
        for ($i = 4; $i <= $duration; $i++) {
            $schedule[] = "Day $i: Personal time for relaxation and exploration.";
        }
    }
    header('Content-Type: application/json');

    // Prepare the response array
    $response = [
        'success' => true,
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'package' => $package,
        'location' => $location,
        'guest' => $guest,
        'arrival' => $arrival, // Include arrival date
        'departure' => $departure, // Include departure date
        'schedule' => $schedule
    ];

    // Insert booking details into the database
    $stmt = $conn->prepare("INSERT INTO book_form (name, email, phone, address, package, location, guest, arrival, departure) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssiss", $name, $email, $phone, $address, $package, $location, $guest, $arrival, $departure);

    if ($stmt->execute()) {
        // Booking successful
        echo json_encode($response);
    exit;
    } else {
        echo json_encode(['success' => false, 'message' => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
