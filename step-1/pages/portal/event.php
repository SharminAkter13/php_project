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
    // Query to get all upcoming events from 'events' table
    $query = "SELECT `name`, `location`, `descriptions`, `date`, `image_url` FROM `events` ORDER BY `date` ASC";
    $result = $dms->query($query); // Corrected variable from $dms to $dms

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
                'image_url' => $row['image_url'], // Corrected from 'image' to 'image_url'
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

    const staticContent = `
        <div class="col-lg-6">
            <div class="event-item">
                <img src="assets/img/img/event.jpg" alt="Image">
                <div class="event-content">
                    <div class="event-meta">
                        <p><i class="fa fa-calendar-alt"></i>17-Aug-25</p>
                        <p><i class="far fa-clock"></i>8:00 - 10:00</p>
                        <p><i class="fa fa-map-marker-alt"></i>New York</p>
                    </div>
                    <div class="event-text">
                        <h3>Uniting Voices for Global Democracy: Pledge4Peace Conference 2025</h3>
                        <p>Be part of a global gathering dedicated to resolving conflict, defending democracy, and building lasting peace through people power</p>
                        <a class="btn btn-custom" href="">Join Now</a>
                    </div>
                </div>
            </div>
        </div>
    `;

    if (data.success && data.data.length > 0) {
        eventsContainer.innerHTML = '';
        data.data.forEach(event => {
            const eventItem = `
                <div class="col-lg-6">
                    <div class="event-item">
                        <img src="${event.image_url}" alt="${event.name}">
                        <div class="event-content">
                            <div class="event-meta">
                                <p><i class="fa fa-calendar-alt"></i>${event.event_date}</p>
                                <p><i class="far fa-clock"></i>${event.event_time}</p>
                                <p><i class="fa fa-map-marker-alt"></i>${event.location}</p>
                            </div>
                            <div class="event-text">
                                <h3>${event.name}</h3>
                                <p>${event.descriptions}</p>
                                <a class="btn btn-custom" href="${event.link}">Join Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            eventsContainer.insertAdjacentHTML('beforeend', eventItem);
        });
    } else {
        console.error('Failed to fetch events:', data.message);
        eventsContainer.innerHTML = staticContent;
    }
});
</script>