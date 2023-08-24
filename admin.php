<?php 
	if ($_SESSION['user']['valid'] == 'true') {
		if (!isset($action)) { $action = 1; }
		print '
		<h1>Administracija</h1>
		<div id="admin">
			<ul>
				<li><a href="index.php?menu=8&amp;action=1">Korisnici</a></li>
				<li><a href="index.php?menu=8&amp;action=2">Vijesti</a></li>
			</ul>';
			# Administracija korisnika
			if ($action == 1) { include("admin/korisnici.php"); }
			
			# Administracija vijesti
			else if ($action == 2) { include("admin/vijesti.php"); }
		print '
		</div>';
	}
	else {
		$_SESSION['message'] = '<p>Napravite registraciju ili prijavu!</p>';
		header("Location: index.php?menu=7");
	}
?>