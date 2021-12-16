<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>
<?php include("includes/dbconn.php"); //Create db first ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dairy: Helath Officer Home</title>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">

 <link href="myassets/mystyles.css" type="text/css" rel="stylesheet" />

 <link href="bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" />
   <link href="bootstrap/css/bootstrap-theme.css" type="text/css" rel="stylesheet" />
  <script src="bootstrap/js/jquery-3.2.1.js"> </script>
  <script src="bootstrap/js/bootstrap.js"></script>
  <script src="myassets/myscripts.js"></script>
</head>

<body>
<?php if(isset($_SESSION["is_logged"])){
  if($_SESSION['usertype'] == "ho"){?>
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
        <li><a href="index.php">Home</a></li>
       <?php if(isset($_SESSION["is_logged"])){?>
       <li class="active bg-warning"><a href="ho.php">Dashboard</a></li>
        <li><a href="cattle.php">Cattle</a></li>
		<?php }?>
    <li><a href="employees.php">Employees</a></li>
    <li><a href="feeds.php">Feeds</a></li>
    <li><a href="treatment.php">Treatment</a></li>
        <li><a href="production.php">Production</a></li>
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
		<li><a href="includes/signlogin.php?out"> <span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
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
 <div class="panel panel-heading panel-primary head">Health Officer's Dashboard</div>
      <div class="panel-body panel-primary">
       <!-- Ops div -->
       <div class="col-md-2 panel panel-warning" style="left:0; margin-left:0;">
              <p> <a class="btn btn-primary btn-sm btn-block" href="javascript: loadProfXMLDoc();">Profile</a></p>
              <p> <a class="btn btn-info btn-sm btn-block" href="javascript: loadPracticeXMLDoc();">Add Routine Practice</a></p>
              <p> <a class="btn btn-default btn-sm btn-block" href="diseases.php">Diseases</a></p>
          </div>
          <!-- End of ops div -->

          <!--target div -->
         <div class="col-md-10 panel panel-warning" id="target">
          <h5>Welcome <?php echo $_SESSION['username'];?></h5>
          <img src="images/vet.jpg" class="img-thumbnail" />
           </div>
         <!--end of target div -->
	  
	  </div> <!--End of panel body -->
     
</div> <!-- End of farmer's panel -->

 <?php include("includes/footer.php"); ?>

 <?php include("includes/signlogin.php"); ?>

<script type="text/javascript">
//Profile
  function loadProfXMLDoc(){
    var xmlhttp;
    if(window.XMLHttpRequest){
      //for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else{
      //for IE6 n 5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
xmlhttp.onreadystatechange=function(){
  if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
    document.getElementById("target").innerHTML = xmlhttp.responseText;
  }
}
xmlhttp.open("POST","hoOps/profile.php",true);
xmlhttp.send();
  }

  //Add Routine Practice
  function loadPracticeXMLDoc(){
    var xmlhttp;
    if(window.XMLHttpRequest){
      //for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else{
      //for IE6 n 5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
xmlhttp.onreadystatechange=function(){
  if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
    document.getElementById("target").innerHTML = xmlhttp.responseText;
  }
}
xmlhttp.open("POST","hoOps/addpractice.php",true);
xmlhttp.send();
  }

</script>
	  </div>
     
</div>

 <?php include("includes/footer.php"); ?>

 <?php include("includes/signlogin.php"); ?>


 <?php } else{
  echo ("<script language='javascript'> window.alert('This page is only visible to veterinary officers')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=farmer.php'> ";
          ?>
          <script>
          window.location.href = 'farmer.php';
          </script>
          <?php }
    } else{
      echo ("<script language='javascript'> window.alert('You must be logged in to view this page')</script>");
          //echo "<meta http-equiv='refresh' content='0;url=index.php'> ";
          ?>
          <script>
          window.location.href = 'index.php';
          </script>
          <?php } ?>
</body>
</html>
