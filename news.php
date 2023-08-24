<?php
	
	if (isset($action) && $action != '') {
		$query  = "SELECT * FROM vijesti";
		$query .= " WHERE id=" . $_GET['action'];
		$result = @mysqli_query($user, $query);
		$row = @mysqli_fetch_array($result);

       $_query = "SELECT * FROM slike WHERE id_vijesti =" . $row['id'];
		$_result = @mysqli_query($user, $_query);

			print '
			<div class="news">
			<h1>VIJESTI</h1>';
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
			</div>';

		}
	else {
		print '<h1>VIJESTI</h1>';
		$query  = "SELECT * FROM vijesti";
		/*$query .= " WHERE arhiva='N'";*/
		$query .= " WHERE arhiva='0'";
		$query .= " ORDER BY datum DESC";
		$result = @mysqli_query($user, $query);
		/*$row2 = @mysqli_fetch_array($result);*/
		
		while($row2 = @mysqli_fetch_array($result)) {
            $_query = "SELECT * FROM slike WHERE id_vijesti =" . $row2['id'] . " LIMIT 1";
		    $_result = @mysqli_query($user, $_query);
			$_row = @mysqli_fetch_array($_result);
			
			print '
			<div class="news">
				
				<a href="index.php?menu=' . $menu . '&amp;action=' . $row2['id'] . '"><img src="news/' . $_row['naziv'] . '" alt="' . $_row['naziv'] . '" title="' . $row2['naslov'] . '"></a><a href="index.php?menu=' . $menu . '&amp;action=' . $row2['id'] . '"><h2>' . $row2['naslov'] . '</h2></a>';
				if(strlen($row2['opis']) > 300) {
					echo substr(strip_tags($row['opis']), 0, 300).'... <a href="index.php?menu=' . $menu . '&amp;action=' . $row2['id'] . '">Više</a>';
				} else {
					echo strip_tags($row2['opis']);
				}
				print '
				<p><time datetime="' . $row2['datum'] . '">' . DatumVijestiMysql($row2['datum']) . '</time></p>
				<hr>
			</div>';
		}
	}
?>