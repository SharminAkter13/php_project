<?php
// // Database connection
// // include('db_connect.php');

// // Example: Fetch all beneficiaries from DB
// $beneficiaries = [
//     ["id" => 1, "name" => "John Doe", "email" => "john@example.com", "phone" => "01710000000", "address" => "Dhaka, Bangladesh", "needs" => "Medical support"],
//     ["id" => 2, "name" => "Jane Smith", "email" => "jane@example.com", "phone" => "01820000000", "address" => "Chittagong, Bangladesh", "needs" => "Food & shelter"]
// ];

// // Delete action
// if (isset($_GET['delete'])) {
//     $deleteId = $_GET['delete'];
//     // mysqli_query($conn, "DELETE FROM beneficiaries WHERE id=$deleteId");
//     echo "<div class='alert alert-success text-center'>Beneficiary ID $deleteId deleted successfully!</div>";
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Beneficiaries - DonorHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .table-wrapper {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="table-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="fas fa-users me-2"></i>Manage Beneficiaries</h4>
            <input type="text" id="searchBox" class="form-control w-25" placeholder="Search...">
        </div>

        <table class="table table-hover" id="beneficiaryTable">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Needs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($beneficiaries as $b): ?>
                <tr>
                    <td><?= $b['id'] ?></td>
                    <td><?= $b['name'] ?></td>
                    <td><?= $b['email'] ?></td>
                    <td><?= $b['phone'] ?></td>
                    <td><?= $b['address'] ?></td>
                    <td><?= $b['needs'] ?></td>
                    <td>
                        <a href="edit_beneficiary.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <a href="?delete=<?= $b['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- FontAwesome & Bootstrap JS -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Search Filter Script -->
<script>
document.getElementById("searchBox").addEventListener("keyup", function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#beneficiaryTable tbody tr");
    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

</body>
</html>
