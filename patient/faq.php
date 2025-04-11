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
    <title>Patient FAQ</title>
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
                <?php include("patient-sidenav.php"); ?>
            </div>
            <div class="col-md-10 main--content">
                <h4 class="text-center my-3">Patient Frequently Asked Questions</h4>

                <input type="text" class="search-input" id="searchInput" placeholder="Search questions...">

                <div class="accordion" id="faqAccordion">
                    <?php
                    $faq = [
                        "How do I book an appointment?" => "Go to the 'Book Appointment' section and fill in the required details to book an appointment.",
                        "Can I view my past appointments?" => "Yes, your past appointments are listed at the bottom of the 'Book Appointment' page.",
                        "How can I update my profile?" => "You can update your profile information in the 'Profile' section on your sidebar.",
                        "How do I cancel or reschedule my appointment?" => "Use the 'Appointment History' section to cancel or reschedule appointments, if applicable.",
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