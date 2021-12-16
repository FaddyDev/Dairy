<?php
if(session_status()==PHP_SESSION_NONE){
    session_start();} 
//Connect to database via another page
include_once("../includes/dbconn.php");
?>

<?php
if(isset($_SESSION["is_logged"])){
//PDF USING MULTIPLE PAGES
require('fpdf/fpdf.php');

//Create new pdf file
$pdf=new FPDF();

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//Add title
		$pdf->SetFont("Times","U","14");
		$pdf->SetX(95);
		$pdf->Cell(10,8,"DAIRY MANAGEMENT APP",0,1,"C");
		$pdf->SetX(95);
		$pdf->Cell(10,8,"CATTLE VALUATION AS AT ".date('d/m/Y H:i')."",0,2,"C");
//set initial y axis position per page
$y_axis_initial = 25;
$row_height = 8;
//print column titles
$pdf->SetY($y_axis_initial);
$pdf->SetFont("","B","12");		
$pdf->Cell(12,8,"Sr.",1,0,"C",FALSE);
$pdf->Cell(25,8,"Cattle",1,0,"C",FALSE);
$pdf->Cell(25,8,"B. Price(/=)",1,0,"C",FALSE);
$pdf->Cell(25,8,"Labour(/=)",1,0,"C");
$pdf->Cell(25,8,"Feeding(/=)",1,0,"C",FALSE);
$pdf->Cell(26,8,"Treatment(/=)",1,0,"C",FALSE);
$pdf->Cell(27,8,"Production(/=)",1,0,"C",FALSE);
$pdf->Cell(23,8,"Value(/=)",1,0,"C",FALSE);

$y_axis = $y_axis_initial + $row_height;

//Select the columns you want to show in your PDF file
$valuation = array(); $tag = ''; $type = ''; $bprice = 0.00; $labour = 0.00; $feed = 0.00; $treats = 0.00; $prod = 0.00; $sold = '';
try { 
  $cid = 0; $tot = 0; $bdate = '';
  $sql1 = "SELECT * FROM cattle WHERE fmid=? AND sold!='yes'";
  $stmt1 = $conn->prepare($sql1);
  if($stmt1->execute(array($_SESSION['uid'] )))
  {
    $tot = $stmt1->rowCount();
   while($row = $stmt1 -> fetch())
   {
       $cid = $row['cid'];
       $tag = $row['tag'];
       $bprice = $row['b_price'];
       $bdate = $row['reg_date'];
       $type = $row['type'];
       $sold = $row['sold'];
      // $dt = DateTime::createFromFormat('d/m/Y', $bdate)->format('Y-m-d');
 //Labour
  $wg = 0;
  $sql = "SELECT SUM(wage) FROM employees WHERE fmid=? "; 
  $stmt = $conn->prepare($sql);
if($stmt->execute(array($_SESSION['uid'])))
{
  if($stmt->rowCount()>0)
	{
 while($row = $stmt -> fetch())
 {
   $wg = $row['SUM(wage)'];
 }
 $labour = round(($wg/$tot),2);
}else{ $labour = 0.00;}
}

 //Feeds 
 $sql = "SELECT SUM(per_cattle) FROM feeds WHERE reg_date >= ? AND fmid=?"; 
 $stmt = $conn->prepare($sql);
if($stmt->execute(array($bdate,$_SESSION['uid'])))
{
 if($stmt->rowCount()>0)
 {
while($row = $stmt -> fetch())
{
  $feed = $row['SUM(per_cattle)'];
  if(!($feed)){ $feed = 0.00;}
}
}else{ $feed = 0.00;}
}

  //Treatment
  $sql = "SELECT tot_charges FROM treatment WHERE cid=? AND id = (SELECT MAX(id) FROM treatment WHERE cid=?) "; 
  $stmt = $conn->prepare($sql);
if($stmt->execute(array($cid,$cid)))
{
  if($stmt->rowCount()>0)
	{
 while($row = $stmt -> fetch())
 {
   $treats= $row['tot_charges'];
 }
}else{ $treats = 0.00;}
}

 //production
 $sql = "SELECT tot_value FROM production WHERE cid=? AND pid = (SELECT MAX(pid) FROM production WHERE cid=?) "; 
 $stmt = $conn->prepare($sql);
if($stmt->execute(array($cid,$cid)))
{
 if($stmt->rowCount()>0)
 {
while($row = $stmt -> fetch())
{
  $prod= $row['tot_value'];
}
}else{ $prod = 0.00;}
}


$valuation[] = array('cid' => $cid, 'type' => $type, 'tag' => $tag, 'bprice' => $bprice, 'labour' => $labour, 'feed' => $feed, 'treats' => $treats, 'prod' => $prod, 'sold' => $sold);
   }
  }
  
  }
catch(PDOException $e)
    {
    echo "<div style='height:auto; width:50%; color:#000000; margin:auto;top:100px; background-color:#cc7a00; border-radius:5px;border-style: solid; border-width:thin;border-color: red;'>".$sql . "<br>" . $e->getMessage()." <br>Go back and retry.</div>";
   }

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 25;

//Set Row Height
$row_height = 8;

$sr = 1; //serial number
foreach($valuation as $val)
{
$pdf->SetFillColor(255,255,255);
$pdf->SetFont("","","11");	
	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
		$pdf->AddPage();        
	   
		//print column titles for the current page
		$pdf->SetY($y_axis_initial);
		//$pdf->SetX(25);
        $pdf->SetFont("","B","12");		
		$pdf->Cell(12,8,"Sr.",1,0,"C",FALSE);
		$pdf->Cell(25,8,"Cattle",1,0,"C",FALSE);
		$pdf->Cell(25,8,"B. Price(/=)",1,0,"C",FALSE);
		$pdf->Cell(25,8,"Labour(/=)",1,0,"C");
		$pdf->Cell(25,8,"Feeding(/=)",1,0,"C",FALSE);
		$pdf->Cell(26,8,"Treatment(/=)",1,0,"C",FALSE);
		$pdf->Cell(27,8,"Production(/=)",1,0,"C",FALSE);
		$pdf->Cell(23,8,"Value(/=)",1,0,"C",FALSE);
		
		//Go to next row
		$y_axis = $y_axis + $row_height;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}
    $value = $val['prod'] - ($val['bprice'] + $val['labour'] + $val['feed'] + $val['treats']);
    $cattle = $val['type'].': '.$val['tag'];
    $bprice = $val['bprice']; 
    $labour = $val['labour'];
    $feed = $val['feed'];
    $treats = $val['treats'];
    $prod = $val['prod'];
	$pdf->SetY($y_axis);
	//$pdf->SetX(25);
	$pdf->Cell(12,8,$sr,1,0,'C',1);
	$pdf->Cell(25,8,$cattle,1,0,'C',1);
	$pdf->Cell(25,8,$bprice,1,0,'C',1);
	$pdf->Cell(25,8,$labour,1,0,'C',1);
	$pdf->Cell(25,8,$feed,1,0,'C',1);
	$pdf->Cell(26,8,$treats,1,0,'C',1);
	$pdf->Cell(27,8,$prod,1,0,'C',1);
	$pdf->Cell(23,8,$value,1,0,'C',1);

	//Go to next row
	$y_axis = $y_axis + $row_height;
    $i = $i + 1;
    
    $sr = $sr + 1; //next serial
}
	
$stmt = null;

//Send file
$pdf->Output();


      } else{
        echo ("<script language='javascript'> window.alert('You must be logged in to view this page')</script>");
            //echo "<meta http-equiv='refresh' content='0;url=index.php'> ";
          ?>
          <script>
          window.location.href = 'index.php';
          </script>
          <?php } 
?>
