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
		$pdf->Cell(10,8,"EMPLOYEES AS AT ".date('d/m/Y H:i')."",0,2,"C");
//set initial y axis position per page
$y_axis_initial = 25;
$row_height = 8;
//print column titles
$pdf->SetY($y_axis_initial);
$pdf->SetFont("","B","12");		
$pdf->Cell(15,8,"Sr.",1,0,"C",FALSE);
$pdf->Cell(30,8,"Name",1,0,"C",FALSE);
$pdf->Cell(29,8,"ID No.",1,0,"C",FALSE);
$pdf->Cell(30,8,"Address",1,0,"C");
$pdf->Cell(30,8,"Phone",1,0,"C",FALSE);
$pdf->Cell(27,8,"Role",1,0,"C",FALSE);
$pdf->Cell(27,8,"Wage(KShs.)",1,0,"C",FALSE);

$y_axis = $y_axis_initial + $row_height;

//Select the columns you want to show in your PDF file
$emps = array();
try { 

  $sql = "SELECT * FROM employees WHERE fmid=?";
    $stmt = $conn->prepare($sql);
  if($stmt->execute(array($_SESSION['uid'] )))
	{
	 while($row = $stmt -> fetch())
	 {
	   $emps[] = $row;
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
foreach($emps as $emp)
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
        $pdf->Cell(15,8,"Sr.",1,0,"C",FALSE);
        $pdf->Cell(30,8,"Name",1,0,"C",FALSE);
        $pdf->Cell(29,8,"ID No.",1,0,"C",FALSE);
        $pdf->Cell(30,8,"Address",1,0,"C");
        $pdf->Cell(30,8,"Phone",1,0,"C",FALSE);
        $pdf->Cell(27,8,"Role",1,0,"C",FALSE);
        $pdf->Cell(27,8,"Wage(KShs.)",1,0,"C",FALSE);
		
		//Go to next row
		$y_axis = $y_axis + $row_height;
		
		//Set $i variable to 0 (first row)
		$i = 0;
    }
    $name = $emp['name'];
    $idno = $emp['idno'];
    $address = $emp['address'];
    $phone = $emp['phone'];
    $role = $emp['role'];
    $wage = $emp['wage'];

	$pdf->SetY($y_axis);
	//$pdf->SetX(25);
	$pdf->Cell(15,8,$sr,1,0,'C',1);
	$pdf->Cell(30,8,$name,1,0,'C',1);
	$pdf->Cell(29,8,$idno,1,0,'C',1);
	$pdf->Cell(30,8,$address,1,0,'C',1);
	$pdf->Cell(30,8,$phone,1,0,'C',1);
	$pdf->Cell(27,8,$role,1,0,'C',1);
	$pdf->Cell(27,8,$wage,1,0,'C',1);

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
