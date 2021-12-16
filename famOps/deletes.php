<?php
if(isset($_GET['del'])){
    include("../includes/dbconn.php"); //DB

if($_GET['del'] == 'cat'){ //for deleting cattle
try { 
   $sql = "DELETE FROM cattle WHERE cid=?";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_GET['id']);
    $stmt->execute();
	
	echo ("<script language='javascript'> window.alert('Cattle Record Deleted Successfully')</script>");
//echo "<meta http-equiv='refresh' content='0;url=../cattle.php'> ";
          ?>
          <script>
          window.location.href = '../cattle.php';
          </script>
          <?php 
	
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
$conn = null;
 }//end of cattle

 if($_GET['del'] == 'emp'){ //for deleting employees
try { 
   $sql = "DELETE FROM employees WHERE eid=?";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_GET['id']);
    $stmt->execute();
	
	echo ("<script language='javascript'> window.alert('Employee Record Deleted Successfully')</script>");
//echo "<meta http-equiv='refresh' content='0;url=../employees.php'> ";
          ?>
          <script>
          window.location.href = '../employees.php';
          </script>
          <?php 
	
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
$conn = null;
 }//end of employee

 if($_GET['del'] == 'prod'){ //for deleting production
try { 
   $sql = "DELETE FROM production WHERE pid=?";
    $stmt = $conn->prepare($sql);
	$stmt -> bindParam(1, $_GET['id']);
    $stmt->execute();
	
	echo ("<script language='javascript'> window.alert('Production Record Deleted Successfully')</script>");
//echo "<meta http-equiv='refresh' content='0;url=../production.php'> ";
          ?>
          <script>
          window.location.href = '../production.php';
          </script>
          <?php 
	
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
$conn = null;
 }//end of production

 if($_GET['del'] == 'feed'){ //for deleting feeds
    try { 
       $sql = "DELETE FROM feeds WHERE fid=?";
        $stmt = $conn->prepare($sql);
        $stmt -> bindParam(1, $_GET['id']);
        $stmt->execute();
        
        echo ("<script language='javascript'> window.alert('Feeds Record Deleted Successfully')</script>");
    //echo "<meta http-equiv='refresh' content='0;url=../feeds.php'> ";
          ?>
          <script>
          window.location.href = '../feeds.php';
          </script>
          <?php 
        
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }
    $conn = null;
     }//end of feeds
     
 if($_GET['del'] == 'treat'){ //for deleting treatment
    try { 
       $sql = "DELETE FROM treatment WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt -> bindParam(1, $_GET['id']);
        $stmt->execute();
        
        echo ("<script language='javascript'> window.alert('Treatment Record Deleted Successfully')</script>");
    //echo "<meta http-equiv='refresh' content='0;url=../treatment.php'> ";
          ?>
          <script>
          window.location.href = '../treatment.php';
          </script>
          <?php 
        
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }
    $conn = null;
     }//end of treatment

 } //end of isset del ?>