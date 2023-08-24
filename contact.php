<?php 
	print '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadatak 9</title>
    <link rel="stylesheet" href="style-index.css">
</head>
<body>
    <header>
             
        <nav class = "navbar">
            <div class = "div-slika" >
                <h1>Kontakt</h1>
                <img src = "html-5.jpg" class = "slika" >
           
        </nav>
        </div>
        
    
    </header>
    
    <main>
		
		<div id="contact">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22258.850366209386!2d15.95838973534726!3d45.78408924065129!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4765d68b441ce2df%3A0x54e2a03adf42446f!2sTehni%C4%8Dko%20veleu%C4%8Dili%C5%A1te%20u%20Zagrebu!5e0!3m2!1shr!2shr!4v1670260207130!5m2!1shr!2shr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			<form action="http://work2.eburza.hr/pwa/responsive-page/html/send-contact.php" id="contact_form" name="contact_form" method="POST">
			</div>
        <form class = "kontakt_forma" action = "" method = "post">
				<label for="fname">First Name *</label>
				<input type="text" id="fname" name="firstname" placeholder="Your name.." required>

				<label for="lname">Last Name *</label>
				<input type="text" id="lname" name="lastname" placeholder="Your last name.." required>
				
				<label for="lname">Your E-mail *</label>
				<input type="email" id="email" name="email" placeholder="Your e-mail.." required>

				<label for="country">Country</label>
				<select id="country" name="country">
				  <option value="">Please select</option>
				  <option value="AU">Australija</option>
				  <option value="HR" selected>Croatia</option>
				  <option value="DE">Germany</option>
				  <option value="UK">United Kingdom</option>
				</select>

				<label for="subject">Subject</label>
				<textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>

				<input type="submit" value="Submit">
			</form>
		
	</main>
    <footer>
        <p>Copyright &copy; 2022, Petar Zoric</p><a href = "https://github.com/pzoric"><img src = "social/github.svg" class = "ikona" alt="github" title="github" style="width:24px; margin-top:0.4em" ></a>
    </footer>
</body>
</html>';
?>