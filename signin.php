<?php 
	print '
	<h1>Sign In </h1>
	<div id="signin">';
	
	if ($_POST['_action_'] == FALSE) {
		print '
		<form action="" name="myForm" id="myForm" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			<label for="username">Username:*</label>
			<input type="text" id="username" name="username" value="" pattern=".{5,10}" required>
									
			<label for="password">Password:*</label>
			<input type="password" id="password" name="password" value="" pattern=".{4,}" required>
									
			<input type="submit" value="Submit">
		</form>';
	}
	else if ($_POST['_action_'] == TRUE) {
		
		$query  = "SELECT * FROM user";
		$query .= " WHERE username='" .  $_POST['username'] . "'";
		$sql = @mysqli_query($user, $query);
		$row = @mysqli_fetch_array($sql, MYSQLI_ASSOC);
		
		if (password_verify($_POST['password'], $row['password'])  && $row['role'] != 0 && $row['arhiva'] == 'N') {
			#password_verify https://secure.php.net/manual/en/function.password-verify.php
			$_SESSION['user']['valid'] = 'true';
			$_SESSION['user']['id'] = $row['id'];
			$_SESSION['user']['firstname'] = $row['firstname'];
			$_SESSION['user']['lastname'] = $row['lastname'];
			$_SESSION['user']['role'] = $row['role'];
			$_SESSION['message'] = '<p>Dobrodošli, ' . $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] . '</p>';
			# Redirect to admin website
			if ($row['role'] == 2 || $row['role'] == 3){
				header("Location: index.php?menu=8");
			}
			if ($row['role'] == 1){
				header("Location: index.php?menu=1");
			}
		}
		
		# Bad username or password
		else if ($row['arhiva'] == 'Y'){
			$_SESSION['message'] = '<p>Vaš račun je arhiviran!</p>';
			header("Location: index.php?menu=7");
		}
		else if ($row['role'] == 0){
			$_SESSION['message'] = '<p>Još nemate pravo prijave!</p>';
			header("Location: index.php?menu=7");
		}
		else {
			unset($_SESSION['user']);
			$_SESSION['message'] = '<p>Upisali ste  pogrešan email ili password!</p>';
			header("Location: index.php?menu=6");
		}
	}
	print '
	</div>';
?>