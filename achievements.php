<?php
include('config.php');
$query = "SELECT * FROM achievements ORDER BY date DESC";
$result = mysqli_query($conn, $query);
?>
<?php require_once('inc/header.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Achievements</title>
  <link rel="stylesheet" href="assets/css/style.css">

  <!-- SwiperJS CSS CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
    body {
      background-color: #ffffff;
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
    .grid-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
  gap: 40px;
  padding: 40px;
  justify-content: center;
}


.achievement-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 15px rgba(0,0,0,0.1);
  overflow: hidden;
  transition: transform 0.2s ease;
  cursor: pointer;
  max-width: 350px;
  height: 430px; /* fixed height */
  margin: auto;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.achievement-card h1 {
  font-size: 20px;
  font-weight: bold;
  margin: 10px 15px 5px;
  color: #333;
}

.achievement-card p {
  margin: 0 15px 10px;
  color: #555;
  font-size: 14px;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 3; /* Show 3 lines */
  -webkit-box-orient: vertical;
}


    .achievement-card:hover {
      transform: scale(1.02);
    }

    .card-preview-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
    }

    .achievement-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
    }

    .custom-modal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.8);
      justify-content: center;
      align-items: center;
      z-index: 1000;
      overflow-y: auto;
    }

    .custom-modal-content {
      background: #fff;
      padding: 30px 20px;
      border-radius: 10px;
      max-width: 700px;
      width: 90%;
      position: relative;
      max-height: 90vh;
      overflow-y: auto;
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 28px;
      cursor: pointer;
      color: #333;
      background: rgba(238, 238, 238, 0.7);
      width: 35px;
      height: 35px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1010;
    }

    .carousel-image {
      width: 100%;
      max-height: 500px;
      object-fit: contain;
    }
    
    .carousel-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      max-height: 500px;
      overflow: hidden;
    }
    
    /* Remove duplicate carousel-close button */
    
    .swiper-slide img {
      max-width: 100%;
      max-height: 500px;
      width: auto;
      height: auto;
      display: block;
      margin: auto;
      border-radius: 8px;
      object-fit: contain;
    }
    
    #modalTitle {
      color: #000;
      font-size: 24px;
      text-align: center;
      margin-bottom: 15px;
      font-weight: bold;
      padding-top: 10px;
    }
    
    #modalDescription {
      margin-bottom: 20px;
      color: #333;
    }
    
    .achievement-details {
      margin-bottom: 20px;
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
<h1 style="text-align: center; margin-top: 80px;">My Achievements</h1>

<div class="grid-container">
  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <div class="achievement-card"
         onclick="openModal(<?php echo $row['id']; ?>)"
         data-title="<?php echo htmlspecialchars($row['title'], ENT_QUOTES); ?>"
         data-description="<?php echo htmlspecialchars($row['description'], ENT_QUOTES); ?>"
    >
      <img src="<?php echo $row['preview_image']; ?>" alt="Achievement Image">
      <h3><?php echo $row['title']; ?></h3>
      <p><?php echo $row['description']; ?></p>
      <p><strong><?php echo date("d M Y", strtotime($row['date'])); ?></strong></p>
    </div>
  <?php } ?>
</div>

<!-- Modal -->
<div id="achievementModal" class="custom-modal">
  <div class="custom-modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>

    <div class="achievement-details">
      <h2 id="modalTitle"></h2>
      <p id="modalDescription"></p>
    </div>

    <!-- Swiper Container -->
    <div class="swiper mySwiper">
      <div class="swiper-wrapper" id="swiperWrapper">
        <!-- Slides will be inserted via JS -->
      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </div>
</div>

<!-- SwiperJS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
// Close the modal when clicking outside of it
window.addEventListener('click', function(event) {
  const modal = document.getElementById('achievementModal');
  if (event.target === modal) {
    closeModal();
  }
});

function closeModal() {
  document.getElementById("achievementModal").style.display = "none";
  document.getElementById("swiperWrapper").innerHTML = "";
}

function openModal(achievementId) {
  const card = document.querySelector(`.achievement-card[onclick="openModal(${achievementId})"]`);
  console.log("Found Card:", card);
  const title = card.dataset.title;
  const description = card.dataset.description;

  document.getElementById("modalTitle").textContent = title;
  document.getElementById("modalDescription").textContent = description;
  document.getElementById("achievementModal").style.display = "flex";

  // Load images using AJAX
  fetch(`fetch_achievement_images.php?id=${achievementId}`)
    .then(response => response.json())
    .then(data => {
      const wrapper = document.getElementById("swiperWrapper");
      wrapper.innerHTML = "";
      data.forEach(img => {
        const slide = document.createElement("div");
        slide.className = "swiper-slide";
        slide.innerHTML = `<img src="${img}" alt="Achievement Image">`;
        wrapper.appendChild(slide);
      });

      new Swiper(".mySwiper", {
        loop: true,
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev"
        }
      });
    });
}
</script>
<?php require_once('inc/footer1.php') ?>
</body>
</html>