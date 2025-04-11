
<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/fontawesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet"/>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
 
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");

    :root {
      --primary-color: #9370db;
      --primary-color-dark: #7a5acd ;
      --primary-color-light: #bcadee;
      --secondary-color: #4e34b6;
      --text-dark: #2c2c2c;
      --text-light: #a99acd;
      --white:rgb(205, 167, 243);
      --max-width: 1200px;
      --box-shadow:.5rem .5rem 0 rgba(22, 160, 133, .2);
      --text-shadow:.4rem .4rem 0 rgba(0, 0, 0, .2);
      --border:.2rem solid var(--primary-color);
    }

    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }

    .section__container {
      max-width: var(--max-width);
      margin: auto;
      padding: 5rem 1rem;
    }

    .section__header {
      margin-bottom: 0.5rem;
      font-size: 2rem;
      font-weight: 600;
      color: var(--text-dark);
    }

    .container{
      display: flex;
      gap: 3em;
      align-items: center;
      justify-content: space-between;
      padding: 1rem 1rem;
      margin: 0;
    }

    html,
    body {
      scroll-behavior: smooth;
    }

    body {
      font-family: "Poppins", sans-serif;
       
    }

    header {
      background-image: linear-gradient(
          to right,
          rgba(230, 230, 250, 0.9),
          rgba(230, 230, 250, 0.7)
        ),
        url("./css/header.jpg");
      background-position: center center;
      background-size: cover;
      background-repeat: no-repeat;

      z-index: 10;
      border-bottom: 2px solid #f1f1f1;
      width: 100%; 
      position: fixed;     
    }
      
    .link{
      width: 100px;
      background: linear-gradient(0)!important;
       background-color: transparent!important;
    }
    .link a {
      background: linear-gradient(0)!important;
      background-color: transparent!important;
      color: var(--primary-color-light);
    }

    .link a:hover {
      color: white!important;
    }



    .nav__logo {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--white);
    }

    .nav__logo span {
      color: var(--secondary-color);
    }

    .nav__links {
      list-style: none;
      display: flex;
      align-items: center;
      gap: 2rem;
      
    }

    .menu{
      margin-right: 10px;
    }

    .menu:hover{
      cursor: pointer;
    }

    /* Hide Menu Button on Large Screens */
    .menu__toggle .menu-2 {
      display: none;
      font-size: 2rem;
      cursor: pointer;
      color: var(--secondary-color);
    }





    @media (width < 922px) {
      .nav__links {
        display: none; /* Hide links by default */
        flex-direction: column;
        background: var(--primary-color-light);
        position: absolute;
        top: 60px; /* Adjust based on your design */
        right: 10px;
        width: 250px;
        text-align: center;
        border-radius: 5px;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
       
      }
      header{
        position: static;
      }

      .link{
        background:linear-gradient(0) var(--primary-color-light)!important;
      
        width: 100%;
       
      }
      .link a{
        background:linear-gradient(0) var(--primary-color-light)!important;
        color: var(--secondary-color);
        width: 120px;
      }
      .nav__links.active {
        display: flex;
        flex-direction: column;
      }

      .nav__links li {
        padding: 5px 0;
      }
    
      .menu__toggle .menu-2 {
        display: block;
        cursor: pointer;
      }
      .search--notification--profile {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
      }
  
    }

 

    .logo{
      display: flex;
      align-items: center;
      width: 300px;
      padding-left: 40px;
    }

    .menu{
      font-size: 25px;
    }



    .search--notification--profile{
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      margin-left: 100px;
      margin-right: 0;
    }

    .search {
      background-color: #bcadee;
      border-radius: 50px;
      width: 300px;
      padding: 5px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .search input {
      background-color: transparent;
      outline: none;
      border: none;
      text-indent: 15px;
      width: 85%;
    }

    .search button {
      outline: none;
      border: none;
      border-radius: 50%;
      background-color: #fff;
      padding: 3px;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 30px;
      height: 30px;
    }

    .search button i {
      font-size: 1.1rem;
      color: #4e34b6;
    }

    .search button:hover, .search button i:hover{
      cursor: pointer;
    }

    .notification--profile{
      display: flex;
      align-items: center;
    }

    .picon{
      margin-left: 20px;
      font-size: 1.1rem;
      padding: 5px;
      border-radius: 5px;
        
    }

    .picon:hover{
      cursor: pointer;
    }

    .lock{
      color: #3a278f;
      background-color: rgba(58, 39, 143, .2);
    }

    /* .lock a{
      color: #3a278f;
      text-decoration: none;
    } */

    .bell{
      color: #d9a600;
      background-color: rgba(217, 166, 0, 0.2);
    }
    /* .bell a{
      color: #d9a600;
      text-decoration: none;
    } */

    .chat{
      color: #1e3a8a;
      background-color: rgba(30, 58, 138, .2);
    }
    .chat a{
      color: #1e3a8a;
      text-decoration: none;
    }

    .profile{
      position: relative;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      overflow: hidden;
      
    }

   .profile img{
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }


    li{
      list-style: none;
    }

    a{
      text-decoration: none;
    }

    @media screen and (max-width:922px) {
        .logo {
            padding-left: 30px;
            width: fit-content;
        }
        .search--notification--profile {
            padding: 0 10px;
            margin-left: auto;
            display: flex!important;
        }

    }

    @media screen and (max-width:922px) {
        .search{
          display: block;
        }
        .lock,
        .chat {
          display: block;
        }
        .notification--profile {
            margin-left: auto;
        }
        .search--notification--profile {
          width: fit-content; 
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: space-between;
          padding: 0 20px;
        }

        .search {
          background-color:#a89bd3;
          width: 200px;
          padding: 5px;
          display: flex;
          align-items: center;
          justify-content: space-between;
          font-size: 12px;
          margin-bottom: 10px;
          margin-top: 10px;
        }
    

        .search button {
          width: 20px;
          height: 20px;
        }

        .search button i {
          font-size: 0.9rem;
        
        }

        .notification--profile{
          display: flex;
          align-items: center;
          justify-content: center;
          margin-right: auto;
          margin-left: auto;
        }


    }

    @media screen and (max-width:922px) {

        .logo {
            padding-left: 10px;
        }
        .search--notification--profile {
            padding: 0 10px;
        }
    }

  </style> 

</head>
<body> 
  <header>
    <nav class="section_container nav_container">
      
        <!-- Function Icon for Sidebar Toggle -->
      <div class="container">
        <div class="logo">
          <?php if (isset($_SESSION['admin'])|| isset($_SESSION['doctor'])|| isset($_SESSION['patient'])): ?>
            <div class="menu">
            <i class="ri-function-fill icon-0"   id="menu-button" style="color: #4e34b6;"></i>
            </div>
          <?php endif; ?>
          <div class="nav__logo">Health<span>Care</span></div>
        </div>

        <div class="menu__toggle" onclick="toggleMenu()">
            <i class="ri-menu-fill menu-2"></i>
        </div>
        <?php

include('connection.php');

// Get current tab ID from session or URL
$tab_id = $_GET['tab_id'] ?? ($_SESSION['tab_session_id'] ?? null);

// Get logged in user per role
$admin_user = $tab_id && isset($_SESSION['admin'][$tab_id]) ? $_SESSION['admin'][$tab_id] : null;
$doctor_user = $tab_id && isset($_SESSION['doctor'][$tab_id]) ? $_SESSION['doctor'][$tab_id] : null;
$patient_user = $tab_id && isset($_SESSION['patient'][$tab_id]) ? $_SESSION['patient'][$tab_id] : null;
?>

<div class="nav__links">
  <?php if ($admin_user): ?>
    <div class="search--notification--profile">
      <div class="search">
        <input type="text" placeholder="Search Schedule.." />
        <button type="submit"><i class="ri-search-2-line"></i></button>
      </div>
      <div class="notification--profile">
        <div class="picon lock"><i class="ri-lock-line"></i></div>
        <div class="picon bell"><i class="ri-notification-2-line"></i></div>
        <div class="picon chat"><a href="../admin/admin-support.php?tab_id=<?php echo $tab_id; ?>"><i class="ri-wechat-2-line"></a></i></div>
        <div class="picon profile">
          <?php
          $query = "SELECT profile FROM admin WHERE admin_hospital_id = '$admin_user'";
          $res = mysqli_query($connect, $query);
          $profile = "default.jpg";
          if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $profile = !empty($row['profile']) ? $row['profile'] : "default.jpg";
          }
          echo "<a href='../admin/profile.php?tab_id=$tab_id'><img src='../admin/img/$profile' alt='Profile'></a>";
          ?>
        </div>
      </div>
    </div>
    <li class="link"><a href="#"><?php echo $admin_user; ?></a></li>
    <li class="link"><a href="../admin/logout.php?tab_id=<?php echo $tab_id; ?>">Logout</a></li>

  <?php elseif ($doctor_user): ?>
    <div class="search--notification--profile">
      <div class="search">
        <input type="text" placeholder="Search Schedule.." />
        <button type="submit"><i class="ri-search-2-line"></i></button>
      </div>
      <div class="notification--profile">
        <div class="picon lock"><i class="ri-lock-line"></i></div>
        <div class="picon bell"><i class="ri-notification-2-line"></i></div>
        <div class="picon chat"><a href="../doctor/doctor-support.php?tab_id=<?php echo $tab_id; ?>"><i class="ri-wechat-2-line"></a></i></div>
        <div class="picon profile">
          <?php
          $query = "SELECT profile FROM doctor WHERE Doctor_hospital_id = '$doctor_user'";
          $res = mysqli_query($connect, $query);
          $profile = "doctor_default.jpg";
          if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $profile = !empty($row['profile']) ? $row['profile'] : "doctor_default.jpg";
          }
          echo "<a href='../doctor/doctor-profile.php?tab_id=$tab_id'><img src='../doctor/img/$profile' alt='Profile'></a>";
          ?>
        </div>
      </div>
    </div>
    <li class="link"><a href="#"><?php echo $doctor_user; ?></a></li>
    <li class="link"><a href="../doctor/logout.php?tab_id=<?php echo $tab_id; ?>">Logout</a></li>

  <?php elseif ($patient_user): ?>
    <div class="search--notification--profile">
      <div class="search">
        <input type="text" placeholder="Search Schedule.." />
        <button type="submit"><i class="ri-search-2-line"></i></button>
      </div>
      <div class="notification--profile">
        <div class="picon lock"><i class="ri-lock-line"></i></div>
        <div class="picon bell"><i class="ri-notification-2-line"></i></div>
        <div class="picon chat"><a href="../patient/patient-support.php?tab_id=<?php echo $tab_id; ?>"><i class="ri-wechat-2-line"></a></i></div>
        <div class="picon profile">
          <?php
          $query = "SELECT profile FROM patient WHERE Patient_No = '$patient_user'";
          $res = mysqli_query($connect, $query);
          $profile = "patient_default.jpg";
          if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $profile = !empty($row['profile']) ? $row['profile'] : "patient_default.jpg";
          }
          echo "<a href='../patient/patient-profile.php?tab_id=$tab_id'><img src='../patient/img/$profile' alt='Profile'></a>";
          ?>
        </div>
      </div>
    </div>
    <li class="link"><a href="#"><?php echo $patient_user; ?></a></li>
    <li class="link"><a href="../patient/logout.php?tab_id=<?php echo $tab_id; ?>">Logout</a></li>

  <?php else: ?>
    <style> header { position: static!important; } </style>
    <li class="link"><a href="../hospital/landing.php">Home</a></li>
    <li class="link"><a href="../hospital/patient-login.php">Patient</a></li>
    <li class="link"><a href="../hospital/doctor-login.php">Doctor</a></li>
    <li class="link"><a href="../hospital/admin-login.php">Admin</a></li>
  <?php endif; ?>
</div>
</div>

 <!-- Navigation Links -->
    
    </nav>
  </header>
    <script defer type="text/javascript">
function toggleMenu() {
  let links = document.querySelector(".nav__links"); // Select the correct element

    links.classList.toggle("active"); // Toggle visibility

}


    </script>
</body>
</html>