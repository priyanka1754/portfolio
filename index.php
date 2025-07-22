<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
<?php require_once('inc/header.php') ?>
<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
<head>
  <style>
    body {
  background: #1e1e1e;
  color: #eaeaea;
  font-family: 'Poppins', sans-serif;
}

header#home {
  background: url('uploads/bg-clean.jpg') no-repeat center center/cover;
  height: 100vh;
  color: white;
  text-align: center;
  padding-top: 15vh;
  background-blend-mode: darken;
  background-color: rgba(0, 0, 0, 0.6);
}

h1, h2, h3, h4, h5 {
  color: #f0f0f0;
}

a, a:hover {
  color: #62c3ff;
  text-decoration: none;
}

.nav {
  background-color: rgba(15, 15, 15, 0.95);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.nav li a {
  color: #ccc;
}

/* Timeline */
.timeline {
  position: relative;
  padding-left: 30px;
  margin-bottom: 40px;
}

.timeline:before {
  content: '';
  position: absolute;
  top: 0;
  left: 10px;
  width: 2px;
  height: 100%;
  background: #4a4a4a;
}

.timeline-item {
  background: #2b2b2b;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.3);
  margin-bottom: 2rem;
  position: relative;
  transition: transform 0.3s ease;
}

.timeline-item:hover {
  transform: translateY(-5px);
}

.timeline-item:before {
  content: '';
  position: absolute;
  left: -6px;
  top: 10px;
  width: 14px;
  height: 14px;
  border-radius: 50%;
  background: #ccc;
  border: 2px solid #1e1e1e;
  transition: transform 0.3s ease, background-color 0.3s ease;
}

.timeline-item:hover:before {
  transform: scale(1.2);
  background-color: #f0f0f0;
}

.timeline-content {
  padding-left: 20px;
}

#about {
  background-color: #2e2e2e;
  padding: 2rem 0;
}

#about_me * {
  color: #ccc !important;
}

.skills-section {
  background-color: #2e2e2e;
  padding: 3rem 2rem;
  border-radius: 20px;
  box-shadow: 0 4px 25px rgba(0,0,0,0.3);
  margin-bottom: 4rem;
}

.skills-category {
  margin-left:150px;
  margin-bottom: 2rem;
}

.skills-category h3 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
  border-left: 4px solid #00bfff;
  padding-left: 10px;
  color: #f0f0f0;
}

.skills-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
  gap: 18px;
  margin-top: 25px;
  margin-bottom: 30px;
}

.skill-item {
  background:rgb(252, 250, 250);
  border-radius: 10px;
  padding: 1rem;
  text-align: center;
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  transition: transform 0.2s, box-shadow 0.2s;
}

.skill-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.4);
}

.skill-item img {
  width: 140px;
  height: 100px;
  object-fit: contain;
  margin-bottom: 0.5rem;
}

.skill-item span {
  font-size: 0.95rem;
  color: #f0f0f0;
}

.skill-box {
  background: #2d2d2d;
  padding: 12px 15px;
  text-align: center;
  border-radius: 8px;
  font-weight: 600;
  color: #eee;
  box-shadow: 0 3px 8px rgba(0,0,0,0.25);
  transition: all 0.3s ease;
}

.skill-box:hover {
  transform: translateY(-5px);
  background-color: #3a3a3a;
  box-shadow: 0 6px 12px rgba(0,0,0,0.4);
}

/* Responsive */
@media only screen and (max-width: 767px) {
  .skills-grid {
    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
    gap: 12px;
  }

  .timeline {
    padding-left: 25px;
  }

  .timeline-content {
    padding-left: 15px;
  }
  .timeline-content p {
  color: white !important;
}

}

  </style>
</head>

<body>
    <!-- Header -->
    <header id="home" style="background: url('uploads/bg-clean.jpg') no-repeat center center/cover;">
        <nav id="nav-wrap">
            <a class="mobile-btn" href="#nav-wrap" title="Show navigation">Show navigation</a>
            <a class="mobile-btn" href="#" title="Hide navigation">Hide navigation</a>

            <ul id="nav" class="nav">
                <li class="current"><a class="smoothscroll" href="index.php">Home</a></li>
                <li><a class="smoothscroll" href="#about">About</a></li>
                <li><a href="uploads/22761A0506_Resume.pdf" target="_blank">Resume</a></li>
                <li><a href="projects.php">Projects</a></li>
                <li><a href="internships.php">Internships</a></li>
                <li><a href="achievements.php">Achievements</a></li>
                <li><a href="certificates.php">Certificates</a></li>
                <li><a href="blogs.php">Blogs</a></li>
            </ul>
        </nav>
        
        <?php 
        // Fetch user data
        $u_qry = $conn->query("SELECT * FROM users WHERE id = 1");
        foreach($u_qry->fetch_array() as $k => $v){
            if(!is_numeric($k)){
                $user[$k] = $v;
            }
        }
        
        // Fetch contact information
        $c_qry = $conn->query("SELECT * FROM contacts");
        while($row = $c_qry->fetch_assoc()){
            $contact[$row['meta_field']] = $row['meta_value'];
        }
        ?>
        
        <div class="row banner">
            <div class="banner-text">
                <h1 class="responsive-headline">I'm <?php echo ucwords($user['firstname'].' '.$user['lastname']); ?>.</h1>
                <h3><?php echo stripslashes($_settings->info('welcome_message')) ?></h3>
                <hr />
                <ul class="social">
                    <li><a target="_blank" href="<?php echo $contact['twitter'] ?>" aria-label="Github"><i class="fa fa-github"></i></a></li>
                    <li><a target="_blank" href="mailto:<?php echo $contact['email'] ?>" aria-label="Email"><i class="fa fa-envelope"></i></a></li>
                    <li><a target="_blank" href="<?php echo $contact['linkin'] ?>" aria-label="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div>

        <p class="scrolldown">
            <a class="smoothscroll" href="#about" aria-label="Scroll down"><i class="icon-down-circle"></i></a>
        </p>
    </header>

    <!-- About Section -->
    <section id="about" >
        <div class="row">
            <div class="three columns">
                <img class="profile-pic" src="uploads\WhatsApp Image 2025-04-22 at 13.38.26_d9020761.jpg" alt="Profile Picture" />
            </div>
            <div class="nine columns main-col">
                <h2>About Me</h2>
                <div id="about_me"><?php include "about.html"; ?></div>
                <div class="row">
                    <div class="columns contact-details">
                        <h2>Contact Details</h2>
                        <p class="address">
                            <span><?php echo $contact['address'] ?></span><br>
                            <span><?php echo $contact['mobile'] ?></span><br>
                            <span><?php echo $contact['email'] ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Education Section -->
    <section id="education">
        <div class="row education">
            <div class="three columns header-col">
                <h1><span>Education</span></h1>
            </div>
            <div class="nine columns main-col">
                <div class="timeline">
                <?php 
                $e_qry = $conn->query("SELECT * FROM education ORDER BY year DESC, month DESC");
                while($row = $e_qry->fetch_assoc()):
                ?>
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <h3><?php echo htmlspecialchars($row['school']) ?></h3>
                            <p class="info"><?php echo htmlspecialchars($row['degree']) ?> 
                               <span>&bull;</span> 
                            </p>
                            <div class="edu-desc"><?php echo strip_tags(stripslashes(html_entity_decode($row['description'])), '<strong><em><b><i><u><br><ul><li><ol>') ?></div>
                        </div>
                    </div>
                <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->

<div class="skills-section">
  
  <!-- Frontend -->
  <div class="skills-category">
  <h2>My Skills</h2>
  <br>
    <h3>Frontend</h3>
    <div class="skills-grid">
      <div class="skill-item">
        <img src="uploads/icons/html.png" alt="HTML">
      </div>
      <div class="skill-item">
        <img src="uploads/icons/css.png" alt="CSS">
      </div>
      <div class="skill-item">
        <img src="uploads/icons/js.png" alt="JavaScript">
      </div>
    </div>
  </div>

  <!-- Backend -->
  <div class="skills-category">
    <h3>Backend</h3>
    <div class="skills-grid">
      <div class="skill-item">
        <img src="uploads/icons/php.png" alt="PHP">
      </div>
      <div class="skill-item">
        <img src="uploads/icons/nodejs.png" alt="Node.js">
      </div>
      <div class="skill-item">
        <img src="uploads/icons/expressjs.png" alt="Node.js">
      </div>
    </div>
  </div>

  <!-- Database -->
  <div class="skills-category">
    <h3>Database</h3>
    <div class="skills-grid">
      <div class="skill-item">
        <img src="uploads/icons/oracle.png" alt="Oracle">
      </div>
      <div class="skill-item">
        <img src="uploads/icons/mongodb.png" alt="MongoDB">
      </div>
    </div>
  </div>
</div>


    <?php require_once('inc/footer.php') ?>
    
   
</body>
</html>