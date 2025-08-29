<?php
// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include('config.php'); // DB connection

// --- DELETE DONATION LOGIC ---
if (isset($_POST["btnDelete"])) {
    $donationId = $_POST["txtId"] ?? null;

    if ($donationId) {
        // Get the user_id of the donor who owns this donation
        $stmt = $dms->prepare("SELECT donors.user_id FROM donations 
                               LEFT JOIN donors ON donations.donor_id = donors.id 
                               WHERE donations.id = ?");
        $stmt->bind_param("i", $donationId);
        $stmt->execute();
        $stmt->bind_result($donorUserId);
        $stmt->fetch();
        $stmt->close();

        $isAdmin = isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1;
        $isOwner = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $donorUserId;

        // Only admin or owner can delete
        if (!$isAdmin && !$isOwner) {
            echo "<div class='alert alert-danger'>You do not have permission to delete this donation.</div>";
            exit;
        }

        // Delete donation
        $stmt = $dms->prepare("DELETE FROM donations WHERE id = ?");
        $stmt->bind_param("i", $donationId);
        $stmt->execute();
        $stmt->close();

        echo "<div class='alert alert-success'>Donation deleted successfully</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Donations</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid p-5">
    <h1>Manage Donations</h1>
    <table class="table table-hover table-striped">
        <thead class="bg-info text-white">
            <tr>
                <th>#ID</th>
                <th>Pledge / Campaign Name</th>
                <th>Donor Name</th>
                <th>Fund Name</th>
                <th>Payment Method</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Fetch donations with donor ownership
        $sql = "SELECT d.id, d.amount, d.date, d.donor_id, donors.name AS donor_name, donors.user_id,
                       COALESCE(p.name, c.name) AS pledge_campaign_name,
                       f.name AS fund_name,
                       pm.type AS payment_method
                FROM donations d
                LEFT JOIN donors ON d.donor_id = donors.id
                LEFT JOIN pledges p ON d.pledge_id = p.id
                LEFT JOIN campaigns c ON d.campaign_id = c.id
                LEFT JOIN funds f ON d.fund_id = f.id
                LEFT JOIN payment_methods pm ON d.payment_id = pm.id";

        $donations = $dms->query($sql);

        if ($donations && $donations->num_rows > 0) {
            while ($row = $donations->fetch_assoc()) {
                $isAdmin = isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1;
                $isOwner = isset($_SESSION['user_id']) && $_SESSION['user_id'] == ($row['user_id'] ?? 0);

                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>" . htmlspecialchars($row['pledge_campaign_name'] ?? 'N/A') . "</td>
                        <td>" . htmlspecialchars($row['donor_name'] ?? 'N/A') . "</td>
                        <td>" . htmlspecialchars($row['fund_name'] ?? 'N/A') . "</td>
                        <td>" . htmlspecialchars($row['payment_method'] ?? 'N/A') . "</td>
                        <td>" . htmlspecialchars($row['amount'] ?? 'N/A') . "</td>
                        <td>" . htmlspecialchars($row['date'] ?? 'N/A') . "</td>
                        <td class='d-flex justify-content-center'>";

                // View button (everyone)
                echo "<button class='btn btn-info btn-sm me-2' data-bs-toggle='modal' data-bs-target='#donationViewModal'
                                data-id='{$row['id']}' 
                                data-pname='" . htmlspecialchars($row['pledge_campaign_name'] ?? '') . "'
                                data-donor='" . htmlspecialchars($row['donor_name'] ?? '') . "'
                                data-fund='" . htmlspecialchars($row['fund_name'] ?? '') . "'
                                data-payment='" . htmlspecialchars($row['payment_method'] ?? '') . "'
                                data-amount='{$row['amount']}'
                                data-date='{$row['date']}'>
                                <i class='fas fa-eye'></i>
                              </button>";

                // Edit/Delete if admin OR owner
                if ($isAdmin || $isOwner) {
                    // Edit
                    echo "<form action='home.php?page=3' method='post' class='me-2'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit' name='btnEdit' class='btn btn-warning btn-sm'>
                                    <i class='fas fa-edit'></i>
                                </button>
                              </form>";
                    // Delete
                    echo "<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteConfirmModal' data-id='{$row['id']}'>
                                <i class='fas fa-trash-alt'></i>
                              </button>
                              <form id='deleteForm-{$row['id']}' action='' method='post' style='display:none;'>
                                <input type='hidden' name='txtId' value='{$row['id']}'>
                                <button type='submit' name='btnDelete'></button>
                              </form>";
                }

                echo "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='8' class='text-center'>No donations found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="donationViewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Donation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="view-id"></span></p>
                <p><strong>Pledge/Campaign Name:</strong> <span id="view-pname"></span></p>
                <p><strong>Donor Name:</strong> <span id="view-donor"></span></p>
                <p><strong>Fund Name:</strong> <span id="view-fund"></span></p>
                <p><strong>Payment Method:</strong> <span id="view-payment"></span></p>
                <p><strong>Amount:</strong> <span id="view-amount"></span></p>
                <p><strong>Date:</strong> <span id="view-date"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this donation? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // View Modal
    var donationViewModal = document.getElementById('donationViewModal');
    donationViewModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('view-id').textContent = button.getAttribute('data-id');
        document.getElementById('view-pname').textContent = button.getAttribute('data-pname');
        document.getElementById('view-donor').textContent = button.getAttribute('data-donor');
        document.getElementById('view-fund').textContent = button.getAttribute('data-fund');
        document.getElementById('view-payment').textContent = button.getAttribute('data-payment');
        document.getElementById('view-amount').textContent = button.getAttribute('data-amount');
        document.getElementById('view-date').textContent = button.getAttribute('data-date');
    });

    // Delete Modal
    var deleteConfirmModal = document.getElementById('deleteConfirmModal');
    let donationIdToDelete = null;
    deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
        donationIdToDelete = event.relatedTarget.getAttribute('data-id');
    });
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (donationIdToDelete) {
            document.getElementById('deleteForm-' + donationIdToDelete).submit();
        }
    });
});
</script>
</body>
</html>