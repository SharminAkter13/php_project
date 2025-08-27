<?php
// Include database connection
include 'config.php';

// Prepare response
$response = [
    'success' => false,
    'message' => 'An unknown error occurred.',
    'data' => []
];

try {
    // Corrected query to get only upcoming events
    // It filters events where the 'date' is in the future.
    $current_datetime = date('Y-m-d H:i:s');
    $query = "SELECT `name`, `location`, `descriptions`, `date`, `image_url` FROM `events` WHERE `date` > ? ORDER BY `date` ASC";

    // Use a prepared statement to prevent SQL injection and handle the date comparison
    $stmt = $dms->prepare($query);
    $stmt->bind_param("s", $current_datetime);
    $stmt->execute();
    $result = $stmt->get_result();

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
    <title>Upcoming Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .event-item {
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .event-item img {
            width: 100%;
            height: auto;
        }
        .event-content {
            padding: 20px;
        }
        .event-meta p {
            display: inline-block;
            margin-right: 15px;
            color: #555;
        }
        .btn-custom {
            background-color: #0c6b6c;
            color: white;
        }
    </style>
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
        // Clear any existing content to prevent duplication
        eventsContainer.innerHTML = '';

        data.data.forEach(event => {
            const eventItem = `
                <div class="col-lg-6">
                    <div class="event-item">
                        <img src="${event.image_url}" alt="${event.name}">
                        <div class="event-content">
                            <div class="event-meta">
                                <p><i class="fa fa-calendar-alt"></i>${event.date}</p>
                                <p><i class="far fa-clock"></i>${event.event_time}</p>
                                <p><i class="fa fa-map-marker-alt"></i>${event.location}</p>
                            </div>
                            <div class="event-text">
                                <h3>${event.name}</h3>
                                <p>${event.descriptions}</p>
                                <a class="btn btn-custom" href="javascript:void(0);">Join Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            eventsContainer.insertAdjacentHTML('beforeend', eventItem);
        });
    } else {
        // Display a message if no upcoming events are found
        eventsContainer.innerHTML = `
            <div class="col-12 text-center">
                <p>No upcoming events found at this time.</p>
            </div>
        `;
        console.error('Failed to fetch events or no upcoming events:', data.message);
    }
});
</script>

</body>
</html>