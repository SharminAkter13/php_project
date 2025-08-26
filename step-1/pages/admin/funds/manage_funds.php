<?php
// Ensure this path is correct based on your file structure
include 'config.php';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Funds Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Funds Management</h5>
            </div>
            <div class="card-body">
                <span class="result mb-3 d-block"></span>
                <form method="POST" id="fundForm">
                    <input type="hidden" id="id" name="id">

                    <div class="mb-3">
                        <label for="f_name" class="form-label">Fund Name</label>
                        <input type="text" id="f_name" name="f_name" class="form-control" placeholder="Enter Fund name" required>
                    </div>

                    <div class="mb-3">
                        <label for="f_status" class="form-label">Status</label>
                        <select id="f_status" name="f_status" class="form-select" required>
                            <option value="">-- Select Status --</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="f_amount" class="form-label">Collected Amount</label>
                        <input type="number" id="f_amount" name="f_amount" class="form-control" placeholder="Enter Collected Amount" required>
                    </div>

                    <!-- Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <input type="button" class="btn btn-success me-md-2" id="save" value="Save">
                        <input type="button" class="btn btn-primary me-md-2" id="update" value="Update">
                        <input type="button" class="btn btn-danger me-md-2" id="delete" value="Delete">
                        <input type="button" class="btn btn-secondary" id="reset" value="Reset">
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="mt-4">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Fund Name</th>
                        <th>Status</th>
                        <th>Collected Amount</th>
                    </tr>
                </thead>
                <tbody id="data">
                    <?php
                    $data = $dms->query("SELECT * FROM funds");
                    while ($row = $data->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['status']}</td>
                                <td>{$row['collected_amount']}</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery CRUD Logic -->
    <script type="text/javascript">
        $(function () {
            // Save
            $("#save").click(function () {
                var name = $("#f_name").val();
                var status = $("#f_status").val();
                var amount = $("#f_amount").val();
                $.ajax({
                    url: "ajax/funds_crud.php",
                    type: "post",
                    data: {
                        "name": name,
                        "status": status,
                        "amount": amount
                    },
                    success: function (data) {
                        $(".result").html(data);
                        location.reload();
                    }
                }).fail(function() {
                    $(".result").html("<span class='text-danger'>AJAX request failed</span>");
                });
            });

            // Update
            $("#update").click(function () {
                var id = $("#id").val();
                var name = $("#f_name").val();
                var status = $("#f_status").val();
                var amount = $("#f_amount").val();
                $.ajax({
                    url: "ajax/funds_crud.php",
                    type: "post",
                    data: {
                        "upid": id,
                        "name": name,
                        "status": status,
                        "amount": amount
                    },
                    success: function (data) {
                        $(".result").html(data);
                        location.reload();
                    }
                }).fail(function() {
                    $(".result").html("<span class='text-danger'>AJAX request failed</span>");
                });
            });

            // Delete
            $("#delete").click(function () {
                var id = $("#id").val();
                $.ajax({
                    url: "ajax/funds_crud.php",
                    type: "post",
                    data: {
                        "id": id
                    },
                    success: function (data) {
                        $(".result").html(data);
                        location.reload();
                    }
                }).fail(function() {
                    $(".result").html("<span class='text-danger'>AJAX request failed</span>");
                });
            });

            // Fill form when clicking row
            $("#data tr").on("click", function () {
                var id = $(this).find("td:eq(0)").text().trim();
                var name = $(this).find("td:eq(1)").text().trim();
                var status = $(this).find("td:eq(2)").text().trim();
                var amount = $(this).find("td:eq(3)").text().trim();

                $("#id").val(id);
                $("#f_name").val(name);
                $("#f_status").val(status);
                $("#f_amount").val(amount);
            });

            // Reset
            $("#reset").click(function () {
                $("#id").val("");
                $("#f_name").val("");
                $("#f_status").val("");
                $("#f_amount").val("");
                $(".result").html("<span class='text-danger'>Form reset</span>");
            });
        });
    </script>
</body>
</html>
