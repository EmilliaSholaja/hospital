<?php
session_start();
$tab_id = $_GET['tab_id'] ?? '';

if (!isset($_SESSION['doctor'][$tab_id])) {
    header("Location: ../doctor-login.php");
    exit();
}

$doctor_id = $_SESSION['doctor'][$tab_id];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor FAQ</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        .card-header button {
            width: 100%;
            text-align: left;
            font-weight: bold;
        }
        .search-input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php include("../include/header.php"); ?>
<div class="container-fluid main1">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -20px;">
                <?php include("doctor-sidenav.php"); ?>
            </div>
            <div class="col-md-10 main--content">
                <h4 class="text-center my-3">Doctor Frequently Asked Questions</h4>

                <input type="text" class="search-input" id="searchInput" placeholder="Search questions...">

                <div class="accordion" id="faqAccordion">
                    <?php
                    $faq = [
                        "How do I update my availability schedule?" => "You can update your availability under the 'Schedule' section in your dashboard.",
                        "How do I view patient appointments?" => "Go to the 'Appointments' tab to view upcoming or past appointments with your assigned patients.",
                        "How do I manage medical records?" => "You can view or update medical records from the 'View Patient Details' section.",
                        "How do I communicate with a patient?" => "Use the 'Report' tab to securely communicate with assigned patients.",
                    ];
                
$i = 0;
foreach ($faq as $question => $answer) {
    $collapseId = "collapse$i";
    $headingId = "heading$i";
    echo "
    <div class='card faq-item'>
        <div class='card-header' id='$headingId'>
            <h5 class='mb-0'>
                <button class='btn btn-link' type='button' data-toggle='collapse' data-target='#$collapseId' aria-expanded='false' aria-controls='$collapseId'>
                    <span class='mr-2'>+</span>$question
                      <br>
                </button>
              
            </h5>
        </div>
        <div id='$collapseId' class='collapse' aria-labelledby='$headingId' data-parent='#faqAccordion'>
            <div class='card-body'>$answer</div>
            <br>
        </div>
      
    </div>
      <br>";
    $i++;


                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // FAQ search filter
    $("#searchInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $(".faq-item").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Icon toggle on collapse/expand
    $('#faqAccordion').on('show.bs.collapse', function (e) {
        $(e.target).prev('.card-header').find("span").text("-");
    });

    $('#faqAccordion').on('hide.bs.collapse', function (e) {
        $(e.target).prev('.card-header').find("span").text("+");
    });
</script>
</body>
</html>