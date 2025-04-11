<?php


    include("../include/connection.php");

    $query = "SELECT * FROM doctor WHERE status='PENDING' ORDER BY data_reg ASC";
    $res = mysqli_query($connect, $query);

   
       $output = "
            <div class='table-responsive'>  <!-- ADD THIS -->
                <table class='table table-bordered'>
                    <thead class='thead-dark'>  <!-- Bootstrap styling for better appearance -->
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Phone Number</th>
                            <th>Date Of Birth</th>
                            <th>Country</th>
                            <th>Specialization</th>
                            <th>Medicial Degree</th>
                            <th>Years of Experience</th>
                            <th>Current Hospital</th>
                            <th>Medicial License Number</th>
                            <th>Date Registered</th>
                            <th class='text-center'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
        ";
  

    if (mysqli_num_rows($res) < 1) {
        $output .= "
            <tr>
                <td colspan='14' class='text-center'>No New Job Request Yet....</td> <!-- FIXED: colspan -->
            </tr>
        ";
    } else {
        $counter = 1;
        while ($row = mysqli_fetch_array($res)) {
            $output .= "
                <tr>
                    <td>".$counter."</td>
                    <td>".$row['fullName']."</td>
                    <td>".$row['email']."</td>
                    <td>".$row['gender']."</td>
                    <td>".$row['phone_number']."</td>
                    <td>".$row['date_of_birth']."</td>
                    <td>".$row['country']."</td>
                    <td>".$row['specialization']."</td>
                    <td>".$row['medical_degree']."</td>
                    <td>".$row['Year_of_experience']."</td>
                    <td>".$row['Current_Hospital']."</td>
                    <td>".$row['Medical_License_Number']."</td>
                    <td>".$row['data_reg']."</td>
                    <td>       
                        <div class='d-grid gap-2 d-md-flex justify-content-center'>
                            <button class='btn btn-success btn-sm approve' id='" . $row["DoctorID"] . "'>APPROVE</button>
                            <button class='btn btn-danger btn-sm reject' id='" . $row["DoctorID"] . "'>REJECT</button>
                           
                        </div>
                    </td>
                </tr> <!-- FIXED: Closing tr -->
            ";
            $counter++;
        }
    }

    $output .= "
            </tbody>
        </table>
        </div>
    ";

    echo $output;
?>