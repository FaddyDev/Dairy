<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dairy: Edit Details</title>
<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">

 <link href="../myassets/mystyles.css" type="text/css" rel="stylesheet" />

 <link href="../bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" />
   <link href=../"bootstrap/css/bootstrap-theme.css" type="text/css" rel="stylesheet" />
  <script src="../bootstrap/js/jquery-3.2.1.js"> </script>
  <script src="../bootstrap/js/bootstrap.js"></script>
  <script src="../myassets/myscripts.js"></script>

  <link rel="stylesheet" href="../datepicker/css/jquery-ui.css">
  <script src="../datepicker/js/jquery-1.10.2.js"></script>
  <script src="../datepicker/js/jquery-ui.js"></script>

 <script>
  $(function() {
    $( ".datepicker" ).datepicker({dateFormat: "dd/mm/yy",maxDate: new Date()});
  });
  </script>

  <style type="text/css">
/* Large desktops and laptops */
@media (min-width: 1200px) {
.mydiv{
    width:50%; margin:auto;margin-top:0.5%;
}
}

/* Landscape tablets and medium desktops */
@media (min-width: 992px) and (max-width: 1199px) {
.mydiv{
    width:50%; margin:auto;margin-top:0.5%;
}
}

/* Portrait tablets and small desktops */
@media (min-width: 768px) and (max-width: 991px) {
.mydiv{
    width:70%; margin:auto;margin-top:0.5%;
}
}

/* Landscape phones and portrait tablets */
@media (max-width: 767px) {
.mydiv{
    width:90%; margin:auto;margin-top:0.5%;
}
}

/* Portrait phones and smaller */
@media (max-width: 480px) {
.mydiv{
    width:99%; margin:auto;margin-top:0.5%;
}
}
</style>
</head>

<body>
 <nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand bg-info" href="#"><b>Dairy App</b></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="../index.php">Home</a></li>
       <?php if(isset($_SESSION["is_logged"])){?>
       <li><a href="../farmer.php">Dashboard</a></li>
        <li><a href="../cattle.php">Cattle</a></li>
		<?php }?>
    <li><a href="../employees.php">Employees</a></li>    
       <li class="active bg-warning"><a href="#">Edit Profile</a></li>
    <li><a href="../feeds.php">Feeds</a></li>
    <li><a href="../treatment.php">Treatment</a></li>
       <li><a href="../production.php">Production</a></li>  
       <li><a href="valuation.php">Valuation</a></li>  
    <li><a href="sales.php">Sales</a></li>   
    <li><a href="diseases.php">Diseases</a></li>
    <li><a href="practices.php">Practices</a></li>
    <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reports
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li><a href="reports/cattle.php">Cattle</a></li>
      <li><a href="reports/employees.php">Employees</a></li>
      <li><a href="reports/feeds.php">Feeds</a></li>
      <li><a href="reports/treatment.php">Treatment</a></li>
      <li><a href="reports/production.php">Production</a></li>
      <li><a href="reports/valuation.php">Valuation</a></li>
      <li><a href="reports/sales.php">Sales</a></li>
    </ul>
  </li> 
      </ul>
      <ul class="nav navbar-nav navbar-right">
	  <?php if(isset($_SESSION["is_logged"])){?>
	     <li><a href=""><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["username"];?></a></li>
		<li><a href="../includes/signlogin.php?out"> <span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
	  <?php } else{ ?>
        <li><a data-toggle="modal" data-target="#ModalSign"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
		<li><a data-toggle="modal" data-target="#ModalLogin"> <span class="glyphicon glyphicon-log-in"></span> Login</a></li>
		<?php } ?>
      </ul>
    </div>
  </div>
</nav>
<div class="panel panel-warning"> <!--Main Panel -->


<div class="panel panel-primary">
 <div class="panel panel-heading panel-primary head">Farmer's Operation</div>
      <div class="panel-body panel-primary">

<?php include("../includes/dbconn.php"); //DB

if(isset($_POST['editprof'])){
    $ps = '';
    if($_POST['password'] !== NULL ){$ps = password_hash($_POST['password'], PASSWORD_DEFAULT);} else{$ps = $_POST['oldpass'];}

   try {     $sql = "UPDATE h_officers SET Name=?, ID=?, phone=?, username=?, password=?, emp_no=? WHERE hid=?";
  $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_POST['uname']);
	$stmt -> bindParam(2, $_POST['idno']);
	$stmt -> bindParam(3, $_POST['phone']);
  $stmt -> bindParam(4, $_POST['username']);
  $stmt -> bindParam(5, $ps);
  $stmt -> bindParam(6, $_POST['emp_no']);
	$stmt -> bindParam(7, $_POST['uid']);
  $stmt->execute();
    
    echo ("<script language='javascript'> window.alert('Profile Updated Successfully')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../ho.php'> ";
          ?>
          <script>
          window.location.href = '../ho.php';
          </script>
          <?php 
    }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
    }
$stmt = null;
}else{


if(isset($_SESSION['uid'])){
 ?>

 <?php include("../includes/dbconn.php"); //DB
$hos = array();
try { 

  $sql = "SELECT * FROM h_officers WHERE hid=?";
    $stmt = $conn->prepare($sql);
	if($stmt->execute(array($_SESSION['uid'])))
	{
	 while($row = $stmt -> fetch())
	 {
	   $hos[] = $row;
	 }
	} 
  }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
   }
	
$stmt = null;
 ?>

<div class="panel panel-primary mydiv">
    <div class="panel-heading">Update Profile</div>
    <div class="panel-body">
     <?php foreach ($hos as $hs){?>
 <form action="editprof.php" class="form-group" method="post">
 
<p>
<label>Name</label>
<input type="hidden" name="uid" value="<?php echo $_SESSION["uid"];?>">
<input type="text" name="uname" value="<?php echo $hs['Name'];?>" class="form-control add-todo" placeholder="Name"  required />
</p>

<p>
<label>ID Number</label>
<input type="text" name="idno" value="<?php echo $hs['ID'];?>" class="form-control add-todo" onKeyPress="return numbersonly(event)" placeholder="ID Number"  required />
</p>

<p>
<label>Employee Number</label>
<input type="text" name="emp_no" value="<?php echo $hs['emp_no'];?>" class="form-control add-todo" onKeyPress="return numbersonly(event)" placeholder="Employee Number"  required />
</p>

<p>
<label>Phone Number</label>
<input type="text" name="phone" value="<?php echo $hs['phone'];?>" class="form-control add-todo" onKeyPress="return numbersonly(event)" placeholder="Your phone number"  required />
</p>

<p>
<label>Username</label>
<input type="text" name="username" value="<?php echo $hs['username'];?>" class="form-control add-todo" placeholder="Username" />
</p>

<p>
<label>Password</label>
<div class="bg-warning"> There's an existing password, leave the field blank unless you want to change it</div>
<input type="text" name="password" class="form-control add-todo" placeholder="Password: There's an existing password" />
<input type="hidden" name="oldpass" value="<?php echo $hs['password'];?>" class="form-control add-todo" placeholder="Password" />
</p>

<p>
<input type="submit" name="editprof" class="btn btn-primary" style="float: right;" value="Update" id="submit1">
</p>	

</form>
 <?php } ?>

    </div>
</div>
<?php }} ?>

<?php include("../includes/footer.php"); ?>

 <?php include("../includes/signlogin.php"); ?>


</body>
</html>
