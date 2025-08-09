<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HopeFund – Charity for a Better World</title>
  <style>
    :root {
      --primary-blue: #4A90E2;
      --action-green: #43A047;
      --highlight-orange: #FB8C00;
      --background-light: #FAFAFA;
      --text-dark: #212121;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: var(--background-light);
      color: var(--text-dark);
      line-height: 1.6;
    }

    header {
      background-color: var(--primary-blue);
      color: white;
      padding: 20px 40px;
      position: sticky;
      top: 0;
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    header h1 {
      font-size: 24px;
    }

    nav {
      display: flex;
      align-items: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: 500;
    }

    nav input[type="text"], nav select {
      padding: 6px;
      border-radius: 4px;
      border: none;
    }

    .hero {
      padding: 60px 20px;
      background-color: white;
      text-align: center;
    }

    .hero h2 {
      font-size: 40px;
      margin-bottom: 20px;
    }

    .hero p {
      font-size: 18px;
      margin-bottom: 30px;
    }

    .donate-btn {
      padding: 12px 30px;
      background-color: var(--action-green);
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .donate-btn:hover {
      background-color: #2e7d32;
    }

    .section {
      padding: 60px 20px;
      max-width: 1000px;
      margin: 0 auto;
    }

    .progress-bar {
      background-color: #ddd;
      height: 20px;
      border-radius: 10px;
      overflow: hidden;
      margin-top: 10px;
    }

    .progress-fill {
      height: 100%;
      width: 65%;
      background-color: var(--highlight-orange);
    }

    .impact {
      display: flex;
      justify-content: space-around;
      text-align: center;
      flex-wrap: wrap;
      margin-top: 30px;
    }

    .impact div {
      flex: 1 1 200px;
      margin: 10px;
    }

    .impact h3 {
      font-size: 28px;
      color: var(--primary-blue);
    }

    .form-section form {
      display: flex;
      flex-direction: column;
      gap: 15px;
      max-width: 500px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    input, textarea {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    .testimonials, .faq {
      background-color: white;
      border-radius: 8px;
      padding: 30px;
      margin-top: 30px;
    }

    .testimonial {
      margin-bottom: 20px;
    }

    .faq-item {
      margin-bottom: 15px;
    }

    .faq-item h4 {
      color: var(--primary-blue);
      margin-bottom: 5px;
    }

    .card-section {
      text-align: center;
    }

    .card-wrapper {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin-top: 20px;
    }

    .card {
      background: white;
      border-radius: 8px;
      padding: 20px;
      width: 250px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card img {
      width: 100%;
      border-radius: 8px;
    }

    footer {
      background-color: var(--primary-blue);
      color: white;
      text-align: center;
      padding: 30px 10px;
      margin-top: 60px;
    }

    footer input[type="email"] {
      padding: 10px;
      width: 220px;
      margin-top: 10px;
      border: none;
      border-radius: 4px;
    }

    footer button {
      padding: 10px 20px;
      background-color: var(--highlight-orange);
      border: none;
      border-radius: 4px;
      color: white;
      margin-left: 10px;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .impact {
        flex-direction: column;
        align-items: center;
      }

      nav {
        justify-content: center;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <h1>HopeFund</h1>
    <nav>
      <a href="#donate">Donate</a>
      <a href="#impact">Impact</a>
      <a href="#testimonials">Stories</a>
      <a href="#faq">FAQ</a>
      <a href="#contact">Contact</a>
      <input type="text" placeholder="Search..." />
      <select>
        <option>EN</option>
        <option>ES</option>
        <option>FR</option>
      </select>
    </nav>
  </header>

  <!-- Hero -->
  <section class="hero">
    <h2>Support Communities in Need</h2>
    <p>Your donation helps provide food, shelter, and education to those who need it most.</p>
    <a href="#donate"><button class="donate-btn">Donate Now</button></a>
  </section>

  <!-- Progress -->
  <section class="section">
    <h3>Donation Progress</h3>
    <p>Raised $6,500 of $10,000 goal</p>
    <div class="progress-bar">
      <div class="progress-fill"></div>
    </div>
  </section>

  <!-- Impact Stats -->
  <section class="section" id="impact">
    <h3>Real-Time Impact</h3>
    <div class="impact">
      <div>
        <h3 class="counter" data-count="120">0</h3>
        <p>Families Helped</p>
      </div>
      <div>
        <h3 class="counter" data-count="80">0</h3>
        <p>Children Educated</p>
      </div>
      <div>
        <h3 class="counter" data-count="30">0</h3>
        <p>Homes Rebuilt</p>
      </div>
    </div>
  </section>

  <!-- Donation Form -->
  <section id="donate" class="section form-section">
    <h3>Make a Donation</h3>
    <form>
      <input type="text" placeholder="Full Name" required />
      <input type="email" placeholder="Email Address" required />
      <input type="number" placeholder="Donation Amount (USD)" required />
      <textarea rows="3" placeholder="Message (optional)"></textarea>
      <button type="submit" class="donate-btn">Submit Donation</button>
    </form>
  </section>

  <!-- Cards -->
  <section class="section card-section">
    <h3>See the Smiles You've Created</h3>
    <div class="card-wrapper">
      <div class="card">
        <img src="https://via.placeholder.com/250x150" alt="Food help">
        <p>Food packages delivered in rural villages.</p>
      </div>
      <div class="card">
        <img src="https://via.placeholder.com/250x150" alt="Education">
        <p>Children receiving school supplies and uniforms.</p>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section id="testimonials" class="section testimonials">
    <h3>Donor Stories</h3>
    <div class="testimonial">
      <p>“I’ve been donating for 2 years, and I’ve seen the real impact this charity makes. Highly trustworthy!”</p>
      <strong>– Ayesha M.</strong>
    </div>
    <div class="testimonial">
      <p>“My small donation helped feed a family for a week. Amazing cause and great transparency.”</p>
      <strong>– Daniel R.</strong>
    </div>
  </section>

  <!-- FAQ -->
  <section id="faq" class="section faq">
    <h3>Frequently Asked Questions</h3>
    <div class="faq-item">
      <h4>Where does my money go?</h4>
      <p>100% of your donation goes directly to food, shelter, and medical aid for the poor.</p>
    </div>
    <div class="faq-item">
      <h4>Is my donation tax deductible?</h4>
      <p>Yes, all donations are processed through a registered non-profit foundation.</p>
    </div>
  </section>

  <!-- Footer -->
  <footer id="contact">
    <h3>Join Our Newsletter</h3>
    <p>Stay updated with our impact and stories of hope.</p>
    <form>
      <input type="email" placeholder="Your email" required />
      <button type="submit">Subscribe</button>
    </form>
    <p style="margin-top:20px;">&copy; 2025 HopeFund. All rights reserved.</p>
  </footer>

  <!-- Counter Animation Script -->
  <script>
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
      counter.innerText = '0';
      const updateCount = () => {
        const target = +counter.getAttribute('data-count');
        const current = +counter.innerText;
        const increment = target / 100;
        if (current < target) {
          counter.innerText = Math.ceil(current + increment);
          setTimeout(updateCount, 30);
        } else {
          counter.innerText = target;
        }
      };
      updateCount();
    });
  </script>

</body>
</html>