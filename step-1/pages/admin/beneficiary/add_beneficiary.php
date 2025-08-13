<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['beneficiary_name'];
    $email = $_POST['beneficiary_email'];
    $phone = $_POST['beneficiary_phone'];
    $address = $_POST['beneficiary_address'];
    $needs = $_POST['beneficiary_needs'];

    // Example SQL (adjust table/column names)
    $query = "INSERT INTO beneficiaries (name, email, phone, address, required_support) VALUES ('$name', '$email', '$phone', '$address', '$needs')";
    mysqli_query($dms, $query);
    
    echo "<div class='alert alert-success text-center'>Beneficiary added successfully!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Beneficiary - DonorHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container my-5 p-5">
    <div class="row">
        <div class="col-md-9 offset-md-3">

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">

                        <h4 class="mb-0"><i class="fas fa-hand-holding-heart me-2"></i>Add Beneficiary</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="beneficiary_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="beneficiary_name" name="beneficiary_name" placeholder="Enter beneficiary's full name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="beneficiary_email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="beneficiary_email" name="beneficiary_email" placeholder="Enter email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="beneficiary_phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="beneficiary_phone" name="beneficiary_phone" placeholder="Enter phone number" required>
                                </div>

                                <div class="mb-3">
                                    <label for="beneficiary_address" class="form-label">Address</label>
                                    <textarea class="form-control" id="beneficiary_address" name="beneficiary_address" rows="3" placeholder="Enter full address" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="beneficiary_needs" class="form-label">Needs / Support Required</label>
                                    <textarea class="form-control" id="beneficiary_needs" name="beneficiary_needs" rows="3" placeholder="Describe the needs" required></textarea>
                                </div>

                                <div class="text-end">
                                    <button type="reset" class="btn btn-secondary me-2">Reset</button>
                                    <button type="submit" class="btn btn-primary">Add Beneficiary</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap & FontAwesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
