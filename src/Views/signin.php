<?php

$title = "SENEX - Sign Up";
ob_start();

?>
<section class="py-5 px-3">
  <div class="container">
    <div class="row justify-content-center" data-aos="fade-up">
      <div class="col-lg-10">
        <h1 class="fw-bold text-center mb-5" style="color: rgba(241,91,181,0.15); font-size: clamp(2.5rem, 5vw, 6rem);">
          WELCOME BACK,<br>CHALLENGER!
        </h1>
        <div class="row g-0 shadow-lg overflow-hidden" style="border-radius: 50px;">
          <div class="col-md-6 d-flex flex-column justify-content-center p-5" style="background: rgba(155,93,229,0.23);">
            <img src="/assets/images/logo.png" alt="SENEX" height="30" class="mb-4">
            <h2 class="fw-bold fs-2" style="color: #F15BB5;">Join the<br>senex community</h2>
            <p class="text-white fs-5 mb-4">Create your account and start exploring, connecting and challenging.</p>
            <div class="d-flex gap-3 mb-3">
              <i class="fas fa-link fa-lg mt-1" style="color: #F15BB5; width: 24px;"></i>
              <div>
                <h6 class="fw-bold text-white mb-1">Connect</h6>
                <p class="text-white-50 small mb-0">find and connect with amazing people</p>
              </div>
            </div>
            <div class="d-flex gap-3 mb-3">
              <i class="fas fa-trophy fa-lg mt-1" style="color: #F15BB5; width: 24px;"></i>
              <div>
                <h6 class="fw-bold text-white mb-1">Challenge</h6>
                <p class="text-white-50 small mb-0">Join real challengers and compete with others</p>
              </div>
            </div>
            <div class="d-flex gap-3">
              <i class="fas fa-chart-line fa-lg mt-1" style="color: #F15BB5; width: 24px;"></i>
              <div>
                <h6 class="fw-bold text-white mb-1">Grow</h6>
                <p class="text-white-50 small mb-0">Track your progress and become your best</p>
              </div>
            </div>
            <img src="https://placehold.co/445x313" alt="Community" class="w-100 mt-4" style="max-width: 400px; border-radius: 12px;">
          </div>
          <div class="col-md-6 p-5" style="background: white;">
            <h3 class="fw-bold text-center mb-2" style="color: #16162C; letter-spacing: 0.08em;">Create account</h3>
            <p class="text-center mb-4" style="color: #16162C;">Let's get you started</p>
            <form action="/signin" method="POST">
              <div class="mb-3">
                <label class="form-label fw-medium" style="color: #16162C;">Full name</label>
                <input type="text" name="fullname" class="form-control" placeholder="Enter your full name" required style="border-radius: 50px; border: 1px solid #F15BB5; padding: 10px 16px;">
              </div>
              <div class="mb-3">
                <label class="form-label fw-medium" style="color: #1E1E2F;">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required style="border-radius: 50px; border: 1px solid #F15BB5; padding: 10px 16px;">
              </div>
              <div class="mb-3">
                <label class="form-label fw-medium" style="color: #1E1E2F;">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Choose a username" required style="border-radius: 50px; border: 1px solid #F15BB5; padding: 10px 16px;">
              </div>
              <div class="mb-3">
                <label class="form-label fw-medium" style="color: #1E1E2F;">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Create a password" required style="border-radius: 50px; border: 1px solid #F15BB5; padding: 10px 16px;">
              </div>
              <div class="mb-4">
                <label class="form-label fw-medium" style="color: #16162C;">Confirm</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" required style="border-radius: 50px; border: 1px solid #F15BB5; padding: 10px 16px;">
              </div>
              <button type="submit" class="btn w-100 py-2 fw-bold" style="border-radius: 50px; border: 1px solid #F15BB5; color: #1E1E2F; background: none;">CREATE ACCOUNT</button>
            </form>
            <p class="text-center mt-3 mb-3" style="color: #1E1E2F;">Or continue</p>
            <div class="d-flex justify-content-center gap-4">
              <div style="width: 50px; height: 50px; background: #16162C; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fab fa-google" style="color: white;"></i>
              </div>
              <div style="width: 50px; height: 50px; background: #16162C; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fab fa-facebook-f" style="color: white;"></i>
              </div>
              <div style="width: 50px; height: 50px; background: #16162C; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fab fa-twitter" style="color: white;"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php

$content = ob_get_clean();
require __DIR__ . '/base.php';
