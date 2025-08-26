<?php
// Include the database connection file
include("config.php");
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Funds with jQuery</title>

    <!-- Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin: 100px auto;
        }
        .form-container {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .table-container {
            margin-top: 30px;
        }
        th {
            background-color: #f2f2f2;
            cursor: pointer;
        }
        tr.selected {
            background-color: #cce5ff !important;
        }
        .result-message {
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Manage Funds</h2>
        
        <!-- Display messages here -->
        <div class="result-message text-center"></div>

        <!-- Form for CRUD operations -->
        <div class="form-container">
            <form id="funds-form">
                <input type="hidden" id="fund_id" name="id">
                <div class="mb-3">
                    <label for="fund_name" class="form-label">Fund Name</label>
                    <input type="text" class="form-control" id="fund_name" name="fund_name" placeholder="Enter fund name" required>
                </div>
                <div class="mb-3">
                    <label for="fund_status" class="form-label">Status</label>
                    <select class="form-select" id="fund_status" name="fund_status" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="collected_amount" class="form-label">Collected Amount</label>
                    <input type="number" class="form-control" id="collected_amount" name="collected_amount" placeholder="Enter collected amount" value="0" required>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-primary" id="save-btn">Save</button>
                    <button type="button" class="btn btn-warning" id="update-btn" disabled>Update</button>
                    <button type="button" class="btn btn-danger" id="delete-btn" disabled>Delete</button>
                    <button type="button" class="btn btn-secondary" id="reset-btn">Reset</button>
                </div>
            </form>
        </div>

        <!-- Table to display existing funds -->
        <div class="table-container">
            <h4>Existing Funds</h4>
            <table class="table table-striped table-hover" id="funds_table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Collected Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded here via jQuery -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS from CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Function to load data into the table
            function loadFunds() {
                $.ajax({
                    url: "funds_curd.php",
                    type: "POST",
                    dataType: "json",
                    data: { action: 'read' },
                    success: function(response) {
                        if (response.success) {
                            var tableBody = $('#funds_table tbody');
                            tableBody.empty(); // Clear existing data
                            response.funds.forEach(function(fund) {
                                tableBody.append(
                                    `<tr data-id="${fund.id}">
                                        <td>${fund.id}</td>
                                        <td>${fund.name}</td>
                                        <td>${fund.status}</td>
                                        <td>${fund.collected_amount}</td>
                                    </tr>`
                                );
                            });
                        } else {
                            $('.result-message').text('Error loading data: ' + response.message).css('color', 'red');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('.result-message').text('AJAX Error: ' + textStatus + ' - ' + errorThrown).css('color', 'red');
                    }
                });
            }

            // Initial load of funds on page load
            loadFunds();

            // Handle Save button click
            $('#save-btn').click(function() {
                var name = $('#fund_name').val();
                var status = $('#fund_status').val();
                var collected_amount = $('#collected_amount').val();

                $.ajax({
                    url: "funds_curd.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        save_name: name,
                        status: status,
                        collected_amount: collected_amount
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.result-message').text(response.message).css('color', 'green');
                            loadFunds(); // Reload the table
                            resetForm();
                        } else {
                            $('.result-message').text(response.message).css('color', 'red');
                        }
                    }
                });
            });

            // Handle Update button click
            $('#update-btn').click(function() {
                var id = $('#fund_id').val();
                var name = $('#fund_name').val();
                var status = $('#fund_status').val();
                var collected_amount = $('#collected_amount').val();

                $.ajax({
                    url: "funds_curd.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        update_id: id,
                        name: name,
                        status: status,
                        collected_amount: collected_amount
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.result-message').text(response.message).css('color', 'green');
                            loadFunds();
                            resetForm();
                        } else {
                            $('.result-message').text(response.message).css('color', 'red');
                        }
                    }
                });
            });

            // Handle Delete button click
            $('#delete-btn').click(function() {
                var id = $('#fund_id').val();

                if (confirm("Are you sure you want to delete this fund?")) {
                    $.ajax({
                        url: "funds_curd.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                            delete_id: id
                        },
                        success: function(response) {
                            if (response.success) {
                                $('.result-message').text(response.message).css('color', 'green');
                                loadFunds();
                                resetForm();
                            } else {
                                $('.result-message').text(response.message).css('color', 'red');
                            }
                        }
                    });
                }
            });

            // Handle Reset button click
            $('#reset-btn').click(function() {
                resetForm();
            });

            // Handle table row click to populate the form
            $('#funds_table tbody').on('click', 'tr', function() {
                // Remove selected class from all rows
                $('#funds_table tbody tr').removeClass('selected');
                // Add selected class to the clicked row
                $(this).addClass('selected');

                var fund_id = $(this).find('td:eq(0)').text();
                var fund_name = $(this).find('td:eq(1)').text();
                var fund_status = $(this).find('td:eq(2)').text();
                var collected_amount = $(this).find('td:eq(3)').text();

                // Fill the form with the selected data
                $('#fund_id').val(fund_id);
                $('#fund_name').val(fund_name);
                $('#fund_status').val(fund_status);
                $('#collected_amount').val(collected_amount);

                // Enable the update and delete buttons
                $('#update-btn').prop('disabled', false);
                $('#delete-btn').prop('disabled', false);
                $('#save-btn').prop('disabled', true);
            });

            // Function to reset the form and button states
            function resetForm() {
                $('#funds-form')[0].reset();
                $('#fund_id').val('');
                $('#update-btn').prop('disabled', true);
                $('#delete-btn').prop('disabled', true);
                $('#save-btn').prop('disabled', false);
                $('.result-message').text('').css('color', '');
                $('#funds_table tbody tr').removeClass('selected');
            }
        });
    </script>
</body>
</html>
