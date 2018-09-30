<?php
	if (!isset($_SESSION))
	{
		session_start();
	}
	$servername = "localhost";
	$username = "root";
	$password = "125275";
	$database="mydb";
	$tablename="discussions";
	$conn = mysqli_connect($servername, $username, $password, $database);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$sql="create table if not exists $tablename(did varchar(500),topic varchar(100))";
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
<div id="home_header">
	<?php
		echo "<b style=\"float:right;margin-right:30px\">".$_SESSION['username']."</b><br>";
		echo "<a style=\"float:right;margin-right:30px\" href='homepage.php?v=1'>logout</a>";
	?>
</div>
<div id="home_content">
	<div style="background-color:yellow;float:left;width:70%;height:500px;overflow-y: scroll;padding-left:20px;margin-right:5px;margin-top:30px"> 
		<?php
			$sql = "select did, topic from $tablename";
			$retval = mysqli_query( $conn,$sql );
   
			if(! $retval ) {
				die('Could not get data: ' . mysqli_error($conn));
			}
			$i=1;
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
				$did=$row['did'];
				$topic=$row['topic'];
				echo "$i.  <a href=\"discuss.php?id=$did\">$topic</a><br><br>";	
				$i++;
			}
		?>
		
	</div>
	<div style="background-color:grey;float:left;width:25%;margin-top:30px"> 
		<form action="homepage.php" method="POST">
			<h2><center>create a new discussion</center></h2>
			<center><textarea name="topic" cols="40" rows="10" "></textarea></center><br>
			<input style="float:right;margin-right:30px;margin-bottom:10px" type="submit" value="create">
		</form>
		<?php
			if(isset($_POST['topic']) ){
			$topic=$_POST['topic'];
			$username=$_SESSION['username'];
			$rand = mt_rand(100,999);
			$md5 = md5($topic.'!(&^ 532567_465 ///'.$username);
			$md53 = substr($md5,0,3);
			$md5_remaining = substr($md5,3);
			$md5 = $md53. $rand. $topic. $md5_remaining;
			$did=$md5;
			$sql="insert into $tablename values (\"$did\",\"$topic\")";
			if(mysqli_query($conn,$sql)){
				//inserted successfully
			}
			else{
				echo "error inserting data into the table: ".mysqli_error($conn);
			}
			//header('location:homepage.php');
			//echo $did;
			//now i have to insert this data in discussion table
		}
		
	?>
	</div>
	
</div>