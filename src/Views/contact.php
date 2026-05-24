<?php

$title = "SENEX - Contact";
ob_start();

?>
<section class="py-5 px-3">
  <div class="container">
    <div class="row align-items-center g-5" data-aos="fade-up">
      <div class="col-lg-6">
        <h1 class="fw-bold mb-3" style="color: #F15BB5; font-size: clamp(2rem, 3vw, 3rem);">contact us</h1>
        <p class="fw-medium text-white mb-3" style="font-size: clamp(1.25rem, 2vw, 2rem);">
          Get in Touch with SENEX<br>We're Here to Help You!
        </p>
        <p class="text-white mb-5" style="font-size: 1.5rem;">
          Have any questions, suggestions, or want to learn more? Reach out to us today. Whether you're facing challenges or just want to know more about our community, we're happy to assist you.
        </p>
        <div class="row g-4">
          <div class="col-4 text-center">
            <div class="mx-auto d-flex align-items-center justify-content-center" style="width: 85px; height: 83px; border-radius: 50%; border: 2px solid #F15BB5; background: rgba(255,255,255,0.05);">
              <i class="fas fa-bolt" style="color: #F15BB5; font-size: 1.5rem;"></i>
            </div>
            <p class="fw-medium text-white mb-0 mt-2" style="font-size: 0.75rem;">Fast Response:</p>
            <p class="text-white mb-0" style="font-size: 0.75rem;">We aim to reply within 24 hours</p>
          </div>
          <div class="col-4 text-center">
            <div class="mx-auto d-flex align-items-center justify-content-center" style="width: 85px; height: 83px; border-radius: 50%; border: 2px solid #F15BB5; background: rgba(255,255,255,0.05);">
              <i class="fas fa-comments" style="color: #F15BB5; font-size: 1.5rem;"></i>
            </div>
            <p class="fw-medium text-white mb-0 mt-2" style="font-size: 0.75rem;">Fast Response:</p>
            <p class="text-white mb-0" style="font-size: 0.75rem;">Talk to our team. Not just a bot</p>
          </div>
          <div class="col-4 text-center">
            <div class="mx-auto d-flex align-items-center justify-content-center" style="width: 85px; height: 83px; border-radius: 50%; border: 2px solid #F15BB5; background: rgba(255,255,255,0.05);">
              <i class="fas fa-shield-alt" style="color: #F15BB5; font-size: 1.5rem;"></i>
            </div>
            <p class="fw-medium text-white mb-0 mt-2" style="font-size: 0.75rem;">Fast Response:</p>
            <p class="text-white mb-0" style="font-size: 0.75rem;">Your data and privacy are our priority</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 text-center">
        <img src="https://placehold.co/461x568" alt="Contact" class="w-100 rounded-4" style="max-width: 461px; border: 4px solid #F15BB5;">
      </div>
    </div>
  </div>
</section>

<section class="py-5 px-3">
  <div class="container">
    <div class="row g-5 align-items-start justify-content-center" data-aos="fade-up">
      <div class="col-lg-6">
        <form action="/contact/send" method="POST">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
          <div class="d-flex gap-3 mb-3">
            <input type="text" name="name" class="form-control bg-transparent text-white" placeholder="Name" style="border: 2px solid #F15BB5; border-radius: 50px; padding: 14px 19px;">
            <input type="email" name="email" class="form-control bg-transparent text-white" placeholder="Email" style="border: 2px solid #F15BB5; border-radius: 50px; padding: 14px 19px;">
          </div>
          <div class="mb-3">
            <input type="text" name="subject" class="form-control bg-transparent text-white" placeholder="Subject" style="border: 2px solid #F15BB5; border-radius: 50px; padding: 14px 19px;">
          </div>
          <div class="mb-4">
            <textarea name="message" class="form-control bg-transparent text-white" placeholder="Message" style="border: 2px solid #F15BB5; border-radius: 20px; padding: 18px 19px; min-height: 155px; resize: vertical;"></textarea>
          </div>
          <button type="submit" class="btn btn-senex" style="border-radius: 50px; padding: 8px 50px;">SEND</button>
        </form>
      </div>
      <div class="col-lg-5">
        <div class="p-4 rounded-4" style="background: rgba(255,255,255,0.10); border: 2px solid #F15BB5;">
          <div class="d-flex align-items-center gap-3 mb-4">
            <div class="d-flex align-items-center justify-content-center flex-shrink-0" style="width: 58px; height: 56px; border-radius: 50%; border: 2px solid #F15BB5; background: rgba(255,255,255,0.05);">
              <i class="fas fa-phone" style="color: #F15BB5; font-size: 1.25rem;"></i>
            </div>
            <span class="fw-bold text-white" style="font-size: 1rem;">+21692061703</span>
          </div>
          <div class="d-flex align-items-center gap-3 mb-4">
            <div class="d-flex align-items-center justify-content-center flex-shrink-0" style="width: 58px; height: 56px; border-radius: 50%; border: 2px solid #F15BB5; background: rgba(255,255,255,0.05);">
              <i class="fas fa-envelope" style="color: #F15BB5; font-size: 1.25rem;"></i>
            </div>
            <span class="fw-bold text-white" style="font-size: 1rem;">www.senex@gmail.com</span>
          </div>
          <div class="d-flex align-items-center gap-3 mb-4">
            <div class="d-flex align-items-center justify-content-center flex-shrink-0" style="width: 58px; height: 56px; border-radius: 50%; border: 2px solid #F15BB5; background: rgba(255,255,255,0.05);">
              <i class="fab fa-instagram" style="color: #F15BB5; font-size: 1.25rem;"></i>
            </div>
            <span class="fw-bold text-white" style="font-size: 1rem;">senex</span>
          </div>
          <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center flex-shrink-0" style="width: 58px; height: 56px; border-radius: 50%; border: 2px solid #F15BB5; background: rgba(255,255,255,0.05);">
              <i class="fas fa-location-dot" style="color: #F15BB5; font-size: 1.25rem;"></i>
            </div>
            <span class="fw-bold text-white" style="font-size: 1rem;">mouhmed 5 street tunis 5200</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php

$content = ob_get_clean();
require __DIR__ . '/base.php';
