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
		$pdf->Cell(10,8,"TREATMENT EXPENSES AS AT ".date('d/m/Y H:i')."",0,2,"C");
//set initial y axis position per page
$y_axis_initial = 25;
$row_height = 8;
//print column titles

$pdf->SetY($y_axis_initial);
$pdf->SetFont("","B","12");		
$pdf->Cell(17,8,"Sr.",1,0,"C",FALSE);
$pdf->Cell(34,8,"Type",1,0,"C",FALSE);
$pdf->Cell(34,8,"Disease",1,0,"C",FALSE);
$pdf->Cell(34,8,"Date",1,0,"C");
$pdf->Cell(34,8,"Charges(/=)",1,0,"C",FALSE);
$pdf->Cell(34,8,"Tot. Charges(/=)",1,0,"C",FALSE);

$y_axis = $y_axis_initial + $row_height;

//Select the columns you want to show in your PDF file
$treats = array();
try { 
 
  $sql = "SELECT * FROM treatment JOIN cattle on treatment.cid = cattle.cid WHERE treatment.fmid=? AND cattle.fmid=? AND cattle.sold!='yes' "; 
    $stmt = $conn->prepare($sql);
    if($stmt->execute(array($_SESSION['uid'],$_SESSION['uid'])))
	{
	 while($row = $stmt -> fetch())
	 {
	   $treats[] = $row;
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
foreach($treats as $treat)
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
        $pdf->Cell(17,8,"Sr.",1,0,"C",FALSE);
		$pdf->Cell(34,8,"Type",1,0,"C",FALSE);
		$pdf->Cell(34,8,"Disease",1,0,"C",FALSE);
		$pdf->Cell(34,8,"Date",1,0,"C");
		$pdf->Cell(34,8,"Charges(/=)",1,0,"C",FALSE);
		$pdf->Cell(34,8,"Tot. Charges(/=)",1,0,"C",FALSE);
		
		//Go to next row
		$y_axis = $y_axis + $row_height;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}
    $type = $treat['type'].': '.$treat['tag'];
    $disease = $treat['disease'];
    $treat_date = $treat['treat_date'];
    $charges = $treat['charges'];
    $tot_charges = $treat['tot_charges'];

	$pdf->SetY($y_axis);
	//$pdf->SetX(25);
	$pdf->Cell(17,8,$sr,1,0,'C',1);
	$pdf->Cell(34,8,$type,1,0,'C',1);
	$pdf->Cell(34,8,$disease,1,0,'C',1);
	$pdf->Cell(34,8,$treat_date,1,0,'C',1);
	$pdf->Cell(34,8,$charges,1,0,'C',1);
	$pdf->Cell(34,8,$tot_charges,1,0,'C',1);

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
