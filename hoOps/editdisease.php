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
<title>Dairy: Edit Disease</title>
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
    <li><a href="../feeds.php">Feeds</a></li>
    <li><a href="../treatment.php">Treatment</a></li>
       <li><a href="../production.php">Production</a></li> 
       <li><a href="valuation.php">Valuation</a></li>  
    <li><a href="sales.php">Sales</a></li>   
    <li><a href="diseases.php">Diseases</a></li>
    <li><a href="practices.php">Practices</a></li>
       <?php if(isset($_SESSION["is_logged"])){?>
       <li class="active bg-warning"><a href="#">Edit Disease</a></li>
		<?php }?>
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
 <div class="panel panel-heading panel-primary head">Cattle Disease</div>
      <div class="panel-body panel-primary">

<?php include("../includes/dbconn.php"); //DB

if(isset($_POST['editdis'])){

   try {    $sql = "UPDATE diseases SET signs=?, disease=?, control=?, treatment=?, administration=?, price=? WHERE id=?";
  $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_POST['signs']);
	$stmt -> bindParam(2, $_POST['disname']);
	$stmt -> bindParam(3, $_POST['ctrl']);
  $stmt -> bindParam(4, $_POST['trt']);
	$stmt -> bindParam(5, $_POST['adm']);
	$stmt -> bindParam(6, $_POST['price']);
  $stmt -> bindParam(7, $_POST['id']);
  $stmt->execute();
    
    echo ("<script language='javascript'> window.alert('Record Updated Successfully')</script>");
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


if(isset($_GET['id'])){
 ?>

 <?php include("../includes/dbconn.php"); //DB
$disease = array();
try { 

  $sql = "SELECT * FROM diseases WHERE id=? ";
    $stmt = $conn->prepare($sql);
	if($stmt->execute(array($_GET['id'])))
	{
	 while($row = $stmt -> fetch())
	 {
	   $disease[] = $row;
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
    <div class="panel-heading">Update Disease Details</div>
    <div class="panel-body">
     <?php foreach ($disease as $dis){?>
 <form action="editdisease.php" class="form-group" method="post">
<p>
<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" >
<?php if($_SESSION["usertype"] == 'ho'){ ?><label>Disease Signs</label> <?php }?>
<textarea name="signs" id="" cols="80" rows="10" placeholder="E.g. coughing, red eyes, swollen limbs..." required><?php echo $dis['signs'];?></textarea>
</p>

<p>
<?php if($_SESSION["usertype"] == 'ho'){ ?><label>Disease Name</label> <?php }?>
<input type="hidden" name="id" value="<?php echo $dis['id'];?>">
<input type="<?php if($_SESSION["usertype"] == 'fam'){ echo 'hidden';}else{echo 'text';} ?>" name="disname" value="<?php echo $dis['disease'];?>" class="form-control add-todo" placeholder="The name of the disease"  required />
</p>

<p>
<?php if($_SESSION["usertype"] == 'ho'){ ?><label>Control</label> <?php }?>
<input type="<?php if($_SESSION["usertype"] == 'fam'){ echo 'hidden';}else{echo 'text';} ?>" name="ctrl" value="<?php echo $dis['control'];?>" class="form-control add-todo" placeholder="How to control the disease"  required />
</p>

<p>
<?php if($_SESSION["usertype"] == 'ho'){ ?><label>Treatment</label> <?php }?>
<input type="<?php if($_SESSION["usertype"] == 'fam'){ echo 'hidden';}else{echo 'text';} ?>" name="trt"  value="<?php echo $dis['treatment'];?>" class="form-control add-todo" placeholder="The recommended treatment"  required />
</p>

<p>
<?php if($_SESSION["usertype"] == 'ho'){ ?><label>Administration</label> <?php }?>
<input type="<?php if($_SESSION["usertype"] == 'fam'){ echo 'hidden';}else{echo 'text';} ?>" name="adm"  value="<?php echo $dis['administration'];?>" class="form-control add-todo" placeholder="How the treatment should be administered"  required />
</p>

<p>
<?php if($_SESSION["usertype"] == 'ho'){ ?><label>Cost (KShs)</label> <?php }?>
<input type="<?php if($_SESSION["usertype"] == 'fam'){ echo 'hidden';}else{echo 'text';} ?>" name="price"  value="<?php echo $dis['price'];?>" class="form-control add-todo" onKeyPress="return numbersonly(event)" placeholder="The cost of the treatment in KShs" />
</p>

<p>
<input type="submit" name="editdis" class="btn btn-primary" style="float: right;" value="Update" id="submit1">
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
