<?php
// Include the database connection file
include("config.php");
?>

<style>
    .causes-item .progress {
        height: 10px;
        border-radius: 0;
        margin-bottom: 20px;
    }
    .progress-bar {
        background-color: #6c5ce7; /* Custom color */
        color: white;
        font-weight: bold;
        font-size: 12px;
    }
</style>


<div class="container-fluid causes">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h5 class="text-uppercase text-custom">Recent Causes</h5>
            <h1 class="mb-4">The environment needs our protection</h1>
            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley.</p>
        </div>
        <div class="row g-2">
            <?php
            // Fetch data from the 'campaigns' table where the status is 'Active'
            $sql = "SELECT * FROM campaigns WHERE status = 'Active'";
            $result = $dms->query($sql);

            if ($result->num_rows > 0) {
                // Loop through each row and display the data
                while ($row = $result->fetch_assoc()) {
                    $goal = $row["goal_amount"];
                    $raised = $row["total_raised"]; // Assuming you have a total_raised column

                    // Calculate the progress percentage
                    $progress_percent = ($goal > 0) ? ($raised / $goal) * 100 : 0;
            ?>
            <div class="col-lg-3 col-md-6">
                <div class="causes-item">
                    <div class="causes-img">
                        <img src="<?php echo htmlspecialchars($row["file_path"]); ?>" class="img-fluid w-100" alt="Cause Image">
                        <div class="causes-link pb-2 px-3">
                            <small class="text-dark"><i class="fas fa-chart-bar text-custom me-2"></i>Goal: $<?php echo number_format($goal); ?></small>
                            <small class="text-dark"><i class="fa fa-thumbs-up text-custom me-2"></i>Raised: $<?php echo number_format($raised); ?></small>
                        </div>
                        <div class="causes-dination p-2">
                            <a class="btn-hover-bg btn btn-custom text-white py-2 px-3" href="donate.php?id=<?php echo $row['id']; ?>">Donate Now</a>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $progress_percent; ?>%" aria-valuenow="<?php echo round($progress_percent); ?>" aria-valuemin="0" aria-valuemax="100">
                            <span><?php echo round($progress_percent); ?>%</span>
                        </div>
                    </div>
                    <div class="causes-content p-4">
                        <h4 class="mb-3"><?php echo htmlspecialchars($row["name"]); ?></h4>
                        <p class="mb-4"><?php echo htmlspecialchars($row["descriptions"]); ?></p>
                        <a class="btn-hover-bg btn btn-custom text-white py-2 px-3" href="#">Read More</a>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p>No active campaigns found.</p>";
            }

            // Close the database connection
            $dms->close();
            ?>
        </div>
    </div>
</div>