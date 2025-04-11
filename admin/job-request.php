<?php
session_start();
$tab_id = $_GET['tab_id'] ?? '';



// You can access the logged-in admin ID using:
$admin_id = $_SESSION['admin'][$tab_id];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Job Request</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            .table-responsive {
                max-height: 500px;
                overflow-y: auto;
                margin-left: 50px!important;
            }
            @media screen and(max-width: 768px) {
                .table-responsive {
               
                margin-left: 0px!important;
            }
            }
            table {
                white-space: nowrap;
            }

            th, td {
                text-align: center;
                vertical-align: middle;
            }

            .custom-modal {
                display: none;
                position: fixed;
                z-index: 9999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
            }

            .custom-modal-dialog {
                width: 400px;
                margin: 10% auto;
                background: white;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            }

            .custom-modal-header {
                background: #f1f1f1;
                padding: 10px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .custom-modal-title {
                font-size: 18px;
            }

            .close-modal {
                background: none;
                border: none;
                font-size: 20px;
                cursor: pointer;
            }

            .custom-modal-body {
                padding: 20px;
            }

            .custom-modal-footer {
                display: flex;
                justify-content: space-between;
                padding: 10px;
                background: #f1f1f1;
            }

            .cancel-modal, .approve-btn {
                padding: 8px 12px;
                border: none;
                cursor: pointer;
                font-size: 14px;
            }

            .approve-btn {
                background: #4e34b6;
                color: white;
            }
        </style>
    </head>
    <body>
        <?php include("../include/header.php"); ?>

        <div class="main1 d-flex">
            <div class="row w-100">
                <div class="col-md-2">
                    <?php include("../admin/sidenav.php") ?>
                </div>
                <div class="col-md-10 main--content">
                    <h5 class="text-center my">Job Request</h5>
                    <div id="show"></div>
                </div>
            </div>
        </div>

        <!-- Approval Modal -->
        <div id="approveModal" class="custom-modal">
            <div class="custom-modal-dialog">
                <div class="custom-modal-content">
                    <div class="custom-modal-header">
                        <h5 class="custom-modal-title">Approve Doctor</h5>
                        <button class="close-modal">&times;</button>
                    </div>
                    <div class="custom-modal-body">
                        <form id="approveForm" method="POST">
                            <input type="hidden" id="doctorId" name="id">
                            <div class="mb-3">
                                <label for="username">Doctor Hospital ID</label>
                                <input type="text" class="form-control" id="username" autocomplete="off" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" autocomplete="off" name="password" required>
                            </div>
                            <div class="custom-modal-footer">
                                <button type="button" class="cancel-modal">Cancel</button>
                                <button type="submit" class="approve-btn">Approve</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const modal = document.getElementById("approveModal");
                const approveButtons = document.querySelectorAll(".approve");
                const closeButton = document.querySelector(".close-modal");
                const cancelButton = document.querySelector(".cancel-modal");

                approveButtons.forEach(button => {
                    button.addEventListener("click", function() {
                        const doctorId = this.id;
                        document.getElementById("doctorId").value = doctorId;
                        modal.style.display = "block";
                    });
                });

                closeButton.addEventListener("click", function() {
                    modal.style.display = "none";
                });

                cancelButton.addEventListener("click", function() {
                    modal.style.display = "none";
                });

                window.addEventListener("click", function(event) {
                    if (event.target === modal) {
                        modal.style.display = "none";
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function(){
                // Function to display job requests
                function show(){
                    $.ajax({
                        url: "ajax_job_request.php", // Ensure this PHP script is fetching the job requests
                        method: "POST",
                        success: function(data){
                            $("#show").html(data);
                        }
                    });
                }
                show();

                $(document).on("click", ".approve", function(){
                    var id = $(this).attr("id");
                    $("#doctorId").val(id);
                    $("#approveModal").show();
                });

                $("#approveForm").submit(function(e){
                    e.preventDefault();
                    var formData = $(this).serialize();

                    $.ajax({
                        url: "ajax_approve.php",
                        method: "POST",
                        data: formData,
                        success: function(response){
                            alert(response);
                            $("#approveModal").hide();
                            show();
                        }
                    });
                });

                // Reject button click listener
                $(document).on("click", ".reject", function(){
                    var id = $(this).attr("id");
                    $.ajax({
                        url: "ajax_reject.php",  // Ensure this PHP script handles rejection of a doctor
                        method: "POST",
                        data: {id: id},  // Pass the doctor ID for rejection
                        success: function(data){
                            show();  // Reload job requests after rejection
                        }
                    });
                });
            });
        </script>
    </body>
</html>