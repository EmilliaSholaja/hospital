<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .bg-lavender {
            background-color: #e6e6fa !important;
            color: #3a278f !important;
        }

        a span i {
            color: #59a89b !important;
        }

        /* Sidebar styles */
                .sidebar {
                    position: sticky;
                    transition: all 0.3s ease-in-out;
                    width: 200px;
                    height: calc(100vh - 70px); /* Allow it to grow with content */
                    overflow: hidden;
                    border-radius: 0 5px 0 5px;
                    background-color: #e6e6fa; /* Lavender background */
                }

                .main1 {
                    display: flex !important;
                    padding-top: 71px; /* Space for the header */
                }

        /* When the sidebar is collapsed */
        .sidebar.active {
            width: 70px !important;
            font-size: 20px;
            text-align: center;
        }

        .sidebar a.active {
    background-color: #3a278f !important;
    color: white !important;
}

.sidebar a.active i {
    color: white!important;
}

        /* Main content area */
        .main--content {
            transition: width 0.3s ease-in-out;
            flex-grow: 1; /* Makes the main content grow to fill the remaining space */
            height: calc(100vh - 70px);
            overflow-y: auto!important;
            padding-top: 20px;
            
        }

        .main--content.active {
            width: calc(100vh - 70px); /* Adjusts width when sidebar is active */
        }

        /* Make sidebar responsive */
        @media (max-width: 922px) {

            .main--content {
                margin-left: 10px!important;
                width: 90%;
                overflow-y: visible!important;
                transition: overflow-y 0.5s ease-in-out!important;
                padding-top: 0px!important;
            }
          
            
        }
        .sidebar .sidebar--item {
            display: inline-block;
            opacity: 1;
            transition: opacity 0.3s ease-in-out;
        }

        .sidebar.active .sidebar--item {
            opacity: 0;
            display: none; /* Hides text */
        }

        .sidebar .icon {
            display: inline-block;
            text-align: center;
            width: 100%; /* Keeps icons centered */
        }

        .sidebar.active .icon {
            display: flex !important; /* Ensures icons remain visible */
        }



        /* Ensure links are visible on small screens when sidebar is active */
        @media screen and (max-width: 922px) {

            
            .sidebar {
                display: none!important; /* Hide links by default */
                flex-direction: column!important;
                background:lavender!important;
                position: absolute!important;
                top: 80px!important; /* Adjust based on your design */
                left: 0px!important;
                text-align: center!important;
                border-radius: 5px!important;
                box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2)!important;
            }

            .sidebar.active {
                width: 250px!important;
                display: flex!important;
                flex-direction: column!important;
            }

            .sidebar .sidebar--item {
                display: inline-block!important;
                opacity: 1!important;
                transition: opacity 0.3s ease-in-out!important;
            }

            .sidebar.active .sidebar--item {
                opacity: 1 !important; /* Ensure visibility */
                display: flex !important; /* Show links */
            }
            .sidebar.active .icon {
            display: inline-block;
            text-align: center!important;
            width: 100%; /* Keeps icons centered */
        }

        }


        
    </style>
</head>
<body>

    

    <!-- SideNav Begins -->
     <div class="sidenav">

    

        <div class="sidebar list-group bg-lavender">
            <a class="list-group-item list-group-item-action bg-lavender text-center" data-parent="dashboard" href="../patient/patient-index.php?tab_id=<?php echo $tab_id; ?>" title="Dashboard">
                <span class="icon"><i class="ri-layout-grid-line"></i></span>
                <span class="sidebar--item">Dashboard</span>
            </a>
            <a class="list-group-item list-group-item-action bg-lavender text-center" data-parent="profile" href="../patient/patient-profile.php?tab_id=<?php echo $tab_id; ?>" title="Profile">
                <span class="icon"><i class="ri-user-3-fill"></i></span>
                <span class="sidebar--item">Profile</span>
            </a>
            <a class="list-group-item list-group-item-action bg-lavender text-center" data-parent="appointment" href="../patient/appointment.php?tab_id=<?php echo $tab_id; ?>" title="Book Appointment">
                <span class="icon"><i class="ri-pencil-fill"></i></span>
                <span class="sidebar--item">Book Appointment</span>
            </a>
         
            <a class="list-group-item list-group-item-action bg-lavender text-center" data-parent="invoice" href="../patient/patient-invoice.php?tab_id=<?php echo $tab_id; ?>" title="Invoice">
                <span class="icon"><i class="ri-money-dollar-box-fill"></i></span>
                <span class="sidebar--item">Invoice</span>
            </a>

            <a class="list-group-item list-group-item-action bg-lavender text-center" data-parent="support" href="../patient/patient-support.php?tab_id=<?php echo $tab_id; ?>" title="Support">
                <span class="icon"><i class="ri-customer-service-line"></i></span>
                <span class="sidebar--item">Support</span>
            </a>
            <a class="list-group-item list-group-item-action bg-lavender text-center" data-parent="settings" href="../patient/settings.php?tab_id=<?php echo $tab_id; ?>" title="Settings">
                <span class="icon"><i class="ri-settings-3-line"></i></span>
                <span class="sidebar--item">Settings</span>
            </a> 
        </div>
       </div> 

    <!-- SideNav Ends -->


    <script defer>

document.addEventListener("DOMContentLoaded", function () {
    let menuToggle = document.getElementById("menu-button"); 
    let sidebar = document.querySelector(".sidebar");
    let mainContent = document.querySelector(".main--content");

    // Highlight active sidebar link
    const sidebarLinks = document.querySelectorAll('.sidebar a');

    sidebarLinks.forEach(link => {
        if (link.href === window.location.href) {
            link.classList.add('active');
        }

        link.addEventListener('click', function () {
            sidebarLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Sidebar toggle behavior
    if(menuToggle) {
        menuToggle.addEventListener("click", function () {
            if (window.innerWidth <= 769) {
                sidebar.classList.toggle("active");
            } else {
                sidebar.classList.toggle("active");
                mainContent.classList.toggle("active");
            }
        });
    }
});
</script>

<script defer>
document.addEventListener("DOMContentLoaded", function () {
    const sidebarLinks = document.querySelectorAll('.sidebar a');

    // Map child pages to sidebar parent identifiers
    const parentMap = {
        "patient-index.php": "dashboard",
        "medical-record.php": "dashboard",
        "lab-result.php": "dashboard",
        "prescription.php": "dashboard",

        "patient-profile.php": "profile",

        "appointment.php": "appointment",


        "patient-invoice.php": "invoice",
        "view-invoice.php": "invoice",
        "pay-invoice.php": "invoice",

        "patient-support.php": "support",
        "faq.php": "support",

        "settings.php": "settings"
    };

    const currentPath = window.location.pathname.split("/").pop();

    const currentParent = parentMap[currentPath]; // Get the parent key from map

    sidebarLinks.forEach(link => {
        if (link.dataset.parent === currentParent) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });

    // Optional: keep clicked link highlighted temporarily
    sidebarLinks.forEach(link => {
        link.addEventListener("click", function () {
            sidebarLinks.forEach(l => l.classList.remove("active"));
            this.classList.add("active");
        });
    });
});
</script>

</body>
</html>