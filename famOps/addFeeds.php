<?php if(session_status()==PHP_SESSION_NONE){
session_start();} ?>

<?php include("../includes/dbconn.php"); //DB

if(isset($_POST['feed'])){

   try {   
    $total = 0; $pc = 0; $sql = '';
    
    if($_POST['cattle'] == 'Cows'){$sql = "SELECT * FROM cattle WHERE type='Cow' AND sold!='yes' AND fmid=? ";}
    if($_POST['cattle'] == 'Goats'){$sql = "SELECT * FROM cattle WHERE type='Goat' AND sold!='yes' AND fmid=?  ";}
    if($_POST['cattle'] == 'All'){$sql = "SELECT * FROM cattle WHERE sold!='yes' AND fmid=?  ";}
    $stmt = $conn->prepare($sql);
	if($stmt->execute(array($_SESSION['uid'])))
	{
	   $total = $stmt->rowCount();
    }
    $pc = round(($_POST['cost'] / $total), 2); //Expense per cattle
       
    $sql = "INSERT INTO feeds (type, cattle, total, quantity, cost, per_cattle, fmid)
    VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_POST['type']);
    $stmt -> bindParam(2, $_POST['cattle']);
    $stmt -> bindParam(3, $total);
	$stmt -> bindParam(4, $_POST['quantity']);
    $stmt -> bindParam(5, $_POST['cost']);
    $stmt -> bindParam(6, $pc);
    $stmt -> bindParam(7, $_SESSION['uid'] );
    $stmt->execute();
    
    echo ("<script language='javascript'> window.alert('Feed recorded Successfully')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../feeds.php'> ";
          ?>
          <script>
          window.location.href = '../feeds.php';
          </script>
          <?php 
    }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
    }
$stmt = null;
}else{
 ?>
<div class="panel panel-default">
    <div class="panel-heading">Record Feeding Expenses</div>
    <div class="panel-body">
 <form action="famOps/addFeeds.php" class="form-group" method="post">

<p>
<input type="radio" name="cattle" value="Cows" required>Cows
<input type="radio" name="cattle" value="Goats"required>Goats
<input type="radio" name="cattle" value="All"required>All
</p> 

<p>
<input type="radio" name="type" value="Fodder" required>Fodder
<input type="radio" name="type" value="Supplements"required>Supplements
</p>

<p>
<input type="text" name="quantity" class="form-control add-todo" onKeyPress="return numbersonly(event)" placeholder="Quantity of the feed (in bales or kgs)"  required />
</p>

<p>
<input type="text" name="cost" class="form-control add-todo" onKeyPress="return numbersonly(event)" placeholder="Total cost of the feeds in KShs" />
</p>

<p>
<input type="reset" class="btn btn-default" value="Clear All">
<input type="submit" name="feed" class="btn btn-default" style="float: right;" value="Record" id="submit1">
</p>	

</form>

    </div>
</div>
<?php } ?>