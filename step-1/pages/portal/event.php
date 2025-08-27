<?php
// Set up error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
// Make sure this file correctly connects to your database and sets the $dms variable
if (file_exists('config.php')) {
    include 'config.php';
} else {
    die("Error: config.php file not found. Please create it with your database connection details.");
}

// Prepare response
$response = [
    'success' => false,
    'message' => 'An unknown error occurred.',
    'data' => []
];

try {
    // Corrected query to get upcoming events that are "Active"
    // The query filters events with a date greater than or equal to the current date
    // and where the status is 'Active'.
    $query = "SELECT `name`, `location`, `descriptions`, `date`, `image_url` 
              FROM `events` 
              WHERE `date` >= CURDATE() AND `status` = 'Active' 
              ORDER BY `date` ASC";
    
    // Execute the query
    $result = $dms->query($query);

    $events = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $event_date = date("d-M-y", strtotime($row['date']));
            $event_time = date("H:i", strtotime($row['date']));

            $events[] = [
                'name' => $row['name'],
                'location' => $row['location'],
                'date' => $event_date,
                'descriptions' => $row['descriptions'],
                'event_time' => $event_time,
                'image_url' => $row['image_url'],
            ];
        }
    }

    $response['success'] = true;
    $response['message'] = 'Events fetched successfully.';
    $response['data'] = $events;

} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
} finally {
    if (isset($dms)) {
        $dms->close();
    }
}

// Encode response as JSON for JavaScript
$jsonData = json_encode($response);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Charity Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="event">
    <div class="container">
        <div class="section-header text-center">
            <p>Upcoming Events</p>
            <h2>Be ready for our upcoming charity events</h2>
        </div>
        <div class="row" id="events-list">
            </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const data = <?php echo $jsonData; ?>;
    const eventsContainer = document.getElementById('events-list');

    // Check if the API call was successful and returned data
    if (data.success && data.data.length > 0) {
        eventsContainer.innerHTML = ''; 
        data.data.forEach(event => {
            const eventItem = `
                <div class="col-lg-6">
                    <div class="event-item">
                        <img src="${event.image_url}" alt="${event.name}" class="event-img">
                        <div class="event-content">
                            <div class="event-meta">
                                <p><i class="fa fa-calendar-alt"></i>${event.date}</p>
                                <p><i class="far fa-clock"></i>${event.event_time}</p>
                                <p><i class="fa fa-map-marker-alt"></i>${event.location}</p>
                            </div>
                            <div class="event-text">
                                <h3>${event.name}</h3>
                                <p>${event.descriptions}</p>
                                <a class="btn btn-custom" href="#">Join Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            eventsContainer.insertAdjacentHTML('beforeend', eventItem);
        });
    } else {
        // Display a message if no events are available
        eventsContainer.innerHTML = `
            <div class="col-12 text-center">
                <p>No upcoming events found at this time.</p>
            </div>
        `;
        console.error('Failed to fetch events or no upcoming events:', data.message);
    }
});
</script>

<script src="assets/js/script.js"></script>
</body>
</html>