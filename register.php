<?php 
	print '
	<h1>Registracija korisnika</h1>
	<div id="register">';
	
	if ($_POST['_action_'] == FALSE) {
		print '
		<form action="" id="registration_form" name="registration_form" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			
			<label for="fname">Ime *</label>
			<input type="text" id="fname" name="firstname" placeholder="Your name.." required>
			<label for="lname">Prezime *</label>
			<input type="text" id="lname" name="lastname" placeholder="Your last natme.." required>
				
			<label for="email">Your E-mail *</label>
			<input type="email" id="email" name="email" placeholder="Your e-mail.." required>
			
			<label for="username">Username:* <small>(Username must have min 5 and max 10 char)</small></label>
			<input type="text" id="username" name="username" pattern=".{5,10}" placeholder="Username.." required><br>
			
									
			<label for="password">Password:* <small>(Password must have min 4 char)</small></label>
			<input type="password" id="password" name="password" placeholder="Password.." pattern=".{4,}" required>
			<label for="country">Country: </label>
				<select name="country" id="country">
				<option value="">molimo odaberite</option>';
				#Select all countries from database webprog, table countries
				$query  = "SELECT * FROM countries";
				$result = @mysqli_query($user, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '<option value="' . $row['country_code'] . '">' . $row['country_name'] . '</option>';
				}
				print '
			</select>
			<label for="city">Grad</label>
			<input type="text" id="city" name="city" placeholder="Grad...">
			<label for="address">Adresa</label>
			<input type="text" id="address" name="address" placeholder="Adresa...">
			<label for "date">Datum rođenja:</label>
			<input type="date" name="date" id="date">
			<input type="submit" value="Submit">
		</form>';
	}
	else if ($_POST['_action_'] == TRUE) {
		
		$query  = "SELECT * FROM user";
		$query .= " WHERE email='" .  $_POST['email'] . "'";
		$query .= " OR username='" .  $_POST['username'] . "'";
		$sql = @mysqli_query($user, $query);
		$row = @mysqli_fetch_array($sql, MYSQLI_ASSOC);
		
				if (!isset ($row['email'] ) || !isset ($row['username'])) {
			# password_hash https://secure.php.net/manual/en/function.password-hash.php
			# password_hash() creates a new password hash using a strong one-way hashing algorithm
			$pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);
			
			$query  = "INSERT INTO user (firstname, lastname, email, username, password, country, city, address, date)";
			$query .= " VALUES ('" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['email'] . "', '" . $_POST['username'] . "', '" . $pass_hash . "', '" . $_POST['country'] . "','" . $_POST['city'] . "','" . $_POST['address'] . "','" . $_POST['date'] . "')";
			$sql = @mysqli_query($user, $query);
			
			# ucfirst() — Make a string's first character uppercase
			# strtolower() - Make a string lowercase
			echo '<p>' . ucfirst(strtolower($_POST['firstname'])) . ' ' .  ucfirst(strtolower($_POST['lastname'])) . ', Hvala na registraciji</p>
			<hr>';
		}
		else {
			echo '<p>User sa tim emailom ili username već postoji!</p>';
		}
	}
	print '
	</div>';
?>