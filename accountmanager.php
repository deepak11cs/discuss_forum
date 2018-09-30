
<?php
	$servername = "localhost";
	$username = "root";
	$password = "125275";
	$database="mydb";
	$tablename="users";
	$conn = mysqli_connect($servername, $username, $password);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$sql="create database if not exists $database";
	if (mysqli_query($conn, $sql)) {
		//Database created successfully
	} 
	else {
		echo "Error creating database: " . mysqli_error($conn);
	}
	mysqli_close($conn);
	$conn = mysqli_connect($servername, $username, $password, $database);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$sql="create table if not exists $tablename(username varchar(30),password varchar(30))";
	if (mysqli_query($conn, $sql)) {
		//table created successfully
	} 
	else {
		echo "Error creating table: " . mysqli_error($conn);
	}
	
	
	$aa=$_SERVER['REQUEST_URI'];
	echo "<center><form action=$aa method='POST'>
	<h2><center style=\"color:white;\">Login required!!!<center></h2><hr>
	<input type='text' name='username' placeholder='unique user name' required='required'><br>
	<input type='password' name='password' placeholder='password' required='required'><br>
	<input type='submit' name='clicked' value='login'>
	<input type='submit' name='clicked' value='signup'>
	</form></center>";
	if(isset($_POST["username"]) && isset($_POST["password"])){
		$username=$_POST["username"];
		$password=$_POST["password"];
		if($_POST["clicked"]=="login"){
			//echo "login clicked";
			$sql = "select username, password from users where username=\"$username\"";
			$retval = mysqli_query( $conn,$sql );
   
			if(! $retval ) {
				die('Could not get data: ' . mysqli_error($conn));
			}
   
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {

				if($password==$row['password'])
					$_SESSION['username']=$row['username'];
				header('Location: index.php');
			}
		}
		else if($_POST["clicked"]=="signup"){
			//echo "signup clicked ";
			$sql="select * from users where username=\"$username\"";
			$result=mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)!=0){
				echo "<script>alert('username already exists');location=\"index.php\"</script>";
			}
			else{
				$_SESSION["username"]=$_POST["username"];
				$sql="insert into users values (\"$username\",\"$password\")";
				if(mysqli_query($conn,$sql)){
					//inserted successfully
				}
				else{
					echo "error inserting data into the table: ".mysqli_error($conn);
				}
				header('Location: index.php');
			}
			
		}
		else{
			echo "error:101";
		}
	}
?>