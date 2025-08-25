<?php
// Include the database connection script
include("config.php");

// Set content type to JSON for a cleaner API-like response
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];

try {
    // Handle Save operation (Create)
    if (isset($_POST['save_name'])) {
        $name = $connection->real_escape_string(trim($_POST['save_name']));
        $status = $connection->real_escape_string(trim($_POST['status']));
        $collected_amount = (int)$_POST['collected_amount'];

        $sql = "INSERT INTO funds (name, status, collected_amount) VALUES ('$name', '$status', $collected_amount)";
        if ($connection->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Fund saved successfully.";
        } else {
            throw new Exception("Error: " . $connection->error);
        }
    }

    // Handle Update operation
    else if (isset($_POST['update_id'])) {
        $id = (int)$_POST['update_id'];
        $name = $connection->real_escape_string(trim($_POST['name']));
        $status = $connection->real_escape_string(trim($_POST['status']));
        $collected_amount = (int)$_POST['collected_amount'];

        $sql = "UPDATE funds SET name='$name', status='$status', collected_amount=$collected_amount WHERE id=$id";
        if ($connection->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Fund updated successfully.";
        } else {
            throw new Exception("Error: " . $connection->error);
        }
    }

    // Handle Delete operation
    else if (isset($_POST['delete_id'])) {
        $id = (int)$_POST['delete_id'];
        $sql = "DELETE FROM funds WHERE id=$id";
        if ($connection->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Fund deleted successfully.";
        } else {
            throw new Exception("Error: " . $connection->error);
        }
    }

    // Handle Read operation (Display data)
    else if (isset($_POST['action']) && $_POST['action'] === 'read') {
        $sql = "SELECT id, name, status, collected_amount FROM funds ORDER BY id ASC";
        $result = $connection->query($sql);
        $funds = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $funds[] = $row;
            }
        }
        echo json_encode(['success' => true, 'funds' => $funds]);
        exit; // Exit after sending JSON to prevent further output
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

// Close the database connection
$connection->close();

// Send the JSON response back to the client
echo json_encode($response);
