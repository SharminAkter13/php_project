<!-- Add donation -->

<div class="content-wrapper" style="min-height: 2838.44px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Donations</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item active">Donate</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container donation-form-container bg-light p-5 rounded shadow-sm">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="donation-card bg-white p-4 rounded shadow-sm">
            <h2 class="text-center mb-4">Make a Donation</h2>
            <form id="donationForm">
              <div class="form-group">
                <label for="campaign">Choose a Campaign</label>
                <select class="form-control" id="campaign" required>
                  <option value="" disabled selected>Select a campaign</option>
                  <option value="Campaign1">Campaign 1</option>
                  <option value="Campaign2">Campaign 2</option>
                  <option value="Campaign3">Campaign 3</option>
                </select>
              </div>
              <div class="form-group">
                <label for="amount">Donation Amount ($)</label>
                <input type="number" class="form-control" id="amount" placeholder="Enter amount" required>
              </div>
              <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" class="form-control" id="name" placeholder="Your name" required>
              </div>
              <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" class="form-control" id="email" placeholder="Your email" required>
              </div>
              <div class="form-group">
                <label for="payment">Payment Method</label>
                <select class="form-control" id="payment" required>
                  <option value="" disabled selected>Select a payment method</option>
                  <option value="Credit Card">Credit Card</option>
                  <option value="PayPal">PayPal</option>
                  <option value="Bank Transfer">Bank Transfer</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Donate Now</button>
            </form>

            <div class="footer mt-4 text-center">
              <p>By donating, you agree to our <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- /.content -->
</div>
