<?php
include('config.php');
$query = "SELECT * FROM certificates ORDER BY date_awarded DESC";
$result = mysqli_query($conn, $query);
?>
<?php require_once('inc/header.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Certificates</title>
  <!-- <link rel="stylesheet" href="assets/css/style.css"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
   body {
  background-color: #ffffff; /* or any light shade */
}

.nav {
  background-color: rgba(15, 15, 15, 0.95);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
  display: flex;
  justify-content: center;
}

.nav li a {
  color: #ccc;
}

.cert-grid {
  display: grid;
  grid-template-columns: repeat(3, 350px); /* 3 cards per row */
  gap: 40px; /* Increased gap for better spacing */
  padding: 40px; /* Adjusted padding */
}

.cert-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.2s ease;
  cursor: pointer;
  text-align: center;
}

.cert-card:hover {
  transform: scale(1.03);
}

.cert-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-top-left-radius: 12px;
  border-top-right-radius: 12px;
}

.cert-card h3 {
  margin: 10px 0 5px;
}

.cert-card p {
  margin: 5px 10px;
}

.cert-card .btns {
  display: flex;
  justify-content: space-around;
  padding: 10px;
}

.btns a {
  text-decoration: none;
  background-color: #4CAF50;
  color: white;
  padding: 6px 12px;
  border-radius: 5px;
  font-size: 14px;
}

.btns a.download-btn {
  background-color: #2196F3;
}

  </style>
</head>
<body>
<nav id="nav-wrap">
            <a class="mobile-btn" href="#nav-wrap" title="Show navigation">Show navigation</a>
            <a class="mobile-btn" href="#" title="Hide navigation">Hide navigation</a>

            <ul id="nav" class="nav">
                <li class="current"><a href="index.php">Home</a></li>
                <li><a class="smoothscroll" href="#about">About</a></li>
                <li><a href="uploads/22761A0506_Resume.pdf" target="_blank">Resume</a></li>
                <li><a href="projects.php">Projects</a></li>
                <li><a href="internships.php">Internships</a></li>
                <li><a href="achievements.php">Achievements</a></li>
                <li><a href="certificates.php">Certificates</a></li>
                <li><a href="blogs.php">Blogs</a></li>
            </ul>
        </nav>
<h1 style="text-align: center; margin-top: 80px;">My Certificates</h1>

<div class="cert-grid">
  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <div class="cert-card">
      <img src="<?php echo $row['preview_image']; ?>" alt="Certificate Preview">
      <h3><?php echo htmlspecialchars($row['title']); ?></h3>
      <p><strong><?php echo date("d M Y", strtotime($row['date_awarded'])); ?></strong></p>
      <?php if (!empty($row['description'])) { ?>
        <p><?php echo htmlspecialchars($row['description']); ?></p>
      <?php } ?>
      <div class="btns">
        <a href="<?php echo $row['file_path']; ?>" target="_blank">View</a>
        <a href="<?php echo $row['file_path']; ?>" download class="download-btn">Download</a>
      </div>
    </div>
  <?php } ?>
</div>
<?php require_once('inc/footer1.php') ?>
</body>
</html>
