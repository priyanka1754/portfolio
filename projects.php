<?php
// Connect to your database
$conn = new mysqli("localhost", "root", "", "db_portfolio"); // change this accordingly
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php include('config.php'); ?>
<?php require_once('inc/header.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Projects</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    
    .nav {
  background-color: rgba(15, 15, 15, 0.95);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
  display: flex;
  justify-content: center;

}

.nav li a {
  color: #ccc;
}
.mt-100 {
  margin-top: 60px;
}

  #modalDescription p {
    margin-bottom: 1rem;
    text-align: justify;
    font-size: 1.5rem;
    color: #333;
    font-family: 'Segoe UI', sans-serif;
  }
  .card {
    border-radius: 12px;
  }

  .card img {
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
  }

  /* 2. Spacing between section title and cards, and between cards and footer */
  .mt-100 {
    margin-top: 60px !important;
  }

  .container.mt-5 {
    margin-bottom: 60px;
  }

  /* 3. Font changes for project card */
  .card-title {
    font-family: Calibri, sans-serif;
    font-size: 1.5rem;
    font-weight: bold;
    color: #222;
    margin-bottom: 0.5rem;
  }

  .card-text {
    font-family: Calibri, sans-serif;
    font-size: 1.5rem;
    color: #444;
  }

  /* 4. Modal content font styling */
  #modalDescription {
    font-family: Calibri, sans-serif;
    font-size: 1.5rem;
    color: #333;
    text-align: justify;
  }

  #modalSummary {
    font-family: Calibri, sans-serif;
    font-size: 1.5rem;
    color: #444;
  }

  #modalGithub {
    font-family: Calibri, sans-serif;
    font-size: 1.5rem;
    word-break: break-all;
  }

  #modalVideoContainer p {
    font-family: Calibri, sans-serif;
    font-size: 12px;
    color: #333;
  }

  /* Optional: modal title font for consistency */
  #modalTitle {
    font-family: Calibri, sans-serif;
  }
  #modal-header{
    font-size:20px;
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
<div class="container mt-5">
  <h1 class="text-center mb-4  mt-100">My Projects</h1>
  <div class="row">
    <?php
    $projects = $conn->query("SELECT * FROM project");
    while ($row = $projects->fetch_assoc()):
    ?>
    

    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm">
        <img src="<?php echo $row['banner']; ?>" class="card-img-top" alt="Project Banner" style="height: 200px; object-fit: cover;">
        <div class="card-body">
          <h5 class="card-title"><?php echo $row['name']; ?></h5>
          <p class="card-text"><?php echo $row['summary']; ?></p>
          <button
  class="btn btn-primary view-details"
  data-name='<?php echo htmlspecialchars($row['name'], ENT_QUOTES, "UTF-8"); ?>'
  data-banner='<?php echo htmlspecialchars($row['banner'], ENT_QUOTES, "UTF-8"); ?>'
  data-summary='<?php echo htmlspecialchars($row['summary'], ENT_QUOTES, "UTF-8"); ?>'
  data-description='<?php echo htmlspecialchars($row['description'], ENT_QUOTES, "UTF-8"); ?>'
  data-github='<?php echo htmlspecialchars($row['github_link'], ENT_QUOTES, "UTF-8"); ?>'
  data-video='<?php echo htmlspecialchars($row['video_url'], ENT_QUOTES, "UTF-8"); ?>'
  data-toggle="modal" 
  data-target="#projectModal"
>
  View Details
</button>


        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Project Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="modalBanner" src="" alt="Project Banner" class="img-fluid mb-3 rounded">
        <p><strong>Summary:</strong> <span id="modalSummary"></span></p>
        <p><strong>Description:</strong></p>
        <div id="modalDescription" class="border p-3 bg-light rounded"></div>
        <hr>
<p><strong>GitHub Link:</strong> <a id="modalGithub" href="#" target="_blank">View on GitHub</a></p>

<div id="modalVideoContainer" class="mt-3">
  <p><strong>Demo Video:</strong></p>
  <video id="modalVideo" controls style="width: 100%; max-height: 400px;" class="rounded shadow-sm">
    Your browser does not support the video tag.
  </video>
</div>

      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

 <script>
  document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".view-details");

    buttons.forEach(btn => {
      btn.addEventListener("click", function () {
        // Set title, banner, summary
        document.getElementById("modalTitle").innerText = this.dataset.name;
        document.getElementById("modalBanner").src = this.dataset.banner;
        document.getElementById("modalSummary").innerText = this.dataset.summary;

        // Get encoded HTML from data-description
        const encodedHTML = this.getAttribute("data-description");

        // Decode HTML entities (like &lt; into <)
        const txt = document.createElement("textarea");
        txt.innerHTML = encodedHTML;
        let decodedHTML = txt.value;

        // Remove inline styles
        decodedHTML = decodedHTML.replace(/style="[^"]*"/g, "");

        // Finally, set as innerHTML
        document.getElementById("modalDescription").innerHTML = decodedHTML;
        // Set GitHub link
const github = this.getAttribute("data-github");
const modalGithub = document.getElementById("modalGithub");
modalGithub.href = github;
modalGithub.innerText = github;

// Set video source
const videoUrl = this.getAttribute("data-video");
const modalVideo = document.getElementById("modalVideo");
const modalVideoContainer = document.getElementById("modalVideoContainer");

if (videoUrl && videoUrl.trim() !== "") {
  modalVideo.src = videoUrl;
  modalVideoContainer.style.display = "block";
} else {
  modalVideoContainer.style.display = "none";
}

      });
    });
  });

</script>
   <?php require_once('inc/footer1.php') ?>
</body>
</html>
