<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>

<?php include("../includes/dbconn.php"); //DB
$hoData = array();
try { 
  $sql = "SELECT * FROM h_officers TRY WHERE hid = '".$_SESSION['uid']."' ";
    $stmt = $conn->prepare($sql);
	if($stmt->execute())
	{
	 while($row = $stmt -> fetch())
	 {
	   $hoData[] = $row;
	 }
	} 
  }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
   }
	
$stmt = null;
 ?>


<div class="panel panel-primary">
    <div class="panel-heading">My Profile </div>
    <div class="panel-body">
       <?php foreach ($hoData as $ho){?>
		  <p>Name: <i><?php echo $ho['Name'];?></i></p>
		  <p>ID: <i><?php echo $ho['ID'];?></i></p>
		  <p>Phone: <i><?php echo $ho['phone'];?></i></p>
		  <p>Empployee Number: <i><?php echo $ho['emp_no'];?></i></p>
		  <?php }?>
		<a href="hoOps/editprof.php" class="btn btn-xs btn-primary">Edit Profile</a>
    </div>
</div>