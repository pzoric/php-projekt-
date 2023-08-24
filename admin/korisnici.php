<?php 
	
	# Uređivanje korisničkog profila
	if (isset($_POST['edit']) && $_POST['_action_'] == 'TRUE') {
		$query  = "UPDATE user SET firstname='" . $_POST['firstname'] . "', lastname='" . $_POST['lastname'] . "', email='" . $_POST['email'] . "', username='" . $_POST['username'] . "', country='" . $_POST['country'] . "', arhiva='" . $_POST['archive'] . "', role='" . $_POST['role'] . "'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($user, $query);
		@mysqli_close($user);
		
		$_SESSION['message'] = '<p>Profil uspješno ažuriran!</p>';
		header("Location: index.php?menu=8&action=1");
	}
	
	# Brisanje korisnika
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
	
		$query  = "DELETE FROM user";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($user, $query);

		$_SESSION['message'] = '<p>Uspješno izbrisan korisnik!</p>';
		header("Location: index.php?menu=8&action=1");
	}
	
	
	#Prikaz korisničkog profila
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM user";
		$query .= " WHERE id=".$_GET['id'];
		$result = @mysqli_query($user, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<h2>Korisnički profil</h2>
		<p><b>ime:</b> ' . $row['firstname'] . '</p>
		<p><b>Prezime:</b> ' . $row['lastname'] . '</p>
		<p><b>Korisničko ime:</b> ' . $row['username'] . '</p>';
		$_query  = "SELECT * FROM countries";
		$_query .= " WHERE country_code='" . $row['country'] . "'";
		$_result = @mysqli_query($user, $_query);
		$_row = @mysqli_fetch_array($_result);
		print '
		<p><b>Država:</b> ' .$_row['country_name'] . '</p>
		
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
	}
	#Uređivanje korisničkog profila
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM user";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($user, $query);
		$row = @mysqli_fetch_array($result);
		$checked_archive = false;
		
		print '
		<h2>Uređivanje korisničkog profila</h2>
        <div id="forma">
		<form action="" id="forma_registracija" name="forma_registracija" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			<input type="hidden" id="edit" name="edit" value="' . $_GET['edit'] . '">
			
			<label for="fname">firstname *</label>
			<input type="text" id="fname" name="firstname" value="' . $row['firstname'] . '" placeholder="Vaše ime..." required>
			<label for="lname">Prezime *</label>
			<input type="text" id="lname" name="lastname" value="' . $row['lastname'] . '" placeholder="Vaše prezime..." required>
				
			<label for="email">E-mail adresa *</label>
			<input type="email" id="email" name="email"  value="' . $row['email'] . '" placeholder="Vaša e-mail adresa..." required>
			
			<label for="username">Korisničko ime *<small>(Korisničko ime mora imati 5-10 znakova)</small></label>
			<input type="text" id="username" name="username" value="' . $row['username'] . '" pattern=".{5,10}" placeholder="Korisničko ime..." required><br>
			
			<label for="country">Država</label>
			<select name="country" id="country">
				<option value="">Molimo odaberite:</option>';
				#Sve države iz tablice countries
				$_query  = "SELECT * FROM countries";
				$_result = @mysqli_query($user, $_query);
				while($_row = @mysqli_fetch_array($_result)) {
					print '<option value="' . $_row['country_code'] . '"';
					if ($row['country'] == $_row['country_code']) { print ' selected'; }
					print '>' . $_row['country_name'] . '</option>';
				}
			print '
			</select>
			<label for "date">Datum rođenja</label>
			<input type="date" name="date" id="date" value="' . $row['date'] . '">
			<label for="archive">Arhiva:</label><br />
            <input type="radio" name="archive" value="Y"'; if($row['arhiva'] == 'Y') { echo ' checked="checked"'; $checked_archive = true; } echo ' /> DA &nbsp;&nbsp;
			<input type="radio" name="archive" value="N"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> NE
			
			<label for="role">Prava:</label><br />
			<input type="radio" name="role" value="1"'; if($row['role'] == '1') { echo ' checked="checked"';} echo ' /> Korisnik &nbsp;&nbsp;
			<input type="radio" name="role" value="2"'; if($row['role'] == '2') { echo ' checked="checked"';} echo ' /> Editor &nbsp;&nbsp;
			<input type="radio" name="role" value="3"'; if($row['role'] == '3') { echo ' checked="checked"';} echo ' /> Administrator &nbsp;&nbsp;

			<hr>
			
			<input type="submit" value="Spremi">
		</form>
        </div>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Back</a></p>';
	}
	
	else if ($_SESSION['user']['role'] == (3) ){
		print '
		<h2>Lista korisnika</h2>
		<div id="users">
			<table>
				<thead>
					<tr>
						<th width="16"></th>
						<th width="16"></th>
						<th width="16"></th>
						<th>Ime</th>
						<th>Prezime</th>
						<th>E-mail adresa</th>
						<th>Država</th>
						<th width="16"></th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM user";
				$result = @mysqli_query($user, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="img/user.png" alt="KORISNIK"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="img/edit.png" alt="UREDI"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="img/delete.png" alt="OBRIŠI"></a></td>
						<td><strong>' . $row['firstname'] . '</strong></td>
						<td><strong>' . $row['lastname'] . '</strong></td>
						<td>' . $row['email'] . '</td>
						<td>';
							$_query  = "SELECT * FROM countries";
							$_query .= " WHERE country_code='" . $row['country'] . "'";
							$_result = @mysqli_query($user, $_query);
							$_row = @mysqli_fetch_array($_result, MYSQLI_ASSOC);
							print $_row['country_name'] . '
						</td>
						<td>';
							if ($row['arhiva'] == 'Y') { print '<img src="img/inactive.png" alt="" title="" />'; }
                            else if ($row['arhiva'] == 'N' || $row['arhiva'] == '') { print '<img src="img/active.png" alt="" title="" />'; }
						print '
						</td>
					</tr>';
				}
			print '
				</tbody>
			</table>
		</div>';
	}
	else{
		echo '<p>Niste administrator  !</p>';
	}
	
	@mysqli_close($user);
?>