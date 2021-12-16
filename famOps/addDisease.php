<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>

<?php include("../includes/dbconn.php"); //DB
if(isset($_POST['dis'])){
 $dis = $trt = $ctrl = $adm = 'N/A'; $price = 0;
   try {    $sql = "INSERT INTO diseases (signs, disease, control, treatment, administration, price, fmid)
    VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_POST['signs']);
	$stmt -> bindParam(2, $dis);
	$stmt -> bindParam(3, $ctrl);
    $stmt -> bindParam(4, $trt);
    $stmt -> bindParam(5, $adm);
    $stmt -> bindParam(6, $price);
    $stmt -> bindParam(7, $_SESSION['uid']);
    $stmt->execute();
    
    echo ("<script language='javascript'> window.alert('Disease Signs Recorded Successfully. Check later for feedback from the veterinary officer')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../diseases.php'> ";
          ?>
          <script>
          window.location.href = '../diseases.php';
          </script>
          <?php 
    }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
    }
$stmt = null;
}else{
 ?>

<div class="panel panel-primary">
    <div class="panel-heading">Record Disease Signs</div>
    <div class="panel-body">
 <form action="famOps/addDisease.php" class="form-group" method="post">

<p>
<textarea name="signs" id="" cols="80" rows="10" placeholder="E.g. coughing, red eyes, swollen limbs..." required></textarea>
</p>

<p>
<input type="submit" name="dis" class="btn btn-info" style="float: right;" value="Submit" id="submit1">
</p>	

</form>

    </div>
</div>
<?php } ?>