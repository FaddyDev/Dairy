<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>

<?php include("../includes/dbconn.php"); //DB
$farmerData = array();
try { 
  $sql = "SELECT * FROM farmers TRY WHERE fmid = '".$_SESSION['uid']."' ";
    $stmt = $conn->prepare($sql);
	if($stmt->execute())
	{
	 while($row = $stmt -> fetch())
	 {
	   $farmerData[] = $row;
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
       <?php foreach ($farmerData as $fam){?>
		  <p>Name: <i><?php echo $fam['Name'];?></i></p>
		  <p>ID: <i><?php echo $fam['ID'];?></i></p>
		  <p>Phone: <i><?php echo $fam['phone'];?></i></p>
		  <?php }?>
		<a href="famOps/editprof.php" class="btn btn-xs btn-primary">Edit Profile</a>
    </div>
</div>