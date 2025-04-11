<?php




    
    include("../include/connection.php");

    $id = $_POST['id'];

    $query = "UPDATE doctor SET status ='REJECTED' WHERE DoctorID = '$id'";

    mysqli_query($connect, $query);

     // Step 2: Reassign IDs sequentially
     $query1 = "SET @count = 0";
     mysqli_query($connect, $query1);
 
     $query2 = "UPDATE doctor SET DoctorID = (@count:=@count + 1)";
     mysqli_query($connect, $query2);
 
     echo "Doctor Rejected and IDs Reset!";

?>

