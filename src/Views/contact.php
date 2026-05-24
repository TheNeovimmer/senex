<?php

$title = "SENEX - Contact";
ob_start();

?>
<section class="section-padding px-3">
  <div class="container">
    <div class="row align-items-center g-5" data-aos="fade-up">
      <div class="col-lg-6">
        <h1 class="fw-bold mb-3 text-accent heading-md">contact us</h1>
        <p class="fw-medium text-white mb-3 heading-sm">
          Get in Touch with SENEX<br>We're Here to Help You!
        </p>
        <p class="contact-desc mb-5">
          Have any questions, suggestions, or want to learn more? Reach out to us today. Whether you're facing challenges or just want to know more about our community, we're happy to assist you.
        </p>
        <div class="row g-4">
          <div class="col-4 text-center">
            <div class="feature-circle mx-auto">
              <i class="fas fa-bolt text-accent stat-icon"></i>
            </div>
            <p class="feature-label mt-2">Fast Response:</p>
            <p class="feature-value">We aim to reply within 24 hours</p>
          </div>
          <div class="col-4 text-center">
            <div class="feature-circle mx-auto">
              <i class="fas fa-comments text-accent stat-icon"></i>
            </div>
            <p class="feature-label mt-2">Fast Response:</p>
            <p class="feature-value">Talk to our team. Not just a bot</p>
          </div>
          <div class="col-4 text-center">
            <div class="feature-circle mx-auto">
              <i class="fas fa-shield-alt text-accent stat-icon"></i>
            </div>
            <p class="feature-label mt-2">Fast Response:</p>
            <p class="feature-value">Your data and privacy are our priority</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 text-center">
        <img src="https://placehold.co/461x568" alt="Contact" class="w-100 rounded-4 border-accent-4 mw-461">
      </div>
    </div>
  </div>
</section>

<section class="section-padding px-3">
  <div class="container">
    <div class="row g-5 align-items-start justify-content-center" data-aos="fade-up">
      <div class="col-lg-6">
        <form action="/contact/send" method="POST">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
          <div class="d-flex gap-3 mb-3">
            <input type="text" name="name" class="input-senex-dark" placeholder="Name" required>
            <input type="email" name="email" class="input-senex-dark" placeholder="Email" required>
          </div>
          <div class="mb-3">
            <input type="text" name="subject" class="input-senex-dark" placeholder="Subject" required>
          </div>
          <div class="mb-4">
            <textarea name="message" class="input-senex-dark textarea-senex" placeholder="Message" required></textarea>
          </div>
          <button type="submit" class="btn btn-senex radius-lg btn-send">SEND</button>
        </form>
      </div>
      <div class="col-lg-5">
        <div class="card-info p-4">
          <div class="d-flex align-items-center gap-3 mb-4">
            <div class="contact-icon-circle">
              <i class="fas fa-phone text-accent fs-125"></i>
            </div>
            <span class="contact-info-text">+21692061703</span>
          </div>
          <div class="d-flex align-items-center gap-3 mb-4">
            <div class="contact-icon-circle">
              <i class="fas fa-envelope text-accent fs-125"></i>
            </div>
            <span class="contact-info-text">www.senex@gmail.com</span>
          </div>
          <div class="d-flex align-items-center gap-3 mb-4">
            <div class="contact-icon-circle">
              <i class="fab fa-instagram text-accent fs-125"></i>
            </div>
            <span class="contact-info-text">senex</span>
          </div>
          <div class="d-flex align-items-center gap-3">
            <div class="contact-icon-circle">
              <i class="fas fa-location-dot text-accent fs-125"></i>
            </div>
            <span class="contact-info-text">mouhmed 5 street tunis 5200</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php

$content = ob_get_clean();
require __DIR__ . '/base.php';
