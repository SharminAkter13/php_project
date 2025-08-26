<?php
include("../connect.php"); // adjust path if needed

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Create (Save)
    if (isset($_POST['name']) && isset($_POST['status']) && isset($_POST['amount']) && !isset($_POST['upid']) && !isset($_POST['id'])) {
        $name   = $dms->real_escape_string($_POST['name']);
        $status = $dms->real_escape_string($_POST['status']);
        $amount = (float) $_POST['amount'];

        $query = "INSERT INTO funds (name, status, collected_amount) VALUES ('$name', '$status', $amount)";
        if ($dms->query($query)) {
            echo "<span class='text-success'>Fund saved successfully</span>";
        } else {
            echo "<span class='text-danger'>Error: " . $dms->error . "</span>";
        }
    }

    // Update
    if (isset($_POST['upid'])) {
        $id     = (int) $_POST['upid'];
        $name   = $dms->real_escape_string($_POST['name']);
        $status = $dms->real_escape_string($_POST['status']);
        $amount = (float) $_POST['amount'];

        $query = "UPDATE funds SET name='$name', status='$status', collected_amount=$amount WHERE id=$id";
        if ($dms->query($query)) {
            echo "<span class='text-primary'>Fund updated successfully</span>";
        } else {
            echo "<span class='text-danger'>Error: " . $dms->error . "</span>";
        }
    }

    // Delete
    if (isset($_POST['id']) && !isset($_POST['name'])) {
        $id = (int) $_POST['id'];
        $query = "DELETE FROM funds WHERE id=$id";
        if ($dms->query($query)) {
            echo "<span class='text-danger'>Fund deleted successfully</span>";
        } else {
            echo "<span class='text-danger'>Error: " . $dms->error . "</span>";
        }
    }
}
?>
