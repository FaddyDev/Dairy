<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>

<?php include("../includes/dbconn.php"); //DB

if(isset($_POST['prac'])){
   try {    $sql = "INSERT INTO practices (practice, age, frequency)
    VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_POST['practice']);
	$stmt -> bindParam(2, $_POST['age']);
	$stmt -> bindParam(3, $_POST['frequency']);
    $stmt->execute();
    
    echo ("<script language='javascript'> window.alert('Routine Practice Added Successfully')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../practices.php'> ";
          ?>
          <script>
          window.location.href = '../practices.php';
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
    <div class="panel-heading">Add Routine Practice</div>
    <div class="panel-body">
 <form action="hoOps/addpractice.php" class="form-group" method="post">

<p>
<select name="practice" class="form-control add-todo" required>
<option value="">Select Routine Practice</option>
<option value="Dehorning">Dehorning</option>
<option value="Vaccination">Vaccination</option>
<option value="Deworming">Deworming</option>
<option value="Hoof Trimming">Hoof Trimming</option>
<option value="Docking/Tailing">Docking/Tailing</option>
<option value="Dipping and Spraying">Dipping and Spraying</option>
<option value="Dusting">Dusting</option>
</select>
</p> 

<p>
<input type="text" name="age" class="form-control add-todo" placeholder="Age in months, use 'all' for all ages"  required />
</p>

<p>
<input type="text" name="frequency" class="form-control add-todo" placeholder="Frequency e.g. twice a year"  required />
</p>

<p>
<input type="reset" class="btn btn-info" value="Clear All">
<input type="submit" name="prac" class="btn btn-info" style="float: right;" value="Add" id="submit1">
</p>	

</form>

    </div>
</div>
<?php } ?>