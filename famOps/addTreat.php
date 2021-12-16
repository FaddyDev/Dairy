<?php if(session_status()==PHP_SESSION_NONE){
session_start();} 
//error_reporting(0);

if(isset($_POST['treat'])){
 include("../includes/dbconn.php"); //DB

   try { 
       $cid = 0; $charge = 0; $pretotcharges = 0; $totcharges = 0; 
       $cid = $_POST['cid']; $charge = $_POST['charge'];
   
    //Fetch previous total charge
     $cid = $_POST['cid'];
     $sql = "SELECT * FROM treatment WHERE cid =? AND id = (SELECT MAX(id) FROM treatment WHERE cid=?) ";
    $stmt = $conn->prepare($sql);
	if($stmt->execute(array($cid,$cid)))
	{
	 while($row = $stmt -> fetch())
	 {
	   $pretotcharges = $row['tot_charges'];
	 }
	}   

    $totcharges = $pretotcharges + $charge;

    $sql = "INSERT INTO treatment (cid, disease, treat_date, charges, tot_charges, fmid)
    VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $cid);
	$stmt -> bindParam(2, $_POST['disease']);
	$stmt -> bindParam(3, $_POST['tdate']);
	$stmt -> bindParam(4, $charge);
    $stmt -> bindParam(5, $totcharges);
    $stmt -> bindParam(6, $_SESSION['uid'] );
    $stmt->execute();
    
    echo ("<script language='javascript'> window.alert('Treatment Record Saved Successfully')</script>");
      //echo "<meta http-equiv='refresh' content='0;url=../treatment.php'> ";
          ?>
          <script>
          window.location.href = '../treatment.php';
          </script>
          <?php 
    }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
    }
$stmt = null;
}else{

$cattle = array();
try { 

  $sql = "SELECT * FROM cattle WHERE sold!='yes' AND fmid=?";
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
<div id="ModalTreat" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
<div class="panel panel-danger">
    <div class="panel-heading">Record Treatment Expense
    <button type="button" class="close" data-dismiss="modal">&times;</button></div>
    <div class="panel-body">
 <form action="famOps/addTreat.php" class="form-group" method="post"> 
<p>
<select class="form-control add-todo" id="cid" name="cid" required/>
<option value="">Select Cattle BY Tag Name</option>
 <?php foreach ($cattle as $cat){?>
<option value="<?php echo $cat['cid'];?>"><?php echo $cat['type'].":  ".$cat['tag'];?> </option>
		  <?php }?>
</select>
</p>
<p>
<input type="text" name="disease" class="form-control add-todo" placeholder="The name of the disease"  required />
</p>

<p>
<input type="text" name="tdate" onkeydown="return false;" class="form-control add-todo datepicker" placeholder="Select the date of treatment"  required />
</p>

<p>
<input type="text" name="charge" onKeyPress="return numbersonly(event)" class="form-control add-todo" placeholder="Enter the treatment charges (KShs)"  required />
</p>

<p>
<input type="reset"  class="btn btn-warning" value="Clear All">
<input type="submit" name="treat" class="btn btn-warning" style="float: right;" value="Save" id="submit1">
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
<?php } ?>