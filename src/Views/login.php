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
        <form action="/login" method="POST">
          <div class="mb-4 mx-auto mw-762">
            <div class="login-input-wrapper">
              <input type="text" name="email" class="login-input" placeholder="Email or Username" required>
            </div>
          </div>
          <div class="mb-4 mx-auto mw-762">
            <div class="login-input-wrapper">
              <input type="password" name="password" class="login-input" placeholder="password" required>
            </div>
          </div>
          <button type="submit" class="btn login-btn-full mx-auto mw-762">LOG IN</button>
        </form>
        <div class="d-flex justify-content-between align-items-center mt-4 mx-auto px-3 mw-625">
          <span class="text-white fs-5">Remember me</span>
          <div class="remember-box"></div>
          <span class="text-white fs-5">Forget password</span>
        </div>
        <div class="mt-4 mx-auto mw-762">
          <div class="login-input-wrapper d-flex align-items-center justify-content-center gap-3">
            <i class="fab fa-google text-white fs-15"></i>
            <span class="text-white fs-5">continue with google</span>
          </div>
        </div>
        <a href="/signin" class="d-block mt-4 text-white fs-5 text-decoration-none">CREATE AN ACCOUNT</a>
        <p class="text-white mt-3 fs-5">
          Log in to vote, comment, and join live dares<br>with the community.
        </p>
      </div>
    </div>
  </div>
</section>
<?php

$content = ob_get_clean();
require __DIR__ . '/base.php';
