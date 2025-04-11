<?php
session_start();
$tab_id = $_GET['tab_id'] ?? '';

if (!isset($_SESSION['patient'][$tab_id])) {
    header("Location: ../patient-login.php");
    exit();
}

// You can access the logged-in admin ID using:
$patient_id = $_SESSION['patient'][$tab_id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Tips</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  
</head>
<body>
    <?php 
        include("../include/header.php");
        include("../include/connection.php");
    ?><div class="container-fluid main1">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -20px;">
                <?php include("../patient/patient-sidenav.php") ?>
            </div>
            <div class="col-md-10 main--content">
                <div class="container-fluid">
                    
                    <div class="col-md-12">
                    
                        <div class="row">
                            <div class="col-md-8">
                            <h5 class="text-center my-4">Health & Wellness Tips</h5>
                                <?php 
                                $articles = [
                                    [
                                        "title" => "The Importance of a Balanced Diet",
                                        "image" => "../images/healthy-diet.jpeg",
                                        "description" => "A well-balanced diet provides essential nutrients and energy to keep your body functioning optimally. Discover the key elements of a healthy diet and how to incorporate them into your daily routine.",
                                        "link" => "#"
                                    ],
                                    [
                                        "title" => "Benefits of Regular Exercise",
                                        "image" => "../images/exercise.jpg",
                                        "description" => "Exercise is crucial for maintaining both physical and mental well-being. Learn about different types of exercises and their benefits for your overall health.",
                                        "link" => "#"
                                    ],
                                    [
                                        "title" => "Mental Health Awareness",
                                        "image" => "../images/mental-health.jpg",
                                        "description" => "Mental health is just as important as physical health. Read about ways to manage stress, improve sleep quality, and maintain a positive mindset.",
                                        "link" => "#"
                                    ],
                                    [
                                        "title" => "Tips for a Strong Immune System",
                                        "image" => "../images/immune-system.jpg",
                                        "description" => "A strong immune system helps protect against illnesses. Explore natural ways to boost your immunity through diet, exercise, and lifestyle choices.",
                                        "link" => "#"
                                    ]
                                ];
                                
                                foreach ($articles as $article) {
                                    echo "<div class='card mb-4' style='z-index: -1;'>
                                            <img src='{$article['image']}' class='card-img-top' height='300px' alt='{$article['title']}'>
                                            <div class='card-body'>
                                                <h5 class='card-title'>{$article['title']}</h5>
                                                <p class='card-text'>{$article['description']}</p>
                                                <a href='{$article['link']}' class='btn btn-primary'>Read More</a>
                                            </div>
                                        </div>";
                                }
                                ?>
                            </div>
                            
                            <div class="col-md-4">
                                <h6 class="text-center">Categories</h6>
                                <ul class="list-group">
                                    <li class="list-group-item"><a href="#">Nutrition</a></li>
                                    <li class="list-group-item"><a href="#">Fitness</a></li>
                                    <li class="list-group-item"><a href="#">Mental Health</a></li>
                                    <li class="list-group-item"><a href="#">Lifestyle</a></li>
                                    <li class="list-group-item"><a href="#">General Wellness</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>