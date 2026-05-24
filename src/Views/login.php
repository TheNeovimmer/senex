<?php

$title = "SENEX - Login";
ob_start();

?>
<section class="section-padding px-3">
  <div class="container">
    <div class="row justify-content-center" data-aos="fade-up">
      <div class="col-lg-8 col-xl-6 text-center">
        <h1 class="fw-bold mb-5 text-accent heading-xl">
          WELCOME BACK,<br>CHALLENGER!
        </h1>
        <div class="login-card">
          <form action="/login" method="POST">
            <div class="mb-4">
              <div class="login-input-wrapper">
                <input type="text" name="email" class="login-input" placeholder="Email or Username" required>
              </div>
            </div>
            <div class="mb-4">
              <div class="login-input-wrapper">
                <input type="password" name="password" class="login-input" placeholder="Password" required>
              </div>
            </div>
            <button type="submit" class="btn login-btn-full">LOG IN</button>
          </form>
          <div class="d-flex justify-content-between align-items-center mt-4 px-2">
            <label class="d-flex align-items-center gap-2 text-white fs-5 cursor-pointer">
              <input type="checkbox" class="checkbox-senex">
              Remember me
            </label>
            <a href="#" class="btn-link-senex fs-5">Forget password</a>
          </div>
          <div class="login-divider my-4">or</div>
          <button class="btn-login-google d-flex align-items-center justify-content-center gap-3">
            <i class="fab fa-google"></i>
            <span>continue with google</span>
          </button>
        </div>
        <a href="/signin" class="btn btn-outline-senex mt-4 px-5 py-3 d-inline-block fs-5">CREATE AN ACCOUNT</a>
        <p class="text-white mt-4 fs-5">
          Log in to vote, comment, and join live dares<br>with the community.
        </p>
      </div>
    </div>
  </div>
</section>
<?php

$content = ob_get_clean();
require __DIR__ . '/base.php';
