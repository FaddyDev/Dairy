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
<title>Dairy: Edit Record</title>
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
       <li class="active bg-warning"><a href="#">Edit Production</a></li> 
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

if(isset($_POST['editprod'])){
    if(empty($_POST['cid']) && $_POST['type'] == 'Milk'){
     echo ("<script language='javascript'> window.alert('You have not selected a cow or goat. Kindly redo the editing appropriately')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../production.php'> ";
          ?>
          <script>
          window.location.href = '../production.php';
          </script>
          <?php 
  }else{
 $type = $_POST['type'];
 $cid = $_POST['cid'];
 $prevqnty = $_POST['prevqnty'];
 $preval = $_POST['preval'];
 $pretotval = $_POST['pretotval'];
 //$pdate = date_format(date_create($_POST['pdate']), 'Y-m-d H:i:s');
 $pdate = $_POST['pdate'];
$dt = DateTime::createFromFormat('d/m/Y', $pdate)->format('Y-m-d');

 $price = 0;
          //Manure is for all animals
    if($type == 'Manure'){
        $cid = 0;
    }
try { 
           //Fetch the price as at the selected date
     $sql = "SELECT * FROM prices WHERE product = '".$type."' AND id = (SELECT MAX(id) FROM prices WHERE product = '".$type."' AND reg_date <= '".$dt."' ) AND fmid=? ";
    $stmt = $conn->prepare($sql);
	if($stmt->execute(array($_SESSION['uid'])))
	{
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	   $price = $row['price'];
	 }
     if(!$price){
         $price = $preval / $prevqnty; //If no prices exist for selected date then work out from previous value and qnty;
     }  

     
    $val = $_POST['qnty'] * $price; //New value is current qnty X the price as at selected date
    $change = $val - $preval; //we get the change in the value after the changes
    $totval = $pretotval + $change; //the updated total value is the old total value plus the updated value (since we can't fetch the total before it)
    /*Example
    if prev value was 200 and the total 500; and new value is 300;
    the change is 300-200=100 and new tot value is 500+100=600. works fine with -ve change*/
    $pid = $_POST['pid'];

    $sql = "UPDATE production SET cid=?, type=?, quantity=?, prod_date=?, value=?, tot_value=? WHERE pid=?";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $cid);
	$stmt -> bindParam(2, $type);
	$stmt -> bindParam(3, $_POST['qnty']);
    $stmt -> bindParam(4, $pdate);
	$stmt -> bindParam(5, $val);
	$stmt -> bindParam(6, $totval);
    $stmt -> bindParam(7, $pid);
    $stmt->execute();

    //Now! all other recordings after this selected one used its total value as prevtotval; we therefore have to update their totals
    $sql = "SELECT * FROM `production` WHERE `pid`>? AND `cid`=?";
    $stmt = $conn->prepare($sql);
	if($stmt->execute(array($pid,$cid)))
	{if($stmt->rowCount()>0)
	{
      $data = array();$prevtot = 0; $itspid = 0;  $newtot = 0;
	 while($row = $stmt -> fetch())
	 {
         $data[] = $row;
     }
     foreach($data as $dt){
	   $prevtot = $dt['tot_value']; //the total value
       $itspid = $dt['pid']; //Its pid
       $newtot = $prevtot + $change;
       //we update each record as they loop
    $sql = "UPDATE production SET tot_value=? WHERE pid=?";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $newtot);
	$stmt -> bindParam(2, $itspid);
    $stmt->execute();
    //$stmt = null;
	 }
    }
    }
    
      //If the product is milk, we add the total value for every existing cattle
      if($type == 'Manure'){        
        //We fetch and update the details of all cattle in the production table, (latest total values)
        $cid = 0;
        $sql1 = "SELECT DISTINCT cid FROM production WHERE `cid`!=0";
        $stmt1 = $conn->prepare($sql1);
        if($stmt1->execute())
        {
         while($row = $stmt1 -> fetch())
         {
             $cid = $row['cid'];
     
         $sql = "SELECT * FROM `production` WHERE pid = (SELECT MAX(pid) FROM production WHERE cid=?)";
         $stmt = $conn->prepare($sql);
         if($stmt->execute(array($cid)))
         {if($stmt->rowCount()>0)
         {
           $data = array();$prevtot = 0; $itspid = 0;  $newtot = 0;
          while($row = $stmt -> fetch())
          {
              $data[] = $row;
          }
          foreach($data as $dt){
            $prevtot = $dt['tot_value']; //the total value
            $itspid = $dt['pid']; //Its pid
            $newtot = $prevtot + $change;
            //we update each record as they loop
         $sql = "UPDATE production SET tot_value=? WHERE pid=?";
         $stmt = $conn->prepare($sql);
         $stmt -> bindParam(1, $newtot);
         $stmt -> bindParam(2, $itspid);
         $stmt->execute();
         //$stmt = null;
          }
         }
         }
        }
         }    
     } //only when recording manure production

    //Yaaay! We're done 
    
    echo ("<script language='javascript'> window.alert('Record Updated Successfully')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../production.php'> ";
          ?>
          <script>
          window.location.href = '../production.php';
          </script>
          <?php 
    }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
    }
$stmt = null;
//Not empty
}
}else{


if(isset($_GET['id'])){
 ?>

 <?php include("../includes/dbconn.php"); //DB
 
$cattle = array();
try { 

  $sql = "SELECT * FROM cattle WHERE sold!='yes'";
    $stmt = $conn->prepare($sql);
	if($stmt->execute())
	{
	 while($row = $stmt -> fetch())
	 {
	   $cattle[] = $row;
	 }
	}
$sql = '';
   if($_GET['cid'] == 0){  $sql = "SELECT * FROM production WHERE pid = ?"; }
   else{ $sql = "SELECT pid, tag, production.cid, production.type, quantity, prod_date, value, tot_value FROM production JOIN cattle on production.cid = cattle.cid WHERE pid=? AND sold='no'";} 
    $stmt = $conn->prepare($sql);
	if($stmt->execute(array($_GET['id'])))
	{
	 while($row = $stmt -> fetch())
	 {
	   $prods[] = $row;
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
    <div class="panel-heading">Update Production Details</div>
    <div class="panel-body">
      <?php foreach ($prods as $prod){?>
 <form action="editprod.php" class="form-group" onsubmit="return select1();" method="post">

<p id='type'>
<input type="radio" name="type" <?php if($prod['type'] == 'Milk'){ echo "checked='checked'";} ?> id="mlk" value="Milk" required>Milk
<input type="radio" name="type" <?php if($prod['type'] == 'Manure'){ echo "checked='checked'";} ?> id="mnr" value="Manure"required>Manure
</p> 

<p id="cid">
<label>Select Cattle BY Tag Name (<em>Manure is produced by all animals</em>)</label>
<select class="form-control add-todo" id="ccid" name="cid" />
<option value="<?php echo $prod['cid'];?>"><?php if($prod['cid'] == 0){ echo "All"; } else{ echo $prod['tag'];}?></option>
<!-- <?php //foreach ($cattle as $cat){?>
<option value="<?php //echo $cat['cid'];?>"><?php //echo $cat['type'].":  ".$cat['tag'];?> </option> -->
		  <?php //}?>
</select>
</p>

<p>
<input type="hidden" name="pid" value="<?php echo $prod['pid'];?>">
<label>Select Production Date</label>
<input type="text" name="pdate" value="<?php echo $prod['prod_date'];?>" onkeydown="return false;" class="form-control add-todo datepicker" placeholder="Select the date of production"  required />
</p>

<p>
<label>Quantity (<em>Milk - ltrs; Manure - wheelbarrows</em>)</label>
<input type="hidden" name="prevqnty" value="<?php echo $prod['quantity'];?>">
<input type="hidden" name="preval" value="<?php echo $prod['value'];?>">
<input type="hidden" name="pretotval" value="<?php echo $prod['tot_value'];?>">
<input type="text" name="qnty" value="<?php echo $prod['quantity'];?>" onKeyPress="return numbersonly(event)" class="form-control add-todo" placeholder="Enter the quantity (Milk - litres, Manure - wheelbarrows)"  required />
</p>

<p>
<input type="submit" name="editprod" class="btn btn-primary" style="float: right;" value="Update" id="submit1">
</p>	

</form>
 <?php } ?>

<script type="text/javascript">
$("#mlk").click(function(){
        $("#cid").show("slow");
        });
$("#mnr").click(function(){
        $("#cid").hide("slow");
        });
function select1(){
     var typ = $("input[type='radio'][name='type']:checked").val();
	 var cid = $("#ccid").val();
	 
     if(cid == '' && typ == 'Milk'){
	  alert('You MUST select the cattle whose production you want to record!');
		 return false;
		 }else{
             return true;
         }
}
</script>
    </div>
</div>
<?php }} ?>

<?php include("../includes/footer.php"); ?>

 <?php include("../includes/signlogin.php"); ?>


</body>
</html>
