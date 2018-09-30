<!DOCTYPE html>

<html>
	<head>
		<title>Globe</title>
	</head>

	<body>
	
		<header style="background-color:white;border:1px solid grey">
			<h1><center>Welcome to Global discussion forum<center></h1>
		</header>
		
		<div>
			<div style="background-color:white;width:73%;float:left;font-size:24px;padding:2.5%;border:1px solid grey;margin-right:4px">
				<?php
					//login and signup
					include("welcometext.php");
				?>
			</div>
			<div style="background-color:black;width:20%;float:left;padding-bottom:10px;min-width:200px">
				<?php
					//login and signup
					include("accountmanager.php");
				?>
				
			</div>
		</div>
		
	</body>
</html>