<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>
<?php include("includes/dbconn.php"); //Create db first ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dairy: Home</title>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">

 <link href="myassets/mystyles.css" type="text/css" rel="stylesheet" />

 <link href="bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" />
   <link href="bootstrap/css/bootstrap-theme.css" type="text/css" rel="stylesheet" />
  <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.js"> </script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript" src="myassets/myscripts.js"></script>
</head>

<body>
 <nav class="navbar ppanel-primary navbar-default navbar-fixed-top">
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
        <li class="active bg-warning"> <a href="index.php">Home</a></li>

    <?php if(isset($_SESSION["is_logged"])){?>
       <?php if(isset($_SESSION["is_logged"])){?>
           <?php if($_SESSION["usertype"] == "fam"){ ?>
        <li><a href="farmer.php">Dashboard</a></li>
        <?php } else{?>
        <li><a href="ho.php">Dashboard</a></li>
        <?php } }?>

    <li><a href="cattle.php">Cattle</a></li>
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
      
      <?php } ?>

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


<div class="panel panel-primary"><!--Main Panel -->
<?php include("includes/head.php"); //Heading ?>


<div class="panel panel-body">
     <p class="border-top-0 border-danger bg-primary">
       <img src="images/cow1.jpg" clas="img-rounded" />
       <img src="images/cow2.jpg" clas="img-rounded" />
       <img src="images/cow3.jpg" clas="img-rounded" />
       <img src="images/cow1.jpg" clas="img-rounded" />
       <!--<img src="images/cow2.jpg" clas="img-rounded" width="80%;" />-->
      </p>
  <p class="border-top-0 border-danger bg-primary">
       <img src="images/goat1.jpg" clas="img-rounded" />
       <img src="images/goat2.jpg" clas="img-rounded" />
       <img src="images/goat3.jpg" clas="img-rounded" />
       <img src="images/goat4.jpg" clas="img-rounded" />
       <!--<img src="images/goat1.jpg" clas="img-rounded" width="80%;" />-->
      </p>
      </div>

     
</div>

 <?php include("includes/footer.php"); ?>

 <?php include("includes/signlogin.php"); ?>


</body>
</html>
