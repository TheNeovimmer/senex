<nav class="navbar navbar-expand-lg navbar-dark py-3 px-4 navbar-senex">
  <div class="container">
    <a class="navbar-brand" href="/">
      <img src="/assets/images/logo.png" alt="SENEX" height="30">
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto gap-lg-4">
        <li class="nav-item">
          <a class="nav-link nav-link-senex active" href="/">HOME</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-senex" href="/next">NEXT DARE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-senex" href="/replays">REPLAYS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-senex" href="/aboutus">ABOUT US</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-senex" href="/contact">CONTACT</a>
        </li>
      </ul>
      <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
        <div class="dropdown d-inline-block ms-lg-3">
          <a href="#" class="nav-link text-accent dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle fa-xl"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
            <li><a class="dropdown-item" href="/dashboard"><i class="fas fa-th-large me-2"></i>Dashboard</a></li>
            <?php if (($_SESSION['role'] ?? '') === 'streamer' || ($_SESSION['role'] ?? '') === 'admin'): ?>
              <li><a class="dropdown-item" href="/streamer"><i class="fas fa-broadcast-tower me-2"></i>Studio</a></li>
            <?php endif; ?>
            <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
              <li><a class="dropdown-item" href="/admin"><i class="fas fa-shield-alt me-2"></i>Admin</a></li>
            <?php endif; ?>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
          </ul>
        </div>
      <?php else: ?>
        <a href="/login" class="nav-link ms-lg-3 text-accent">
          <i class="fas fa-user-circle fa-xl"></i>
        </a>
      <?php endif; ?>
    </div>
  </div>
</nav>
