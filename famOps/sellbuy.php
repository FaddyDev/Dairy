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
<title>Dairy: Buy</title>
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
       
       <?php if(isset($_SESSION["is_logged"])){?>
       <li class="active bg-warning"><a href="#">Buy Cattle</a></li>
		<?php }?> 
       <li><a href="valuation.php">Valuation</a></li>  
    <li><a href="sales.php">Sales</a></li>   
    <li><a href="diseases.php">Diseases</a></li>
    <li><a href="practices.php">Practices</a></li>
      <!--  <li><a href="#">Reports</a></li>
		 <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 4
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Page 4-1</a></li>
          <li><a href="#">Page 4-2</a></li>
          <li><a href="#">Page 4-3</a></li>
        </ul>
		<li><a href="#">Contact Us</a></li>
      </li> -->
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

if(isset($_POST['sb'])){
$sold = 'yes'; $newsold = 'no'; $bot = 'yes';
try {     $sql = "INSERT INTO cattle (type, tag, breed, age, b_price, fmid, sold)
    VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_POST['type']);
	$stmt -> bindParam(2, $_POST['tag']);
	$stmt -> bindParam(3, $_POST['breed']);
    $stmt -> bindParam(4, $_POST['age']);
    $stmt -> bindParam(5, $_POST['bp']);
    $stmt -> bindParam(6, $_SESSION['uid']);
    $stmt -> bindParam(7, $newsold);
    $stmt->execute();
      
    $sql = "UPDATE sales SET bot=? WHERE sid=?";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $bot);
    $stmt -> bindParam(2, $_POST['sid']);
    $stmt->execute();

     $sql = "UPDATE cattle SET sold=? WHERE cid=?";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $sold);
    $stmt -> bindParam(2, $_POST['cid']);
    $stmt->execute();
    
    echo ("<script language='javascript'> window.alert('Cattle Purchased Successfully')</script>");
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


if(isset($_GET['cid'])){
 ?>

<div class="panel panel-primary mydiv">
    <div class="panel-heading">Buy Cattle</div>
    <div class="panel-body">
 <form action="sellbuy.php" class="form-group" method="post">
     
 <input type="hidden" name="breed" value="<?php echo $_GET['brd'];?>">
 <input type="hidden" name="age" value="<?php echo $_GET['age'];?>">
 <input type="hidden" name="bp" value="<?php echo $_GET['price'];?>">
 <input type="hidden" name="type" value="<?php echo $_GET['type'];?>">
 <input type="hidden" name="sid" value="<?php echo $_GET['sid'];?>">
 <input type="hidden" name="cid" value="<?php echo $_GET['cid'];?>">

 <p>
 <input type="text" name="tag" class="form-control add-todo" placeholder="Enter the tag identification of the animal"  required />
 </p>

<p>
<input type="submit" name="sb" class="btn btn-primary" style="float: right;" value="Finalize Buying" id="submit1">
</p>	

</form>

    </div>
</div>
<?php }} ?>

<?php include("../includes/footer.php"); ?>

 <?php include("../includes/signlogin.php"); ?>


</body>
</html>
