<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>
 <script>
function checkPasswordMatch1() {
    var submt = document.getElementById("submit1");
    var password = $("#pass").val();
    var confirmPassword = $("#pass2").val();
	
	if(confirmPassword == ''){ $("#divCheckPasswordMatch").html("");
		submt.style.display = 'none';}
	else{
    if (password != confirmPassword){
        $("#divCheckPasswordMatch").html("<font color='red'>Passwords do not match!</font>");
		submt.style.display = 'none';}
    else{
        $("#divCheckPasswordMatch").html("Passwords match.");
		submt.style.display = 'block';}
		}
}


function checkPasswordMatch() {
    var submt = document.getElementById("submit1");
    var password = $("#pass").val();
    var confirmPassword = $("#pass2").val();
	
	if(password == ''){ $("#divCheckPasswordMatch").html("");
		submt.style.display = 'none';}
	else{
    if (password != confirmPassword){
        $("#divCheckPasswordMatch").html("<font color='red'>Passwords do not match!</font>");
		submt.style.display = 'none';}
    else{
        $("#divCheckPasswordMatch").html("Passwords match.");
		submt.style.display = 'block';}
		}
}

    function checkEmp() {
    var type = $("input[type='radio'][name='type']:checked").val();//$(".ho").val();
    var empno = $("#empno1").val();
 
	if(type == 'ho' & empno == ''){ 
    alert("Kindly provide your employee number");
    return false;}
	else{
    return true;}
     }
  </script>

  <script type="text/javascript">
    $(document).ready(
  function(){$('#empno').hide();
  });
  </script>
  <script type="text/javascript">
    $(document).ready(
  function(){$('.others').hide();
  });
  </script>
  
  <?php include("dbconn.php"); //Establish connection to db ?>
<?php
//Sign up
if(isset($_POST['sign'])){

$hashed_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

if($_POST['type'] == 'farmer')
{
try {    $sql = "INSERT INTO farmers (Name, ID, phone, username, password)
    VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_POST['uname']);
	$stmt -> bindParam(2, $_POST['idno']);
	$stmt -> bindParam(3, $_POST['phone']);
	$stmt -> bindParam(4, $_POST['username']);
	$stmt -> bindParam(5, $hashed_pass);
    $stmt->execute();
    //header("Location: ../index.php");?>
    <script>
    window.location.href = '../index.php';
    </script>
    <?php
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
}
else{
   try {    $sql = "INSERT INTO h_officers (Name, ID, phone, emp_no, username, password)
    VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_POST['uname']);
	$stmt -> bindParam(2, $_POST['idno']);
	$stmt -> bindParam(3, $_POST['phone']);
  $stmt -> bindParam(4, $_POST['empno']);
	$stmt -> bindParam(5, $_POST['username']);
	$stmt -> bindParam(6, $hashed_pass);
    $stmt->execute();
    //header("Location: ../index.php");?>
    <script>
    window.location.href = '../index.php';
    </script>
    <?php 
    }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
    }
}
}


else if(isset($_POST['login'])){


try {  
    $sql = ""; $u = "";
    if($_POST['type'] == 'farmer'){ $sql = "SELECT * FROM farmers TRY WHERE username = ?"; $u = "fm";}
    else{ $sql = "SELECT * FROM h_officers TRY WHERE username = ?"; $u = "ho";}
     
    $stmt = $conn->prepare($sql);
	if($stmt->execute(array($_POST['username'])))
	{
    if($stmt->rowCount() > 0){
	 while($row = $stmt -> fetch())
	 {
	  if(password_verify($_POST['password'],$row['password']) == 1)
	   {
	    $_SESSION['is_logged'] = true;
		if($u == "fm"){$_SESSION['uid'] = $row['fmid']; $_SESSION['usertype'] = "fam";}
         else{$_SESSION['uid'] = $row['hid']; $_SESSION['usertype'] = "ho";}
        $_SESSION['username'] = $row['username'];

        if($u == "fm"){//header("Location: ../farmer.php");
            ?>
            <script>
            window.location.href = '../farmer.php';
            </script>
            <?php } else{//header("Location: ../ho.php");
            ?>
            <script>
            window.location.href = '../ho.php';
            </script>
            <?php }
	 }
  else{
      echo ("<script language='javascript'> window.alert('Login failed, check password then try again')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../index.php'> ";?>
<script>
window.location.href = '../index.php';
</script>
<?php
      }
     }
    }
    else{
        echo ("<script language='javascript'> window.alert('Login failed, check username and then try again')</script>");
        //echo "<meta http-equiv='refresh' content='0;url=../index.php'> ";?>
<script>
window.location.href = '../index.php';
</script>
<?php
        }	  
	} 
    else{
	echo ("<script language='javascript'> window.alert('Login failed, check username and password then try again')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../index.php'> ";?>
<script>
window.location.href = '../index.php';
</script>
<?php
    }
	
  }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
}

else if(isset($_GET['out'])){
unset($_SESSION['is_logged']);
unset($_SESSION['username']);
unset($_SESSION['uid']);
unset($_SESSION['usertype']);
//header("Location: ../index.php");?>
<script>
window.location.href = '../index.php';
</script>
<?php
}
else{
?>

<!--Sign up modal-->
<!-- Modal -->
<div id="ModalSign" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">User Sign Up</h4>
      </div>
      <div class="modal-body">
	  <form action="includes/signlogin.php" class="form-group" onsubmit="return checkEmp()" method="post">
<p id="type">
User<br/>
<input type="radio" name="type" id="fam" value="farmer" class="type" required>Farmer
<input type="radio" name="type" id="ho" value="ho" class="type" required>Health Officer
</p>
<div class="others">
<br/>Name<br/><input type="text" name="uname" class="form-control add-todo" id="log" placeholder="Enter your name"  required /></br>
ID Number<br/><input type="text" name="idno" class="form-control add-todo" id="log" onKeyPress="return numbersonly(event)" placeholder="Enter your national id or passport number"  required /></br>
Phone Number<br/><input type="text" name="phone" class="form-control add-todo" id="log" onKeyPress="return numbersonly(event)" placeholder="Enter your mobile phone number"  required /></br>

<p id="empno">
Employee Number<br/>
<input type="text" name="empno" class="form-control add-todo" id="empno1" placeholder="Enter your employee number" />
</p>

Username<br/><input type="text" name="username" class="form-control add-todo" id="log" placeholder="Provide a username" title="You'll need this username to sign in" required /></br>
<div class="registrationFormAlert" id="divCheckPasswordMatch"></div>
Password<br/><input type="text" name="password" class="form-control add-todo" id="pass" placeholder="Enter a password" onkeyup="checkPasswordMatch1();" required /></br>
Re-Enter Password<input type="password1" class="form-control add-todo" name="pass2" id="pass2" onkeyup="checkPasswordMatch();" placeholder="Enter Your Password"  required/></br>
<input type="submit" name="sign" class="btn btn-primary" style="float: right;" value="Sign Up" id="submit1">	
</div>

</form>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!--End of sign up modal -->


<!--Login modal-->
<!-- Modal -->
<div id="ModalLogin" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login</h4>
      </div>
      <div class="modal-body">
       <form action="includes/signlogin.php" class="form-group" method="post">
<p>
Select User<br/>
<input type="radio" name="type" id="fam" value="farmer" required>Farmer
<input type="radio" name="type" id="ho" value="ho" required>Health Officer
</p>
<input type="text" name="username" class="form-control add-todo" id="log" placeholder="Enter Your Username"  required /></br>

<div class="" id="failedlogindiv"></div>

<td><input type="password" class="form-control add-todo" name="password" id="log" placeholder="Enter Your Password"  required/></br>
<a href="#">Forgot Password? </a></td>
<input type="submit" name="login" class="btn btn-primary" style="float: right;" value="Log In" id="submit">			
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!--End of Login modal -->

<?php } ?>

<script>
	$("#ho").click(function(){
	
        $("#empno").show("slow");
    });

    $("#fam").click(function(){
	
        $("#empno").hide("slow");
    });
  
  $("#type").click(function(){
	
        $(".others").show("slow");
    });
	
</script>