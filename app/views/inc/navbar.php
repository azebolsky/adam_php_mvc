<nav class="navbar navbar-expand-lg bg-dark border-bottom border-bottom-dark">
  <div class="container text-secondary-emphasis">
    <a class="navbar-brand" href="<?php echo URLROOT; ?>" style="color: #cbd5f7;"><?php echo SITENAME; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="<?php echo URLROOT; ?>" style="color: #cbd5f7;">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/pages/about" style="color: #cbd5f7;">About</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="#" style="color: #cbd5f7;">Welcome <?php echo $_SESSION['username']; ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout" style="color: #cbd5f7;">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/users/register" style="color: #cbd5f7;">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/users/login" style="color: #cbd5f7;">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>