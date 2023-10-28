<?php
if (!isset($_SESSION))
  session_start();
if (isset($_SESSION["user"])) {
  $user = $_SESSION["user"];
}
?>

<nav>
  <div class="logo">
    <a href="index.php">
      <img src="assets/logo.png" alt="Logo" />
    </a>
  </div>
  <div class="nav-items">
    <a class="link <?= $active == 'index' ? 'active' : '' ?>" href="index.php">Home</a>
    <a class="link <?= $active == 'aboutme' ? 'active' : '' ?>" href="aboutme.php">About me</a>
    <?php if (!isset($user)) { ?>
      <a class="link <?= $active == 'login' ? 'active' : '' ?>" href="login.php">Log in</a>
      <a class="link <?= $active == 'register' ? 'active' : '' ?>" href="register.php">Register</a>
    <?php } else { ?>
      <?php if ($user["role"] == "Admin") { ?>
        <a class="link" href="dashboard.php">Dashboard</a>
      <?php } ?>
      <?php if ($user["role"] == "User") { ?>
        <a class="link <?= $active == 'shopping-cart' ? 'active' : '' ?>" href="shopping-cart.php">Shopping Cart</a>
      <?php } ?>
      <a class="link" href="logout.php">Log out</a>
    <?php } ?>



    <svg id="toggle-dark" style="margin-left: 20px" xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
      <path d="M12.773,21.088c-0.463,0-0.929-0.035-1.396-0.105c-3.882-0.586-7.007-3.708-7.601-7.594
                c-0.68-4.45,1.901-8.7,6.136-10.106c0.432-0.142,0.883-0.038,1.21,0.281c0.343,0.335,0.468,0.831,0.325,1.293
                c-0.266,0.863-0.385,1.765-0.353,2.68c0.095,2.801,1.768,5.429,4.365,6.857c1.203,0.661,2.417,0.986,3.711,0.993
                c0.463,0.003,0.882,0.266,1.094,0.686c0.21,0.417,0.172,0.907-0.1,1.277l0,0C18.422,19.725,15.677,21.088,12.773,21.088z
                M10.292,4.221c-0.021,0-0.043,0.004-0.064,0.011c-3.771,1.252-6.068,5.04-5.463,9.006c0.528,3.457,3.309,6.235,6.761,6.756
                c3.026,0.458,6.032-0.782,7.833-3.236l0,0c0.07-0.096,0.032-0.196,0.013-0.235c-0.021-0.041-0.081-0.135-0.206-0.136
                c-1.464-0.008-2.833-0.374-4.188-1.117c-2.904-1.598-4.775-4.548-4.883-7.699c-0.035-1.027,0.099-2.039,0.397-3.008
                c0.037-0.123-0.012-0.227-0.069-0.284C10.384,4.24,10.34,4.221,10.292,4.221z" />
    </svg>
  </div>
</nav>
