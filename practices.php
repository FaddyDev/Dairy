<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dairy: Practices</title>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">

 <link href="myassets/mystyles.css" type="text/css" rel="stylesheet" />

 <link href="bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" />
   <link href="bootstrap/css/bootstrap-theme.css" type="text/css" rel="stylesheet" />
  <script src="bootstrap/js/jquery-3.2.1.js"> </script>
  <script src="bootstrap/js/bootstrap.js"></script>
  <script src="myassets/myscripts.js"></script>

 <!--DataTable-->
	  <script type="text/javascript">
  $(document).ready(
  function(){$('#practb').DataTable();
  });
  </script>
<script type="text/javascript" src="myassets/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="myassets/dataTables.bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="myassets/dataTables.bootstrap.min.css"/>

</head>

<body>
<?php if(isset($_SESSION["is_logged"])){?>
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
        <li> <a href="index.php">Home</a></li>

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
    <li class="active bg-warning"><a href="practices.php">Practices</a></li>
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


<?php include("includes/dbconn.php"); //DB
$practices = array();
try { 

  $sql = "SELECT DISTINCT practice,age,frequency,pid FROM practices ";
    $stmt = $conn->prepare($sql);
	if($stmt->execute())
	{
	 while($row = $stmt -> fetch())
	 {
	   $practices[] = $row;
	 }
	} 
  }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
   }
	
$stmt = null;
 ?>

<div class="panel panel-primary"><!--Main Panel -->

<div class="panel-heading head">Routine Practices</div>
<div class="panel-body">

 <!-- Dummy div just for formatting --><div class="col-md-2"></div>
    <div class="panel panel-primary table-responsive col-md-8" style="margin:auto;">
      <table   class="table table-striped table-hover table-bordered table-condensed" id="cattletb">
          
		<thead>
      <tr class="text-primary">
		  <th>practice</th>
			<th>Age</th>
      <th>Frequency</th>
      <?php if(isset($_SESSION["is_logged"]) && $_SESSION["usertype"] == 'ho'){?> <th></th> <?php } ?>
          </tr>
		  </thead>

		  <tbody>
		  <?php foreach ($practices as $prac){?>
		  <tr><td><?php echo $prac['practice'];?></td>
		  <td><?php echo $prac['age'];?></td>
		  <td><?php echo $prac['frequency'];?></td>
      <?php if(isset($_SESSION["is_logged"]) && $_SESSION["usertype"] == 'ho'){?>
      <td><a class="btn btn-xs btn-info" href="hoOps/editprac.php?id=<?php echo $prac['pid'];?>">Edit</a></td>
       <?php } ?>
      </tr>
		  <?php }?>
		  </tbody>
        </table>
        </div>
        <!-- Dummy div just for formatting --><div class="col-md-2"></div>
 </div>

 <?php include("includes/footer.php"); ?>

 <?php include("includes/signlogin.php"); ?>

      <?php 
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
