<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>

<?php include("../includes/dbconn.php"); //DB

if(isset($_POST['reg'])){

   try {     $sql = "INSERT INTO employees (idno, role, wage, name, address, phone, fmid)
    VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_POST['idno']);
	$stmt -> bindParam(2, $_POST['role']);
	$stmt -> bindParam(3, $_POST['wage']);
    $stmt -> bindParam(4, $_POST['empname']);
	$stmt -> bindParam(5, $_POST['address']);
    $stmt -> bindParam(6, $_POST['phone']);
    $stmt -> bindParam(7, $_SESSION['uid'] );
    $stmt->execute();
    
    echo ("<script language='javascript'> window.alert('Employee added Successfully')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../employees.php'> ";
          ?>
          <script>
          window.location.href = '../employees.php';
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
    <div class="panel-heading">Add Employee</div>
    <div class="panel-body">
 <form action="famOps/addEmp.php" class="form-group" method="post">

<p>
<input type="radio" name="role" value="Grazer" required>Grazer (<em>Mchungi</em>)
<input type="radio" name="role" value="Milker"required>Milker
</p> 

<p>
<input type="text" name="empname" class="form-control add-todo" placeholder="Enter the employee's name"  required />
</p>

<p>
<input type="text" name="address" class="form-control add-todo" placeholder="Enter the employee's physical address"  required />
</p>

<p>
<input type="text" name="phone" class="form-control add-todo" onKeyPress="return numbersonly(event)" placeholder="Enter the employee's phone number"  required />
</p>

<p>
<input type="text" name="idno" class="form-control add-todo" onKeyPress="return numbersonly(event)" placeholder="Enter the employee's ID number"  required />
</p>

<p>
<input type="text" name="wage" class="form-control add-todo" onKeyPress="return numbersonly(event)" placeholder="Enter the wage to be paid in KShs" />
</p>

<p>
<input type="reset" class="btn btn-info" value="Clear All">
<input type="submit" name="reg" class="btn btn-info" style="float: right;" value="Add" id="submit1">
</p>	

</form>

    </div>
</div>
<?php } ?>