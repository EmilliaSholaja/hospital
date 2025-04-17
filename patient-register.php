<?php
include("../hospital/include/register.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Account</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="./css/apply.css?v=<?php echo time(); ?>">
        <style>
   




.selected-tag {
    background-color: #007bff;
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
}

.selected-tag span {
    font-size: 12px;
}


        </style>

    </head>
    <body>
        <?php include("./include/header.php"); ?>
        <div class="container d-flex justify-content-center align-items-center " id="login-container">
            <div class="row shadow-lg p-4 rounded bg-white" style="max-width:750px; width: 100%;">
                <!-- Register Form -->
                <div class="col-md-10" style="width: 100%;">
                
                    <h3 class="text-center">Register</h3>
                    <p class="text-muted text-center">Create An Account</p>

                    <!-- Image Section -->
                    <img src="./images/background3.jpg" alt="Create account Image" class="img-fluid login-img w-100" id="section-image" style="max-height: 100%;">
                
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
                        <?php  endif; ?>
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
                        <div class="mb-3">
                            <label for="address">Address:</label>
                            <textarea id="address" class="form-control" placeholder="Enter Address" autocomplete="off" name="address" value="<?php if(isset($_POST['address'])) echo $_POST['address'];  ?>"></textarea>
                        </div>

                    </div>

                    <!-- 🔹 Extra Information Section -->
                    <div class="form-section">
                        <?php if (!empty($errors_extra)): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($errors_extra as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="insurance-provider">Insurance Provider:</label>
                            <select id="insurance-provider" class="form-control" title="Insurance Provider" name="insurance-provider">
                                <option value="">Select an insurance provider</option>
                                <option value="Aetna">Aetna</option>
                                <option value="Blue Cross Blue Shield">Blue Cross Blue Shield</option>
                                <option value="Cigna">Cigna</option>
                                <option value="Humana">Humana</option>
                                <option value="UnitedHealthcare">UnitedHealthcare</option>
                                <option value="None">None</option>
                                <option value="Other">Other</option>
                            </select>

                            <div id="other-insurance-container" style="margin-top: 10px; display: none;">
                                <label for="other-insurance">Specify other insurance provider:</label>
                                <input type="text" id="other-insurance" name="other-insurance" style="width: 50%;" class="form-control" placeholder="Enter Other Insurance Provider" autocomplete="off">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="medical-history">Medical History:</label>
                            <textarea id="medical-history" class="form-control" placeholder="Enter Medical History" autocomplete="off" name="medical-history" value="<?php if(isset($_POST['medical-history'])) echo $_POST['medical-history']; ?>"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="current-medications">Current Medications:</label>
                            <input type="text" id="current-medications" name="current-medications" class="form-control" placeholder="Enter Current Medications" autocomplete="off" value="<?php if(isset($_POST['current-medications'])) echo $_POST['current-medications']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="allergies">Allergies:</label>
                            <p>Press Ctrl key to select more than one</p>
                            <div class="multi-select-container">
                                <select name="allergies[]" id="allergies" class="form-control" title="Allergies" multiple>
                                    <option value="Peanuts">Peanuts</option>
                                    <option value="Shellfish">Shellfish</option>
                                    <option value="Tree Nuts">Tree Nuts</option>
                                    <option value="Fish">Fish</option>
                                    <option value="Dairy">Dairy</option>
                                    <option value="Gluten">Gluten</option>
                                    <option value="Eggs">Eggs</option>
                                    <option value="Soy">Soy</option>
                                    <option value="None">None</option>
                                    <option value="Other">Other</option>
                                </select>
                                <div id="selected-tags"></div>
                            </div>

                            <div id="other-allergy-container" style="margin-top: 10px; display: none;">
                                <label for="other-allergy">Specify other allergy:</label>
                                <input type="text" id="other-allergy" name="other-allergy" style="width: 50%!important;" class="form-control" placeholder="Enter Other Allergy" autocomplete="off" value="<?php if(isset($_POST['other-allergy'])) echo $_POST['other-allergy']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="emergency-contact-name">Emergency Contact Name:</label>
                            <input type="text" id="emergency-contact-name" name="emergency-contact-name" class="form-control" placeholder="Enter Emergency Contact Name" autocomplete="off" value="<?php if(isset($_POST['emergency-contact-name'])) echo $_POST['emergency-contact-name']; ?>">

                            <label for="emergency-contact-relationship">Relationship:</label>
                            <input type="text" id="emergency-contact-relationship" name="emergency-contact-relationship" class="form-control" placeholder="Enter Emergency Contact Relationship" autocomplete="off" value="<?php if(isset($_POST['emergency-contact-relationship'])) echo $_POST['emergency-contact-relationship']; ?>">

                            <label for="emergency-contact-phone">Phone Number:</label>
                            <input type="tel" id="emergency-contact-phone" name="emergency-contact-phone" class="form-control" placeholder="Enter Emergency Contact Phone" autocomplete="off" value="<?php if(isset($_POST['emergency-contact-phone'])) echo $_POST['emergency-contact-phone']; ?>">
                        </div>



                    </div>

                    <div class="form-navigation mt-4 text-center">
                        <button type="button" class="btn btn-secondary w-50  mt-3" id="prevBtn">Previous</button>
                        <button type="button" class="btn btn-primary w-50  mt-3" id="nextBtn">Next</button>
                        <button class="btn btn-success w-50 mt-3" name="create" id="create_account" type="submit">Create Account</button>
                    </div>
                    </form>
                    <p class="info mt-3 text-center">
                        Already Have An Account?  <a href="../hospital/patient-login.php" class="account">Login</a>
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
                let createButton = document.getElementById("create_account");
                let formImage = document.getElementById("section-image"); // Image element

                let images = [
                    "../hospital/images/background3.jpg",  // First section image (Personal Information)
                    "../hospital/images/background4.jpg"   // Second section image (Professional Information)
                ];

                function showSection(index) {
                    sections.forEach((section, i) => {
                        section.style.display = i === index ? "block" : "none";
                    });

                    prevButton.style.display = index === 0 ? "none" : "inline-block";
                    nextButton.style.display = index === sections.length - 1 ? "none" : "inline-block";
                    createButton.style.display = index === sections.length - 1 ? "block" : "none";

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
       <script defer>
document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('allergies');
    const selectedTagsContainer = document.getElementById('selected-tags');
    const otherAllergyInput = document.getElementById('other-allergy');
    const otherAllergiesContainer = document.getElementById('other-allergy-container');

    // Function to update tags when allergies are selected
    selectElement.addEventListener('change', function() {
        const selectedOptions = Array.from(selectElement.selectedOptions);
        selectedTagsContainer.innerHTML = ''; // Clear existing tags

        selectedOptions.forEach(option => {
            const tag = document.createElement('div');
            tag.classList.add('selected-tag');
            tag.innerHTML = option.textContent + ' <span class="remove-tag" data-value="' + option.value + '">x</span>';
            selectedTagsContainer.appendChild(tag);
        });

        // Check if "Other" is selected and show the "Other" input container
        if (selectedOptions.some(option => option.value === 'Other')) {
            otherAllergiesContainer.style.display = 'block';
        } else {
            otherAllergiesContainer.style.display = 'none';
        }
    });

    selectedTagsContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-tag')) {
            const valueToRemove = event.target.getAttribute('data-value');
            otherAllergyInput.value = valueToRemove;
            event.target.parentElement.remove();

            // Hide the "Other" input container if it's removed
            if ([...selectElement.selectedOptions].some(option => option.value === 'Other')) {
                otherAllergiesContainer.style.display = 'none'; // Hide if "Other" is no longer selected
            }
        }
    });

   


});
</script>
        <script defer>
            const insuranceSelect = document.getElementById('insurance-provider');
            const otherInsuranceContainer = document.getElementById('other-insurance-container');
            const otherInsuranceInput = document.getElementById('other-insurance');

            insuranceSelect.addEventListener('change', () => {
                if (insuranceSelect.value === 'Other') {
                    otherInsuranceContainer.style.display = 'block';
                } else {
                    otherInsuranceContainer.style.display = 'none';
                    otherInsuranceInput.value = ''; // Clear input if "Other" is not selected
                }
            });
        </script>
        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>