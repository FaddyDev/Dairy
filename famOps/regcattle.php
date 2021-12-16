<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>

<?php include("../includes/dbconn.php"); //DB

if(isset($_POST['reg'])){
 $sold = 'no';
   try {    $sql = "INSERT INTO cattle (type, tag, breed, age, b_price, fmid, sold)
    VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_POST['type']);
	$stmt -> bindParam(2, $_POST['tag']);
	$stmt -> bindParam(3, $_POST['breed']);
    $stmt -> bindParam(4, $_POST['age']);
    $stmt -> bindParam(5, $_POST['bprice']);
    $stmt -> bindParam(6, $_SESSION['uid']);
    $stmt -> bindParam(7, $sold);
    $stmt->execute();
    
    echo ("<script language='javascript'> window.alert('Registration Successful')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../cattle.php'> ";
          ?>
          <script>
          window.location.href = '../cattle.php';
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
    <div class="panel-heading">Register Cattle</div>
    <div class="panel-body">
 <form action="famOps/regcattle.php" class="form-group" onsubmit="return checkEmp()" method="post">

<p>
<input type="radio" name="type" value="Cow" required>Cow
<input type="radio" name="type" value="Goat"required>Goat
</p> 

<p>
<input type="text" name="tag" class="form-control add-todo" placeholder="Enter the tag identification of the animal"  required />
</p>

<p>
<input type="text" name="breed" class="form-control add-todo" placeholder="Enter the animal's breed"  required />
</p>

<p>
<input type="text" name="age" class="form-control add-todo" onKeyPress="return numbersonly(event)" placeholder="Enter the animal's age (preferably in months)"  required />
</p>

<p>
<input type="text" name="bprice" class="form-control add-todo" onKeyPress="return numbersonly(event)" placeholder="Enter the buying price in KShs" />
</p>

<p>
<input type="reset" class="btn btn-info" value="Clear All">
<input type="submit" name="reg" class="btn btn-info" style="float: right;" value="Register" id="submit1">
</p>	

</form>

    </div>
</div>
<?php } ?>