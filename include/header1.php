
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
  <link rel="stylesheet" href="../css/Admin-dashboard.css?v=<?php echo time(); ?>">

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

  .btn {
    padding: 0.75rem 2rem;
    outline: none;
    border: none;
    font-size: 1rem;
    white-space: nowrap;
    color: var(--white);
    background-color: var(--secondary-color);
    border-radius: 5px;
    cursor: pointer;
  }

  img {
    width: 100%;
    display: flex;
  }

  a {
    text-decoration: none;
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
    position: relative;
    z-index: 10;
    border-bottom: 2px solid #f1f1f1;
  }

  .nav__container {
    padding: 1rem 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
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


  /* Hide Menu Button on Large Screens */
 


  .link a {
    padding: 0.5rem;
    color: var(--primary-color-light);
  }

  .link a:hover {
    color: var(--white);
  }


    @media (width < 780px) {
      .nav__links {
        display: none; /* Hide links by default */
        flex-direction: column;
        background: var(--primary-color-dark);
        position: absolute;
        top: 60px; /* Adjust based on your design */
        right: 10px;
        width: 200px;
        text-align: center;
        border-radius: 5px;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
      }
        .nav__links.active {
          display: flex;
        }
      
        .nav__links li {
          padding: 5px 0;
        }
      
        .menu__toggle {
          display: block;
        }
    
      }


  </style> 
</head>
<body> 
<header>
      <nav class="section__container nav__container">
        <div class="nav__logo">Health<span>Care</span></div>
        <ul class="nav__links">
          <?php 
         

            if( isset($_SESSION['admin'])){
              
              $user = $_SESSION['admin'];

              echo'
      <div class="logo">
        <i class="ri-function-fill icon-0 menu" style="color: #4e34b6;"></i>
      </div>

      <div class="search--notification--profile">
        <div class="search">
          <input type="text" placeholder="Search Schedule.." />
          <button type="submit" title="Search">
            <i class="ri-search-2-line"></i>
          </button>
        </div>
        <div class="notification--profile">
          <div class="picon lock">
            <i class="ri-lock-line"></i>
          </div>
          <div class="picon bell">
            <i class="ri-notification-2-line"></i>
          </div>
          <div class="picon chat">
            <i class="ri-wechat-2-line"></i>
          </div>
          <div class="picon profile">
            <img src="../images/profile.jpg" alt="" />
          </div>
        </div>
                <li class="link"><a href="#">'.($user).'</a></li>
                <li class="link"><a href="../admin/logout.php">Logout</a></li>
              ';
           
            }else{
              echo'
                <li class="link"><a href="../hospital/landing.php">Home</a></li>
                <li class="link"><a href="admin-login.php">Admin</a></li>
                <li class="link"><a href="#">Doctor</a></li>
                <li class="link"><a href="#">Patient</a></li>
              ';
            }
          ?>
        </ul>
        <div class="menu__toggle" onclick="toggleMenu()"><i class="ri-menu-fill"></i></div>
      </nav>
    </header>
    <script defer type="text/javascript">
      function toggleMenu() {
  document.querySelector(".nav__links").classList.toggle("active");
}

    </script>
</body>
</html>