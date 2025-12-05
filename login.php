<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Drip & Co</title>

  <link rel="stylesheet" href="Index.css">

  <link rel="stylesheet" href="login.css">

  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="search.css">
</head>

<body>
  <?php
  $errorMessage = "";
  if (isset($_POST["login"])) {
      require_once "database.php";
      
      $email = trim($_POST["email"]);
      $password = $_POST["password"];
      
      $sql = "SELECT * FROM users WHERE email = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

      if ($user) {
          if (password_verify($password, $user["password"])) {
              $_SESSION["user"] = "yes";
              header("Location: home.php");
              exit();
          } else {
              $errorMessage = "Password does not match";
          }
      } else {
          $errorMessage = "Email does not match";
      }
  }
  
  if (!empty($errorMessage)):
  ?>
  <div class="notification error show">
    <span class="notification-text"><?php echo htmlspecialchars($errorMessage); ?></span>
    <button class="notification-close" onclick="closeNotification()">&times;</button>
  </div>
  <?php endif; ?>

  <div id="header"></div>

  <main class="login-page">
    <h1 class="login-title">LOG IN</h1>

    <div class="login-container">
      <form class="login-box" action="login.php" method="POST">
        <label for="email">Email address</label>
        <input type="email" 
               id="email" 
               name="email" 
               required 
               placeholder="example@gmail.com"
               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

        <label for="password">Password</label>
        <input type="password" 
               id="password" 
               name="password" 
               required 
               placeholder="New Password">

        <a class="forgot" href="#">Forgot your password?</a>

        <button type="submit" name="login" class="login-btn">SIGN IN</button>
      </form>
    </div>

    <div class="signup-section">
      <p>Need an account?</p>
      <a href="registration.php" class="signup-btn">SIGN UP</a>
    </div>
  </main>

  <div id="footer"></div>

  <script>
    fetch("header.php")
      .then(res => res.text())
      .then(data => {
        document.getElementById("header").innerHTML = data;
        
        if (typeof initDarkMode === 'function') {
          initDarkMode();
        }
      });

    fetch("footer.html")
      .then(res => res.text())
      .then(data => document.getElementById("footer").innerHTML = data);
  </script>
  <script src="search.js"></script>
  <script src="darkmode.js"></script>

  <script>
  setTimeout(function() {
      const notification = document.querySelector('.notification');
      if (notification) {
          notification.classList.remove('show');
      }
  }, 5000);

  function closeNotification() {
      const notification = document.querySelector('.notification');
      if (notification) {
          notification.classList.remove('show');
      }
  }
  </script>

</body>
</html>
