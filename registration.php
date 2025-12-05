<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}

$errors = [];
$successMessage = "";

if (isset($_POST["submit"])) {
    require_once "database.php";

    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);
    $dob = trim($_POST["dob"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $psw = $_POST["psw"];

    if (empty($fname) || empty($lname) || empty($dob) || empty($email) || empty($phone) || empty($psw)) {
        $errors[] = "All fields are required.";
    }

    if (!preg_match("/^[A-Za-z]+$/", $fname)) {
        $errors[] = "First name must contain only letters.";
    }

    if (!preg_match("/^[A-Za-z]+$/", $lname)) {
        $errors[] = "Last name must contain only letters.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email.";
    }

    if (!preg_match("/^\+?[0-9\s\-()]{10,20}$/", $phone)) {
        $errors[] = "Please enter a valid phone number.";
    }

    if (strlen($psw) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }

    $checkSQL = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $checkSQL);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Email already exists!";
    }

    if (empty($errors)) {
        $fullName = $fname . ' ' . $lname;
        $passwordHash = password_hash($psw, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (first_name, last_name, dob, full_name, email, phone, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $fname, $lname, $dob, $fullName, $email, $phone, $passwordHash);

        if (mysqli_stmt_execute($stmt)) {
            $successMessage = "Account created successfully!";
        } else {
            $errors[] = "Something went wrong.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Drip And Co – Sign Up</title>
  <link rel="stylesheet" href="Index.css">
  <link rel="stylesheet" href="Signup.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="search.css">
</head>

<body>
  <?php if (!empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
    <div class="notification error show">
      <span class="notification-text"><?php echo htmlspecialchars($error); ?></span>
      <button class="notification-close" onclick="closeNotification(this)">&times;</button>
    </div>
    <?php endforeach; ?>
  <?php endif; ?>
  
  <?php if (!empty($successMessage)): ?>
  <div class="notification success show">
    <span class="notification-text"><?php echo htmlspecialchars($successMessage); ?></span>
    <button class="notification-close" onclick="closeNotification(this)">&times;</button>
  </div>
  <?php endif; ?>

  <div id="header"></div>

  <main class="signup_page">
    <h1 class="signup-title">CREATE AN ACCOUNT</h1>

    <div class="signup">
      <form class="signup-box" action="registration.php" method="POST">
        <label for="fname"><b>First Name</b></label>
        <input type="text" id="fname" name="fname" pattern="^[A-Za-z]+$" required 
               title="First name can only contain letters" placeholder="First name"
               value="<?php echo isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : ''; ?>">

        <label for="lname"><b>Last Name</b></label>
        <input type="text" id="lname" name="lname" pattern="^[A-Za-z]+$" required 
               title="Last name can only contain letters" placeholder="Second name"
               value="<?php echo isset($_POST['lname']) ? htmlspecialchars($_POST['lname']) : ''; ?>">

        <label for="dob"><b>Date of Birth</b></label>
        <input type="date" id="dob" name="dob" required
               value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>">

        <label for="email"><b>Email</b></label>
        <input type="email" id="email" name="email" required
               pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|co\.uk|net|org|ac\.uk)$"
               title="Please enter a valid email" placeholder="example@gmail.com"
               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

        <label for="phone"><b>Phone Number</b></label>
        <input type="text" id="phone" name="phone" maxlength="20"
               pattern="^\+?[0-9\s\-()]{10,20}$" title="Please enter a valid phone number"
               placeholder="eg. 07123456789"
               value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">

        <label for="psw"><b>Password</b></label>
        <input type="password" id="psw" name="psw" required placeholder="New Password">

        <label class="terms-label" for="terms">
          I confirm I have read and agree to the terms and conditions.
        </label>
        <input type="checkbox" id="terms" name="terms" required>

        <button type="submit" name="submit" class="lbutton">CREATE ACCOUNT</button>
      </form>
    </div>

    <div class="login-section">
      <p>Already have an account?</p>
      <a href="login.php" class="login-btn">SIGN IN</a>
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
      const notifications = document.querySelectorAll('.notification');
      notifications.forEach(function(notification) {
          notification.classList.remove('show');
      });
  }, 5000);

  function closeNotification(button) {
      const notification = button.closest('.notification');
      if (notification) {
          notification.classList.remove('show');
      }
  }
  </script>

</body>
</html>
