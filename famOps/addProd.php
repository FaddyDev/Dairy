<?php if(session_status()==PHP_SESSION_NONE){
session_start();} 
//error_reporting(0);

if(isset($_POST['reg'])){
 include("../includes/dbconn.php"); //DB

 if(empty($_POST['cid']) && $_POST['type'] == 'Milk'){
     echo ("<script language='javascript'> window.alert('You have not selected a cow or goat. Kindly redo the recording appropriately')</script>");
      echo "<meta http-equiv='refresh' content='0;url=../farmer.php'> ";
  }else{
   try { 
       $price = 0; $val = 0; $pretotval = 0; $totval = 0;
       $type = $_POST['type'];
       //Fetch current prices
     $sql = "SELECT * FROM prices WHERE product = '".$type."' AND id = (SELECT MAX(id) FROM prices WHERE product = '".$type."') AND fmid=? ";
    $stmt = $conn->prepare($sql);
	if(null == $stmt->execute(array($_SESSION['uid'])))
	{
   echo ("<script language='javascript'> window.alert('Set current prices before recording production')</script>");
      echo "<meta http-equiv='refresh' content='0;url=../farmer.php'> ";
	 } 
   else{
   $stmt->execute();
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	   $price = $row['price'];
   
    //Fetch previous value
     $cid = $_POST['cid'];
     $sql = "SELECT * FROM production WHERE cid = '".$cid."'";
    $stmt = $conn->prepare($sql);
	if($stmt->execute())
	{
	 while($row = $stmt -> fetch())
	 {
	   $pretotval = $row['tot_value'];
	 }
	}   

    $val = $_POST['qnty'] * $price;
    $totval = $pretotval + $val;

    //Manure is for all animals
    if($type == 'Manure'){
        $cid = 0;
    }

     $sql = "INSERT INTO production (cid, type, quantity, prod_date, value, tot_value, fmid)
    VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $cid);
	$stmt -> bindParam(2, $type);
	$stmt -> bindParam(3, $_POST['qnty']);
    $stmt -> bindParam(4, $_POST['pdate']);
	$stmt -> bindParam(5, $val);
    $stmt -> bindParam(6, $totval);
    $stmt -> bindParam(7, $_SESSION['uid'] );
    $stmt->execute();

    //If the product is milk, we add the total value for every existing cattle
    if($type == 'Manure'){
   //First of all, get the total 3 of cattle present
   $total = 0; $pc = 0;       
   $sql = "SELECT * FROM cattle WHERE sold!='yes' AND fmid=?  ";
   $stmt = $conn->prepare($sql);
   if($stmt->execute(array($_SESSION['uid'])))
   {
      $total = $stmt->rowCount();
   }
   $pc = $val / $total; //Manure production value per cattle
   
   //Next we fetch and update the details of all cattle in the production table, (latest total values)
   $cid = 0;
   $sql1 = "SELECT DISTINCT cid FROM production WHERE `cid`!=0 AND fmid=? ";
   $stmt1 = $conn->prepare($sql1);
   if($stmt1->execute(array($_SESSION['uid'])))
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
       $newtot = $prevtot + $pc;
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

    echo ("<script language='javascript'> window.alert('Product Recorded Successfully')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../production.php'> ";
          ?>
          <script>
          window.location.href = '../production.php';
          </script>
          <?php 
   } //end of ensuring prices are set before proceeding
    }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
    }
$stmt = null;
//Not empty
}
}else{



$cattle = array();
try { 

  $sql = "SELECT * FROM cattle WHERE sold!='yes' AND fmid=? ";
    $stmt = $conn->prepare($sql);
	if($stmt->execute(array($_SESSION['uid'])))
	{
	 while($row = $stmt -> fetch())
	 {
	   $cattle[] = $row;
	 }
	} 
  }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
   }
$stmt = null;	
 ?>
<!-- Modal -->
<div id="ModalProd" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
<div class="panel panel-warning">
    <div class="panel-heading">Enter Production Record
        <button type="button" class="close" data-dismiss="modal">&times;</button></div>
    <div class="panel-body">
 <form action="famOps/addProd.php" class="form-group" method="post" onsubmit="return select1();">

<p id='type'>
<input type="radio" name="type" id="mlk" value="Milk" required>Milk
<input type="radio" name="type" id="mnr" value="Manure"required>Manure
</p> 

<p id="cid">
<select class="form-control add-todo" id="ccid" name="cid" />
<option value="">Select Cattle BY Tag Name</option>
<?php foreach ($cattle as $cat){?>
<option value="<?php echo $cat['cid'];?>"><?php echo $cat['type'].":  ".$cat['tag'];?> </option>
		  <?php }?>
</select>
</p>

<p>
<input type="text" name="pdate" onkeydown="return false;" class="form-control add-todo datepicker" placeholder="Select the date of production"  required />
</p>

<p>
<input type="text" name="qnty" onKeyPress="return numbersonly(event)" class="form-control add-todo" placeholder="Enter the quantity (Milk - litres, Manure - wheelbarrows)"  required />
</p>

<p>
<input type="reset"  class="btn btn-warning" value="Clear All">
<input type="submit" name="reg" class="btn btn-warning" style="float: right;" value="Save" id="submit1">
</p>	

</form>

</div>


</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!--End of modal -->
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
<?php } ?>