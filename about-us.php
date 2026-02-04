<?php
// about-us.php
include('partials-front/menu.php');  // Site-wide navbar
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us — Modern Cosmetic Order & Delivery</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- About Us CSS -->
  <link rel="stylesheet" href="css/about-us.css">
</head>
<body>

  <!-- Hero Section -->
  <section class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
      <h1 class="animate-fade-in-up">About Our Cosmetic Service</h1>
      <p class="animate-fade-in-up delay-1">Delivering beauty to your doorstep with care and style.</p>
    </div>
  </section>

  <!-- Mission & Vision -->
  <section class="mission-vision-wrapper">
    <div class="container mission-vision">
      <div class="card mission-card animate-fade-in-up delay-2">
        <i class="card-icon fas fa-bullseye"></i>
        <h2>Our Mission</h2>
        <p>To provide high-quality cosmetics with seamless ordering and reliable delivery, empowering everyone to look and feel their best.</p>
      </div>
      <div class="card vision-card animate-fade-in-up delay-2">
        <i class="card-icon fas fa-eye"></i>
        <h2>Our Vision</h2>
        <p>To become the go-to platform for beauty enthusiasts—where innovation, trust, and convenience meet.</p>
      </div>
    </div>
  </section>

  <!-- Team Section -->
  <section class="team container">
    <h2 class="section-title">Meet the Team</h2>
    <p class="section-subtitle">The passionate individuals behind our service.</p>
    <div class="team-grid">
      <figure class="team-card">
        <div class="avatar-wrapper animate-fade-in-up delay-1">
          <div class="avatar avatar-feysel">
            <img class="profile-img"   src="image/team/feysel.jpg" alt="Feysel_pro" >
          </div>
        </div>
        <figcaption>
          <h3>Feysel Mifta</h3>
          <p>Co-Founder & Lead Developer</p>
          <div class="social-links">
            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" aria-label="GitHub"><i class="fab fa-github"></i></a>
          </div>
        </figcaption>
      </figure>
      <figure class="team-card">
        <div class="avatar-wrapper animate-fade-in-up delay-1">
          <div class="avatar avatar-hawa"></div>
        </div>
        <figcaption>
          <h3>Hawa Alewi</h3>
          <p>UI/UX Designer</p>
          <div class="social-links">
            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" aria-label="Portfolio"><i class="fas fa-palette"></i></a>
          </div>
        </figcaption>
      </figure>
      <figure class="team-card">
        <div class="avatar-wrapper animate-fade-in-up delay-1">
          <div class="avatar avatar-niguse"></div>
        </div>
        <figcaption>
          <h3>Niguse Folla</h3>
          <p>Backend Engineer</p>
          <div class="social-links">
            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" aria-label="GitHub"><i class="fab fa-github"></i></a>
          </div>
        </figcaption>
      </figure>
      <figure class="team-card">
        <div class="avatar-wrapper animate-fade-in-up delay-1">
          <div class="avatar avatar-alemayehu"></div>
        </div>
        <figcaption>
          <h3>Alemayehu Sh.</h3>
          <p>Instructor & Mentor</p>
          <div class="social-links">
            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </figcaption>
      </figure>
    </div>
  </section>

  <?php include('partials-front/footer.php'); // Site-wide footer ?>

  <!-- Intersection Observer for animations -->
  <script>
    const animatedElements = document.querySelectorAll('.animate-fade-in-up, .mission-card, .vision-card, .team-card');
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });
    animatedElements.forEach(el => observer.observe(el));
  </script>

</body>
</html>
