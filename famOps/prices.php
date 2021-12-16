<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>

<?php include("../includes/dbconn.php"); //DB

if(isset($_POST['reg'])){
   try {    
    $dt = date('d/m/Y');
     $sql = "INSERT INTO prices (product, fromDate, price, fmid)
    VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_POST['prod']);
	$stmt -> bindParam(2, $dt);
    $stmt -> bindParam(3, $_POST['price']);
    $stmt -> bindParam(4, $_SESSION['uid']);
    $stmt->execute();
    
    echo ("<script language='javascript'> window.alert('Latest Price Set Successfully. Click OK then Prices to view')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../farmer.php'> ";
          ?>
          <script>
          window.location.href = '../farmer.php';
          </script>
          <?php 
    }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
    }
    $stmt = null;
}else{

//View Form
    $milk = array(); 
try { 

  $sql = "SELECT * FROM prices WHERE product = 'Milk' AND id = (SELECT MAX(id) FROM prices WHERE product = 'Milk') AND fmid=? ";
    $stmt = $conn->prepare($sql);
	if($stmt->execute(array($_SESSION['uid'])))
	{
	 while($row = $stmt -> fetch())
	 {
	   $milk[] = $row;
	 }
	} 

    $manure = array();
    $sql2 = "SELECT * FROM prices WHERE product = 'Manure' AND id = (SELECT MAX(id) FROM prices WHERE product = 'Manure') AND fmid=? ";
    $stmt2 = $conn->prepare($sql2);
	if($stmt2->execute(array($_SESSION['uid'])))
	{
	 while($row = $stmt2 -> fetch())
	 {
	   $manure[] = $row;
	 }
	}
  }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
   }
   $stmt2 = null;
 ?>

<div class="panel panel-success">
    <div class="panel-heading">Prices</div>
    <div class="panel-body">

<p class="well well-sm">
<label for="current">Current Prices</label></br>
 <?php if($milk){foreach ($milk as $mlk){?>  
<em>Milk Price per litre as from <?php echo $mlk['fromDate'];?></em></br>
<label for="milkk"><?php echo "KShs. ".$mlk['price'];?></label></br>
 <?php }}?>
<?php if($manure){foreach ($manure as $man){?>  
<em>Price of manure per wheelbarrow as from <?php echo $man['fromDate'];?></em></br>
<label for="manuree"><?php echo "KShs. ".$man['price'];?></label>
<?php }}?>         
</p></br></br></br>

<label for="latest">Set Latest Prices</label>
 <form action="famOps/prices.php" class="form-group" method="post">
<p>
<input type="radio" name="prod" value="Milk" required>Milk
<input type="radio" name="prod" value="Manure"required>Manure
</p> 

<p>
<input type="text" name="price" onKeyPress="return numbersonly(event)" class="form-control add-todo" placeholder="Enter the latest price in (KShs)"  required />
</p>

<p>
<input type="submit" name="reg" class="btn btn-success btn-block" value="Set Price" id="submit1">
</p>	
</form>

    </div>
</div>
<?php } ?>