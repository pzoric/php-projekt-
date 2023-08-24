<?php 
	
	#Dodavanje vijesti
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'add_news') {
		$_SESSION['message'] = '';
		if ($_SESSION['user']['role'] == 2 || $_SESSION['user']['role'] == 3){
			$query  = "INSERT INTO vijesti (naslov, opis, arhiva)";
			$query .= " VALUES ('" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', '" . $_POST['archive'] . "')";
		}
		else if ($_SESSION['user']['role'] == 1){
			$query  = "INSERT INTO vijesti (naslov, opis, arhiva)";
			$query .= " VALUES ('" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', 'Y')";	
		}
		$result = @mysqli_query($user, $query);
		$ID = mysqli_insert_id($user);
		
		/*if(array_filter($_FILES['picture']['name']) != "") { */
		
			if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
                
			
			foreach ($_FILES['picture']['name'] as $index => $value) {
				$ext = strtolower(strrchr($_FILES['picture']['name'][$index], "."));
				
				$_picture = $ID . '-' . rand(1,100) . $ext;
				echo $_picture;
				if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') {
					copy($_FILES['picture']['tmp_name'][$index], "news/".$_picture);
					$_query  = "INSERT INTO slike (naziv, id_vijesti)";
					$_query .= " WHERE id=" . $ID . " LIMIT 1";
					$_query .= " VALUES ('$_picture', $ID)";
					
					$_result = @mysqli_query($user, $_query);
					$_SESSION['message'] .= '<p>bravoooooooooo!</p>';
				}
			}
        }

		/*
        if(array_filter($_FILES['picture']['name']) != "") {
            
			foreach ($_FILES['picture']['name'] as $index => $value) {
				$ext = strtolower(strrchr($_FILES['picture']['name'][$index], "."));
				
				$_picture = $ID . '-' . rand(1,100) . $ext;
				echo $_picture;
				if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') {
					copy($_FILES['picture']['tmp_name'][$index], "news/".$_picture);
					$_query  = "INSERT INTO slike (naziv, id_vijesti)";
					$_query .= " VALUES ('$_picture', $ID)";
					$_result = @mysqli_query($user, $_query);
					$_SESSION['message'] .= '<p>Uspješno dodane slike!</p>';
				}
			}
        }*/
		
		
		$_SESSION['message'] .= '<p>Vijest dodana!</p>';
		
		header("Location: index.php?menu=8&action=2");
	}
	
	# Ažuriranje vijesti
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'edit_news') {
		$query  = "UPDATE vijesti SET naslov='" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', opis='" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', arhiva='" . $_POST['archive'] . "'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($user, $query);
		$ID = (int)$_POST['edit'];
		


		if(array_filter($_FILES['picture']['name']) != "") {
            
			foreach ($_FILES['picture']['name'] as $index => $value) {
				$ext = strtolower(strrchr($_FILES['picture']['name'][$index], "."));
				
				$_picture = $ID . '-' . rand(1,100) . $ext;
				echo $_picture;
				if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') {
					copy($_FILES['picture']['tmp_name'][$index], "news/".$_picture);
					$_query  = "INSERT INTO slike (naziv, id_vijesti)";
					$_query .= " VALUES ('$_picture', $ID)";
					$_result = @mysqli_query($user, $_query);
					$_SESSION['message'] .= '<p>Uspješno dodane slike!</p>';
				}
			}
        }
		$_SESSION['message'] = '<p>Uspješna promjena vijesti!</p>';
		
		header("Location: index.php?menu=8&action=2");
	}
	
	# Brisanje vijesti
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
		if ($_SESSION['user']['role'] == 3){
		# Brisanje slike
        $query  = "SELECT slika FROM vijesti";
        $query .= " WHERE id=".(int)$_GET['delete']." LIMIT 1";
        $result = @mysqli_query($user, $query);
        $row = @mysqli_fetch_array($result);
        @unlink("news/".$row['slika']); 
		
		# Brisanje vijesti
		$query  = "DELETE FROM vijesti";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($user, $query);

		$_SESSION['message'] = '<p>Uspješno obrisana vijest!</p>';
		
		header("Location: index.php?menu=8&action=2");
		}
		else{
			echo '<p>Nemate pravo brisanja!</p>';
		}
	}
	
	
	#Prikaz jedne vijesti
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM vijesti";
		$query .= " WHERE id=".$_GET['id'];
		$query .= " ORDER BY datum DESC";
		$result = @mysqli_query($user, $query);
		$row = @mysqli_fetch_array($result);

		$_query = "SELECT * FROM slike WHERE id_vijesti =" . $_GET['id'];
		$_result = @mysqli_query($user, $_query);

		print '
		<h2>Pregled vijesti</h2>
		<div class="news">';
		while ($_row = @mysqli_fetch_array($_result)) {
			print'
				<img src="news/' . $_row['naziv'] . '" alt="' . $_row['naziv'] . '" title="' . $_row['naziv'] . '">
			';
		}
		print '
			<hr>
			<h2>' . $row['naslov'] . '</h2>
			<p>'  . $row['opis'] . '</p>
			<p><time datetime="' . $row['datum'] . '">' . DatumVijestiMysql($row['datum']) . '</time></p>
			<hr>
			</div>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
		
	}
	
	#Dodavanje vijesti
	else if (isset($_GET['add']) && $_GET['add'] != '') {
		
		print '
		<h2>Dodavanje vijesti</h2>
        <div id="forma">
		<form action="" id="vijesti_form" name="vijesti_form" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="add_news">
			
			<label for="title">Naslov *</label>
			<input type="text" id="title" name="title" placeholder="Naslov..." required>
			<label for="description">Opis *</label>
			<textarea id="description" name="description" placeholder="Opis..." required></textarea>
				
			<label for="picture">Slika</label>
			<input type="file" id="picture" name="picture[]" multiple>';
			
			if ($_SESSION['user']['role'] == 2 || $_SESSION['user']['role'] == 3){
				print'
					<label for="archive">Arhiva:</label><br />
					<input type="radio" name="archive" value="Y"> DA &nbsp;&nbsp;
					<input type="radio" name="archive" value="N" checked> NE';
			}
			print'
			<hr>
			
			<input type="submit" value="Spremi">
		</form>
        </div>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
		
	}
	#Uređivanje vijesti
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM vijesti";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($user, $query);
		$row = @mysqli_fetch_array($result);
		$checked_archive = false;

		print '
		<h2>Uređivanje vijesti</h2>
        <div id="forma">
		<form action="" id="edit_vijesti" name="edit_vijesti" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="edit_news">
			<input type="hidden" id="edit" name="edit" value="' . $row['id'] . '">
			
			<label for="title">Naslov *</label>
			<input type="text" id="title" name="title" value="' . $row['naslov'] . '" placeholder="Naslov..." required>
			<label for="description">Opis *</label>
			<textarea id="description" name="description" placeholder="Opis..." required>' . $row['opis'] . '</textarea>
				
			<label for="picture">Slika</label>
			<input type="file" id="picture" name="picture[]" multiple>
						
			<label for="archive">Arhiva:</label><br />
            <input type="radio" name="archive" value="Y"'; if($row['arhiva'] == 'Y') { echo ' checked="checked"'; $checked_archive = true; } echo ' /> DA &nbsp;&nbsp;
			<input type="radio" name="archive" value="N"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> NE
			
			<hr>
			
			<input type="submit" value="Spremi">
		</form>
        </div>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
		
	}
	else if ($_SESSION['user']['role'] == 2 || $_SESSION['user']['role'] == 3 ){
		print '
		<h2>Vijesti</h2>
		<div id="news">
			<table>
				<thead>
					<tr>
						<th width="16"></th>
						<th width="16"></th>
						<th width="16"></th>
						<th>Naslov</th>
						<th>Opis</th>
						<th>Datum</th>
						<th width="16"></th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM vijesti";
				$query .= " ORDER BY datum DESC";
				$result = @mysqli_query($user, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="img/user.png" alt="KORISNIK"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="img/edit.png" alt="UREDI"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="img/delete.png" alt="OBRIŠI"></a></td>
						<td>' . $row['naslov'] . '</td>
						<td>';
						if(strlen($row['opis']) > 160) {
                            echo substr(strip_tags($row['opis']), 0, 160).'...';
                        } else {
                            echo strip_tags($row['opis']);
                        }
						print '
						</td>
						<td>' . DatumVijestiMysql($row['datum']) . '</td>
						<td>';
							if ($row['arhiva'] == 'Y') { print '<img src="img/inactive.png" alt="" title="" />'; }
                            else if ($row['arhiva'] == 'N') { print '<img src="img/active.png" alt="" title="" />'; }
						print '
						</td>
					</tr>';
				}
			print '
				</tbody>
			</table><br>
			<button class="NovaVijest"><a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;add=true">Dodaj novu vijest</a></button>
		</div>';
	}
	else{
		print '
		<button class="NovaVijest"><a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;add=true">Dodaj novu vijest</a></button>
		';
	}
	
	@mysqli_close($user);
?>