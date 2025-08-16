<?php
include('config.php');

if (isset($_POST["btnDelete"])) {
    $u_id = $_POST["txtId"] ?? null;

    if ($u_id) {
        $dms->query("DELETE FROM events WHERE id='$u_id'");
        echo "<div class='alert alert-success'>event deleted successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>No event ID provided</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage events</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom Styles (if any) -->
    <style>
        body {
            background-color: #f4f6f9;
        }
        .content-wrapper {
            padding: 20px;
        }
        .card-header .card-title {
            float: none;
        }
        .card-tools {
            float: right;
        }
    </style>
</head>
<body>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Events</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Events</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manage Events</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-hover  table-light table-striped">
                  <thead class="table-secondary-subtle text-center fw-bold">

                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $events = $dms->query("SELECT * FROM events");
                        while (list($id, $ename, $location, $date) = $events->fetch_row()) {
                            echo "<tr>
                                <td>$id</td>
                                <td>$ename</td>
                                <td>$location</td>
                                <td>$date</td>
                                <td class='d-flex justify-content-center align-items-center'>
                                    <button type='button' class='btn btn-info btn-sm me-2' data-bs-toggle='modal' data-bs-target='#eventViewModal'
                                        data-id='$id'
                                        data-ename='$ename'
                                        data-location='$location'
                                        data-date='$date'
                                        title='View Events'>
                                        <i class='fas fa-eye'></i>
                                    </button>

                                    <!-- Delete Button - now opens confirmation modal -->
                                    <button type='button' class='btn btn-danger btn-sm me-2' data-bs-toggle='modal' data-bs-target='#deleteConfirmModal' data-id='$id' title='Delete event'>
                                        <i class='fas fa-trash-alt'></i>
                                    </button>
                                    
                                    <!-- This form is now submitted by the modal's JS -->
                                    <form id='deleteForm-$id' action='home.php?page=6' method='post' class='me-2' style='display:none;'>
                                        <input type='hidden' name='txtId' value='$id'>
                                        <button type='submit' name='btnDelete'></button>
                                    </form>

                                    <form action='home.php?page=3' method='post' data-bs-toggle='tooltip' title='Edit Events'>
                                        <input type='hidden' name='id' value='$id'>
                                        <button type='submit' name='btnEdit' class='btn btn-warning btn-sm'>
                                            <i class='fas fa-edit'></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
            </div>
        </div>
    </section>
</div>

<!-- View event Modal -->
<div class="modal fade" id="eventViewModal" tabindex="-1" aria-labelledby="eventViewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventViewModalLabel">Events Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="view-id"></span></p>
                <p><strong>Event Name:</strong> <span id="view-ename"></span></p>
                <p><strong>Location:</strong> <span id="view-location"></span></p>
                <p><strong>Date:</strong> <span id="view-date"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this events? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Initialize Tooltips & Modal -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // View Modal
    var eventViewModal = document.getElementById('eventViewModal');
    if (eventViewModal) {
        eventViewModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            document.getElementById('view-id').textContent = button.getAttribute('data-id');
            document.getElementById('view-ename').textContent = button.getAttribute('data-ename');
            document.getElementById('view-location').textContent = button.getAttribute('data-location');
            document.getElementById('view-date').textContent = button.getAttribute('data-date');
        });
    }

    // Delete Confirmation Modal
    var deleteConfirmModal = document.getElementById('deleteConfirmModal');
    if (deleteConfirmModal) {
        let eventIdToDelete = null;

        // When the modal is shown, get the event ID from the button that triggered it
        deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            eventIdToDelete = button.getAttribute('data-id');
        });

        // When the 'Delete' button inside the modal is clicked, submit the correct form
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (eventIdToDelete) {
                const form = document.getElementById(`deleteForm-${eventIdToDelete}`);
                if (form) {
                    form.submit();
                }
            }
        });
    }
});
</script>

</body>
</html>
