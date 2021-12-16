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
<title>Dairy: On Sale</title>
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
       <li class="active bg-warning"><a href="#">On Sale</a></li>
		<?php }?> 
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

if(isset($_POST['onsale'])){
$sold = 'on sale'; $bot = 'no'; $profit = $_POST['sp'] + $_POST['vl'];
try {    $sql = "INSERT INTO sales (type, b_price, labour, feeding, treatment, production, s_price, profit, bot, cid, fmid)
      VALUES (?,?,?,?,?,?,?,?,?,?,?)";
      $stmt = $conn->prepare($sql);
    $stmt -> bindParam(1, $_POST['type']);
    $stmt -> bindParam(2, $_POST['bp']);
    $stmt -> bindParam(3, $_POST['lb']);
      $stmt -> bindParam(4, $_POST['fd']);
      $stmt -> bindParam(5, $_POST['trt']);
      $stmt -> bindParam(6, $_POST['prod']);
      $stmt -> bindParam(7, $_POST['sp']);
      $stmt -> bindParam(8, $profit);
      $stmt -> bindParam(9, $bot);
      $stmt -> bindParam(10, $_POST['cid']);
      $stmt -> bindParam(11, $_SESSION['uid']);
      $stmt->execute();
      
    $sql = "UPDATE cattle SET sold=? WHERE cid=?";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $sold);
    $stmt -> bindParam(2, $_POST['cid']);
    $stmt->execute();
    
    echo ("<script language='javascript'> window.alert('Cattle successfully put on sale')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../valuation.php'> ";
          ?>
          <script>
          window.location.href = '../valuation.php';
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

<div class="panel panel-primary mydiv">
    <div class="panel-heading">Put Cattle On Sale</div>
    <div class="panel-body">
 <form action="onsale.php" class="form-group" method="post">

 <input type="hidden" name="type" value="<?php echo $_GET['tp'];?>">
 <input type="hidden" name="bp" value="<?php echo $_GET['bp'];?>">
 <input type="hidden" name="lb" value="<?php echo $_GET['lb'];?>">
 <input type="hidden" name="fd" value="<?php echo $_GET['fd'];?>">
 <input type="hidden" name="trt" value="<?php echo $_GET['trt'];?>">
 <input type="hidden" name="prod" value="<?php echo $_GET['prod'];?>">
 <input type="hidden" name="vl" value="<?php echo $_GET['vl'];?>">
 <input type="hidden" name="cid" value="<?php echo $_GET['id'];?>">

<p>
<label>Selling Price (KShs)</label><br/>
<?php $str = ''; $val = $_GET['vl'];
if($val < 0){$str = 'The cattle has more expenses than its production, the selling price should not be less than KSh. '.($val*-1);}
else if($val == 0){$str = 'The cattle has equal expenses and production, any price you set for it will be a profit';}
else{$str = 'The cattle has made a profit of KSh. '.$val.'. Any price you set for it will be additional profits.';}
  ?>
Suggestion: <em><?php echo $str; ?></em><br/>
<input type="text" name="sp" value="" class="form-control add-todo" placeholder="Intended selling price"  required />
</p>

<p>
<input type="submit" name="onsale" class="btn btn-primary" style="float: right;" value="Put on Sale" id="submit1">
</p>	

</form>

    </div>
</div>
<?php }} ?>

<?php include("../includes/footer.php"); ?>

 <?php include("../includes/signlogin.php"); ?>


</body>
</html>
