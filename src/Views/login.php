<?php

$title = "SENEX - Login";
ob_start();

?>
<section class="py-5 px-3">
  <div class="container">
    <div class="row justify-content-center" data-aos="fade-up">
      <div class="col-lg-8 col-xl-6 text-center">
        <h1 class="fw-bold mb-5" style="color: #F15BB5; font-size: clamp(2.5rem, 5vw, 6rem);">
          WELCOME BACK,<br>CHALLENGER!
        </h1>
        <form action="/login" method="POST">
          <div class="mb-4 mx-auto" style="max-width: 762px;">
            <div style="background: rgba(22,22,44,0.20); border: 1px solid #F15BB5; border-radius: 50px; padding: 40px 59px;">
              <input type="text" name="email" class="bg-transparent border-0 text-white w-100" placeholder="Email or Username" required style="font-size: 1.5rem; outline: none;">
            </div>
          </div>
          <div class="mb-4 mx-auto" style="max-width: 762px;">
            <div style="background: rgba(22,22,44,0.20); border: 1px solid #F15BB5; border-radius: 50px; padding: 40px 59px;">
              <input type="password" name="password" class="bg-transparent border-0 text-white w-100" placeholder="password" required style="font-size: 1.5rem; outline: none;">
            </div>
          </div>
          <button type="submit" class="btn border-0 text-white fw-bold mx-auto" style="max-width: 762px; width: 100%; background: #F15BB5; border-radius: 50px; padding: 40px; font-size: 1.5rem;">LOG IN</button>
        </form>
        <div class="d-flex justify-content-between align-items-center mt-4 mx-auto px-3" style="max-width: 625px;">
          <span class="text-white fs-5">Remember me</span>
          <div style="width: 40px; height: 40px; background: #16162C; border: 1px solid white;"></div>
          <span class="text-white fs-5">Forget password</span>
        </div>
        <div class="mt-4 mx-auto" style="max-width: 762px;">
          <div class="d-flex align-items-center justify-content-center gap-3" style="background: rgba(22,22,44,0.20); border: 1px solid #F15BB5; border-radius: 50px; padding: 40px;">
            <i class="fab fa-google" style="color: white; font-size: 1.5rem;"></i>
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
