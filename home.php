<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Drip And Co - Home</title>
  <link rel="stylesheet" href="Index.css">
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="search.css">
  
  <style>
    .logout-container {
      position: absolute;
      top: 15px;
      right: 25px;
      z-index: 1000;
    }
    
    .logout-btn {
      background: #003b49;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      font-size: 14px;
      transition: background 0.3s ease;
    }
    
    .logout-btn:hover {
      background: #002f3a;
    }
  </style>
</head>

<body>
  <div id="header"></div>

  <div class="ImageSlideshow">
    <div class="slideshow-container">
      <div class="slide fade"> 
        <img src="images/Slideshow image.png" alt="Slideshow 1"> 
      </div>
      <div class="slide fade"> 
        <img src="images/slideshow image2.png" alt="Slideshow 2"> 
      </div>
    </div>
  </div>

  <section class="categories">
    <div class="card"> Mens
      <div class="img">
        <a href="Mens page.html">
          <img src="Male model.png" style="width:100%; height:150%;" alt="Mens Category">
        </a>
      </div>
    </div>
   
    <div class="card"> New Drops
      <div class="img"> 
        <a href="#">
          <img src="images/Newdrops.png" style="width: 100%; height: 150%;" alt="New Drops">
        </a>
      </div>
    </div>
   
    <div class="card"> Womens
      <div class="img">
        <a href="Womens Page.html">
          <img src="images/female outerwear.jpeg" style="width: 100%; height: 150%;" alt="Womens Category">
        </a>
      </div>
    </div>
  </section>

  <div id="footer"></div>

  <script>
    fetch("header.php")
      .then(res => res.text())
      .then(data => {
        document.getElementById("header").innerHTML = data;
        
        initDarkMode();
      });

    fetch("footer.html")
      .then(res => res.text())
      .then(data => document.getElementById("footer").innerHTML = data);
</script>
<script src="search.js"></script>
<script src="darkmode.js"></script>

</body>
</html>
