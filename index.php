<!DOCTYPE html>

<?php
	session_start();
?>
<html>
	<head>
		<title>Global discussion forum</title>
		
	</head>

	<body>
		<div>	
		<?php
		//var_export($_SESSION);
			if(isset($_SESSION['username'])){
				//go to content
				include("homepage.php");
			}
			else{
				//go to welcome
				include("welcome.php");
			}
		?>
		</div>
		
	</body>
</html>