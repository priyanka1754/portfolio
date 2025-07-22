<?php
  require_once('sess_auth.php');
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<title><?php echo $_settings->info('title') != false ? $_settings->info('title').' | ' : '' ?><?php echo $_settings->info('name') ?></title>
    <link rel="icon" href="<?php echo validate_image($_settings->info('logo')) ?>" />
    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
      <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
   <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.css">
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/custom.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.css">
     <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <style type="text/css">/* Chart.js */
      @keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}
    </style>

     <!-- jQuery -->
    <script src="<?php echo base_url ?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?php echo base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?php echo base_url ?>plugins/toastr/toastr.min.js"></script>
    <script>
        var _base_url_ = '<?php echo base_url ?>';
    </script>
    <script src="<?php echo base_url ?>dist/js/script.js"></script>

    <!-- Additional function to set active class based on current page -->
    <script>
        $(document).ready(function() {
            // Get current page URL
            var currentPage = window.location.pathname.split('/').pop();
            
            // If empty (index page), set homepage as active
            if(currentPage == '' || currentPage == 'index.php') {
                $('#nav li:first-child').addClass('current');
            } else {
                // Otherwise set the appropriate nav item as active
                $('#nav li a').each(function() {
                    var href = $(this).attr('href');
                    if(href == currentPage) {
                        $(this).parent().addClass('current');
                        $('#nav li:first-child').removeClass('current');
                    }
                });
            }
        });
    </script>
</head>

<?php
// Function to determine if a menu item should be marked as active
function is_active($page_name) {
    $current_page = basename($_SERVER['PHP_SELF']);
    if($current_page == 'index.php' && $page_name == 'home') {
        return 'current';
    } elseif($current_page == $page_name) {
        return 'current';
    } else {
        return '';
    }
}

// Reusable navigation function
function get_navigation() {
    ?>
    <nav id="nav-wrap">
        <a class="mobile-btn" href="#nav-wrap" title="Show navigation">Show navigation</a>
        <a class="mobile-btn" href="#" title="Hide navigation">Hide navigation</a>

        <ul id="nav" class="nav">
            <li class="<?php echo is_active('home'); ?>"><a class="smoothscroll" href="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' ? '#home' : 'index.php#home'); ?>">Home</a></li>
            <li class="<?php echo is_active('about'); ?>"><a class="smoothscroll" href="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' ? '#about' : 'index.php#about'); ?>">About</a></li>
            <li><a href="uploads/22761A0506_Resume.pdf" target="_blank">Resume</a></li>
            <li class="<?php echo is_active('projects.php'); ?>"><a href="projects.php">Projects</a></li>
            <li class="<?php echo is_active('internships.php'); ?>"><a href="internships.php">Internships</a></li>
            <li class="<?php echo is_active('achievements.php'); ?>"><a href="achievements.php">Achievements</a></li>
            <li class="<?php echo is_active('certificates.php'); ?>"><a href="certificates.php">Certificates</a></li>
            <li class="<?php echo is_active('blogs.php'); ?>"><a href="blogs.php">Blogs</a></li>
        </ul>
    </nav>
    <?php
}
?>