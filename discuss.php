
<?php
	if (!isset($_SESSION))
	{
		session_start();
	}
	$servername = "localhost";
	$username = "root";
	$password = "125275";
	$database="mydb";
	$tablename="chats";
	$conn = mysqli_connect($servername, $username, $password, $database);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$sql="create table if not exists $tablename(did varchar(500),topic varchar(500),username varchar(30))";
	if (mysqli_query($conn, $sql)) {
		//table created successfully
	} 
	else {
		echo "Error creating table: " . mysqli_error($conn);
	}
	
	
	if(isset($_GET["v"])&&$_GET["v"]==1){
		session_destroy();
		header('Location: index.php');
	}
?>
<div id="discuss_header">
	<?php
	
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			$_SESSION['did']=$did;
			$sql="select * from discussions where did=\"$did\"";
			$result=mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)==0){
				echo "<script>alert('invalid attempt to login !!!');location=\"homepage.php\"</script>";
			}
			else{
				$sql="select topic from discussions where did=\"$did\"";
				$retval = mysqli_query( $conn,$sql );
   
				if(! $retval ) {
					die('Could not get data: ' . mysqli_error($conn));
				}
				while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
					
					$topic=$row['topic'];
					echo "<h1><center>$topic</center></h1>";	

				}
			}
		}
		else if(isset($_SESSION['did'])){
			echo "<script>history.go(-1);</script>";
			$did=$_SESSION['did'];
			//$_SESSION['did']=$did;
			$sql="select * from discussions where did=\"$did\"";
			$result=mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)==0){
				echo "<script>alert('invalid attempt !!!');location=\"homepage.php\"</script>";
			}
			else{
				$sql="select topic from discussions where did=\"$did\"";
				$retval = mysqli_query( $conn,$sql );
   
				if(! $retval ) {
					die('Could not get data: ' . mysqli_error($conn));
				}
				while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
					
					$topic=$row['topic'];
					echo "<h1><center>$topic</center></h1>";	

				}
			}
		}
		$username=$_SESSION['username'];
		echo "<b style=\"float:right;margin-right:20px\">$username</b>"."<br>";
		echo "<a style=\"float:right;margin-right:20px\" href='discuss.php?v=1'>logout</a>";
	?>
</div>

<div id="home_content">
	<div id="ecran" style="background-color:yellow;width:100%;height:450px;overflow-y: scroll;"> 
		<?php
			
			$did=$_SESSION['did'];
			$sql = "select did, topic,username from $tablename where did=\"$did\"";
			$retval = mysqli_query( $conn,$sql );
   
			if(! $retval ) {
				die('Could not get data: ' . mysqli_error($conn));
			}
			
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
				//$did=$row['did'];
				$comment=$row['topic'];
				$user=$row['username'];
				echo "<b style=\"\">$user</b><br>$comment<br><hr>";	
				
			}
		?>
		
	</div>
	<script type='text/javascript'>
		var box = document.getElementById('ecran');
		box.scrollTop = box.scrollHeight;
	</script>
	
	<br>
	<div style="background-color:white;width:100%"> 
		
		<?php
			
			echo "<form action='discuss.php' method='POST' autocomplete='off'>
			<input type='text' placeholder='write something here...' required='required' name='chat' size='150'>
			<input type='submit' value='post'>
			</form>";
			if(isset($_POST['chat'])){
				$comment=$_POST['chat'];
				$username=$_SESSION['username'];
				$sql = "insert into $tablename values(\"$did\",\"$comment\",\"$username\")";
				if(mysqli_query($conn,$sql)){
					//inserted successfully
				}
				else{
					echo "error inserting data into the table: ".mysqli_error($conn);
				}
				header('Location: discuss.php');
			}
				
		
		?>
	</div>
	
</div>
