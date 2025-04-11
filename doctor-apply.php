<?php
include("../hospital/include/apply.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Apply For A Doctor's Job</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="./css/apply.css?v=<?php echo time(); ?>">

    </head>
    <body>
        <?php include("./include/header.php"); ?>
        <div class="container d-flex justify-content-center align-items-center " id="login-container">
            <div class="row shadow-lg p-4 rounded bg-white" style="max-width:750px; width: 100%;">
                <!-- Login Form -->
                <div class="col-md-10" style="width: 100%;">
                
                    <h3 class="text-center">Apply Now!!!</h3>
                    <p class="text-muted text-center">Apply to get a Postion</p>

                    <!-- Image Section -->
                    <img src="./images/background1.jpg" alt="Apply now Image" class="img-fluid login-img w-100" id="section-image" style="max-height: 100%;">
                
                    <form method="post">
                    <!-- 🔹 Personal Information Section -->
                    <div class="form-section active">
                        <?php if (!empty($errors_personal)): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($errors_personal as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label>Full Name:</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Full Name" autocomplete="off" value="<?php if(isset($_POST['name'])) echo $_POST['name'];  ?>">
                        </div>

                        <div class="mb-3">
                            <label>Email Address:</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email Address" autocomplete="off" value="<?php if(isset($_POST['email'])) echo $_POST['email'];  ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label>Gender:</label>
                            <select name="gender" class="form-control" title="Gender">
                                <option value="">Select Gender</option>
                                <option value="Male" >Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label>Phone Number:</label>
                            <input type="tel" name="phone" class="form-control" placeholder="Enter Phone Number" autocomplete="off" value="<?php if(isset($_POST['phone'])) echo $_POST['phone'];  ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label>Date of Birth:</label>
                            <input type="date" name="dob" class="form-control" placeholder="Enter Date of Birth" autocomplete="off" value="<?php if(isset($_POST['dob'])) echo $_POST['dob'];  ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="country">Select your Country</label>
                            <select name="country" title="Country" class="form-control">
                                <option value="">Select Your Country</option>
                                <option value="Australia">Australia</option>
                                <option value="Brazil">Brazil</option>
                                <option value="Canada">Canada</option>
                                <option value="China">China</option>
                                <option value="France">France</option>
                                <option value="Germany">Germany</option>
                                <option value="India">India</option>
                                <option value="Italy">Italy</option>
                                <option value="Japan">Japan</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Russia">Russia</option>
                                <option value="South Africa">South Africa</option>
                                <option value="Spain">Spain</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States">United States</option>
                            </select>
                        </div>

                    </div>

                    <!-- 🔹 Professional Information Section -->
                    <div class="form-section">
                        <?php if (!empty($errors_professional)): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($errors_professional as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label>Specialization:</label>
                            <input type="text" name="specialization" class="form-control" placeholder="Enter Specialization" autocomplete="off" value="<?php if(isset($_POST['specialization'])) echo $_POST['specialization'];  ?>">
                        </div>
                        <div class="mb-3">
                            <label>Degree:</label>
                            <input type="text" name="degree" class="form-control" placeholder="Enter Degree" autocomplete="off" value="<?php if(isset($_POST['degree'])) echo $_POST['degree'];  ?>">
                        </div>
                            
                        <div class="mb-3">
                            <label>Experience:</label>
                            <input type="number" name="experience" class="form-control" placeholder="Enter Experience" autocomplete="off" value="<?php if(isset($_POST['experience'])) echo $_POST['experience'];  ?>">
                        </div>
                            
                        <div class="mb-3">
                            <label>Hospital Name:</label>
                            <input type="text" name="hospital" class="form-control" placeholder="Enter Hospital Name" autocomplete="off" value="<?php if(isset($_POST['hospital'])) echo $_POST['hospital'];  ?>">
                        </div>
                            
                        <div class="mb-3">
                            <label>License Number:</label>
                            <input type="text" name="license_no" class="form-control" placeholder="Enter License Number" autocomplete="off" value="<?php if(isset($_POST['license_no'])) echo $_POST['license_no'];  ?>">
                        </div>

                    </div>

                    <div class="form-navigation mt-4 text-center">
                        <button type="button" class="btn btn-secondary w-50  mt-3" id="prevBtn">Previous</button>
                        <button type="button" class="btn btn-primary w-50  mt-3" id="nextBtn">Next</button>
                        <button class="btn btn-success w-50 mt-3" name="apply" id="apply-now" type="submit">Apply Now</button>
                    </div>
                    </form>
                    <p class="info mt-3 text-center">
                        Already Have An Account?  <a href="../hospital/doctor-login.php" class="account">Login</a>
                    </p>

                </div>
            </div>
        </div>
        <script defer>

            document.addEventListener("DOMContentLoaded", function () {
                let sections = document.querySelectorAll(".form-section");
                let currentSection = 0;
                let nextButton = document.getElementById("nextBtn");
                let prevButton = document.getElementById("prevBtn");
                let applyButton = document.getElementById("apply-now");
                let formImage = document.getElementById("section-image"); // Image element

                let images = [
                    "../hospital/images/background1.jpg",  // First section image (Personal Information)
                    "../hospital/images/background2.jpg"   // Second section image (Professional Information)
                ];

                function showSection(index) {
                    sections.forEach((section, i) => {
                        section.style.display = i === index ? "block" : "none";
                    });

                    prevButton.style.display = index === 0 ? "none" : "inline-block";
                    nextButton.style.display = index === sections.length - 1 ? "none" : "inline-block";
                    applyButton.style.display = index === sections.length - 1 ? "block" : "none";

                    // Change the image based on the section
                    formImage.src = images[index];
                }

                nextButton.addEventListener("click", function () {
                    if (currentSection < sections.length - 1) {
                        currentSection++;
                        showSection(currentSection);
                    }
                });

                prevButton.addEventListener("click", function () {
                    if (currentSection > 0) {   
                        currentSection--;
                        showSection(currentSection);
                    }
                });

                showSection(currentSection);
            });
        </script>
        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>