
<?php 
	# Stop Hacking attempt
	define('__APP__', TRUE);
	
	# Start session
    session_start();
	
	# Database connection
	include ("dbconn.php");
	
	# Variables MUST BE INTEGERS
    if(isset($_GET['menu'])) { $menu   = (int)$_GET['menu']; }
	if(isset($_GET['action'])) { $action   = (int)$_GET['action']; }
	
	# Variables MUST BE STRINGS A-Z
    if(!isset($_POST['_action_']))  { $_POST['_action_'] = FALSE;  }
	
	if (!isset($menu)) { $menu = 1; }
	
	# Classes & Functions
    include_once("function.php");
	
print ' 

<!DOCTYPE html>
<html lang="en">
<head>
		
		<!-- CSS -->
		<link rel="stylesheet" href="style.css">
		<!-- End CSS -->
		<!-- meta elements -->
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="description" content="some description">
        <meta name="keywords" content="keyword 1, keyword 2, keyword 3, keyword 4, ...">
		
		<!-- Schema.org markup for Google+ -->
		<meta itemprop="name" content="Hello Example">
		<meta itemprop="description" content="Some description">
		<meta itemprop="image" content="Your URL"> 
		
		<!-- Open Graph data -->
		<meta property="og:title" content="Hello Example">
		<meta property="og:type" content="article">
		<meta property="og:url" content="Your URL">
		<meta property="og:image" content="Your URL">
		<meta property="og:description" content="Some description">
		<meta property="article:tag" content="keyword 1, keyword 2, keyword 3, keyword 4, ...">
		
		<!-- Twitter Card data -->
		<meta name="twitter:title" content="Hello Example">
		<meta name="twitter:description" content="Some description">
		
        <meta name="author" content="pzoric@tvz.hr">
		<!-- favicon meta -->
		<link rel="icon" href="favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
		<!-- end favicon meta -->
		<!-- end meta elements -->
		
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"> 
		<!-- End Google Fonts -->
		
    <title>Zadatak 3 php</title>
    <link rel="stylesheet" href="style-index.css">
   
</head>
<body>
    <header>
             <div'; if ($_GET['menu'] > 1) { print ' class="div-slika-subimage"'; } else { print ' class="div-slika-image"'; }  print '></div>
				<nav>';
			include("menu.php");
		print '</nav>		            
    </header>
    <main>';
    if (isset($_SESSION['message'])) {
        print $_SESSION['message'];
        unset($_SESSION['message']);
    }
		
	# Homepage
	if (!isset($_GET['menu']) || $_GET['menu'] == 1) { include("home.php"); }
	
	# News
	else if ($_GET['menu'] == 2) { include("news.php"); }
	
	# Contact
	else if ($_GET['menu'] == 3) { include("contact.php"); }
	
	# About us
	else if ($_GET['menu'] == 4) { include("about.php"); }
	
    # Gallery
	else if ($_GET['menu'] == 5) { include("gallery.php"); }

    # Register
    else if ($_GET['menu']== 6) { include("register.php"); }
	
    # Signin
    else if ($_GET['menu'] == 7) { include("signin.php"); }

    # Admin webpage
    else if ($_GET['menu'] == 8) { include("admin.php"); }


	print '
	</main>
    
    <footer>
        <p>Copyright &copy; 2022, Petar Zoric</p><a href = "https://github.com/pzoric"><img src = "social/github.svg" class = "ikona" alt="github" title="github" style="width:24px; margin-top:0.4em" ></a>
    </footer>
</body>
</html>';
?>