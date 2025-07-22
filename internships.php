<?php
include('config.php');
$query = "SELECT * FROM work ORDER BY started DESC";
$result = mysqli_query($conn, $query);
?>
<?php require_once('inc/header.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Internships</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* Container for all internship cards */
    .nav {
  background-color: rgba(15, 15, 15, 0.95);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
  display: flex;
  justify-content: center;

}
body {
  background-color: #ffffff; /* or any light shade */
}
.nav li a {
  color: #ccc;
}.mt-100 {
  margin-top: 60px;
}
    .internships-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      padding: 40px 20px;
    }

    /* Each internship card */
    .internship-card {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
      overflow: hidden;
      transition: transform 0.3s ease;
      width: 300px;
      cursor: pointer;
      display: flex;
      flex-direction: column;
    }

    .internship-card:hover {
      transform: translateY(-5px);
    }

    /* The image at the top of the card */
    .internship-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      display: block;
    }

    /* Content area inside each card */
    .internship-content {
      padding: 20px;
      text-align: center;
    }
    .internship-title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 8px;
    }
    .internship-role {
      font-weight: 500;
      color: #333;
      margin-bottom: 4px;
    }
    .internship-duration {
      font-size: 14px;
      color: #777;
    }
    /* General Font Styling */
body {
  font-family: 'Calibri', sans-serif;
  font-size: 16px;
  line-height: 1.6;
  color: #333;
}

/* Main Heading */
h1 {
  font-size: 32px;
  font-weight: bold;
  color: #222;
  margin-bottom: 40px;
  font-family: 'Calibri', sans-serif;
}

/* Card Content */
.internship-title {
  font-size: 20px;
  font-weight: bold;
  color: #222;
  font-family: 'Calibri', sans-serif;
}

.internship-role {
  font-size: 16px;
  font-weight: 500;
  color: #555;
}

.internship-duration {
  font-size: 14px;
  color: #888;
}

/* Modal Content Styling */
.modal-content h2 {
  font-size: 24px;
  font-weight: bold;
  color: #222;
  font-family: 'Calibri', sans-serif;
  margin-bottom: 10px;
}

.modal-content p {
  font-size: 16px;
  color: #444;
  margin-bottom: 10px;
}
.modal-content a {
  font-size: 16px;
}
.modal-content a:hover {
  text-decoration: underline;
}
.internship-card:hover .internship-title {
  color: #007bff;
}


    /* Modal styling */
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.6);
      justify-content: center;
      align-items: center;
      overflow: auto;
      padding: 20px;
    }
    .modal-content {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      max-width: 600px;
      width: 100%;
      text-align: left;
      position: relative;
      max-height: 90vh;
      overflow-y: auto;
      transform: scale(1);
      transition: transform 0.3s ease;
    }
    .modal.show .modal-content {
      transform: scale(1.05);
    }
    .close-btn {
      position: absolute;
      right: 15px;
      top: 15px;
      font-size: 24px;
      color: #333;
      font-weight: bold;
      cursor: pointer;
      z-index: 1000;
    }
    /* Make the modal logo bigger */
    .modal-logo {
      width: 100%;
      max-width: 300px;
      display: block;
      margin: 0 auto 20px auto;
    }
    .modal-content a {
      color: #007bff;
      text-decoration: none;
    }
    /* Smooth fade-in for the modal */
    .modal.show {
      display: flex;
      animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
      from {opacity: 0;}
      to {opacity: 1;}
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
<h1 style="text-align: center; margin-top: 60px;">My Internships</h1>

<div class="internships-container">
  <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <div class="internship-card" 
      onclick="openModal(this)"
      data-company="<?php echo htmlspecialchars($row['company'], ENT_QUOTES); ?>"
      data-position="<?php echo htmlspecialchars($row['position'], ENT_QUOTES); ?>"
      data-start="<?php echo $row['started']; ?>"
      data-end="<?php echo $row['ended']; ?>"
      data-description="<?php echo htmlspecialchars(strip_tags($row['description']), ENT_QUOTES); ?>"
      data-logo="<?php echo htmlspecialchars($row['company_logo'], ENT_QUOTES); ?>"
      data-tech="<?php echo htmlspecialchars($row['tech_used'], ENT_QUOTES); ?>"
      data-location="<?php echo htmlspecialchars($row['location'], ENT_QUOTES); ?>"
      data-link="<?php echo htmlspecialchars($row['company_link'], ENT_QUOTES); ?>"
      data-certificate="<?php echo htmlspecialchars($row['certificate_file'], ENT_QUOTES); ?>"
    >
      <!-- If the image path is stored completely (e.g., uploads/logos/filename.jpg) use it directly -->
      <?php if (!empty($row['company_logo'])) { ?>
        <img src="<?php echo $row['company_logo']; ?>" alt="Company Logo">
      <?php } ?>
      <div class="internship-content">
        <div class="internship-title"><?php echo $row['company']; ?></div>
        <div class="internship-role"><strong>Role:</strong> <?php echo $row['position']; ?></div>
        <div class="internship-duration">
          <strong>Duration:</strong>
          <?php echo formatMonthYear($row['started']) . " - " . formatMonthYear($row['ended']); ?>
        </div>

      </div>
    </div>
  <?php } ?>
</div>

<!-- Modal -->
<div id="internshipModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <!-- Bigger modal image -->
    <img id="modalLogo" class="modal-logo" src="" alt="Company Logo">
    <h2 id="modalCompany"></h2>
    <p><strong>Position:</strong> <span id="modalPosition"></span></p>
    <p><strong>Duration:</strong> <span id="modalDuration"></span></p>
    <p><strong>Location:</strong> <span id="modalLocation"></span></p>
    <p><strong>Description:</strong></p>
    <p id="modalDescription"></p>
    <p><strong>Technologies Used:</strong></p>
    <p id="modalTech"></p>
    <p><strong>Company Link:</strong> <a href="#" id="modalLink" target="_blank">Visit</a></p>
    <p><strong>Certificate:</strong> <a href="#" id="modalCertificate" target="_blank">View</a></p>
  </div>
</div>

<script>
  <?php
    function formatMonthYear($input) {
      $parts = explode('_', $input);
      if (count($parts) == 2) {
        return $parts[0] . ' ' . $parts[1];
      }
      return $input; // fallback
  }
  ?>

  function formatDate(dateStr) {
    const options = { year: 'numeric', month: 'short' };
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-US', options);
  }
  function closeModal() {
    document.getElementById('internshipModal').style.display = "none";
  }
  function decodeHTML(html) {
    const txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
  }
  function openModal(card) {
    const company = card.dataset.company;
    const position = card.dataset.position;
    const start = card.dataset.start;
    const end = card.dataset.end;
    const description = card.dataset.description;
    const logo = card.dataset.logo;
    const tech = card.dataset.tech;
    const location = card.dataset.location;
    const link = card.dataset.link;
    const certificate = card.dataset.certificate;

    document.getElementById('modalCompany').textContent = company;
    document.getElementById('modalPosition').textContent = position;
    document.getElementById('modalDuration').textContent = formatDate(start) + " - " + formatDate(end);
    document.getElementById('modalDescription').innerHTML = decodeHTML(description);
    document.getElementById('modalLogo').src = logo ? logo : '';
    // Hide the logo if not provided, else display it
    document.getElementById('modalLogo').style.display = logo ? 'block' : 'none';
    document.getElementById('modalTech').textContent = tech;
    document.getElementById('modalLocation').textContent = location;
    document.getElementById('modalLink').href = link || '#';
    document.getElementById('modalCertificate').href = certificate ? certificate : '#';
    document.getElementById('internshipModal').style.display = "flex";
    document.getElementById('internshipModal').classList.add("show");
  }
  
  // Optional: Close modal if user clicks outside modal-content
  window.onclick = function(event) {
    const modal = document.getElementById('internshipModal');
    if (event.target === modal) {
      closeModal();
    }
  }
</script>
<?php require_once('inc/footer1.php') ?>
</body>
</html>
