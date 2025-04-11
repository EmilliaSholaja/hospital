<?php
session_start();
$tab_id = $_GET['tab_id'] ?? '';

if (!isset($_SESSION['patient'][$tab_id])) {
    header("Location: ../patient-login.php");
    exit();
}

$patient_id = $_SESSION['patient'][$tab_id];
include("../include/connection.php");

// Fetch current patient data
$query = "SELECT * FROM patient WHERE Patient_No = '$patient_id'";
$res = mysqli_query($connect, $query);
$current_data = mysqli_fetch_assoc($res);

// Handle form submission
if (isset($_POST['update_account'])) {
    $insurance_provider = $_POST['insurance-provider'];
    $other_insurance = $_POST['other-insurance'] ?? "";
    $full_insurance = ($insurance_provider === "Other" && !empty($other_insurance)) ? $other_insurance : $insurance_provider;

    $allergies = isset($_POST['allergies']) ? implode(", ", $_POST['allergies']) : "";
    $other_allergy = $_POST['other-allergy'] ?? "";
    $full_allergies = trim($allergies . ", " . $other_allergy, ", ");

    $address = !empty($_POST['address']) ? $_POST['address'] : $current_data['address'];
    $medical_history = !empty($_POST['medical-history']) ? $_POST['medical-history'] : $current_data['Medical_History'];
    $current_medications = !empty($_POST['current-medications']) ? $_POST['current-medications'] : $current_data['Current_Medications'];

    $emergency_contact_name = !empty($_POST['emergency-contact-name']) ? $_POST['emergency-contact-name'] : $current_data['E_Contact_Name'];
    $emergency_contact_relationship = !empty($_POST['emergency-contact-relationship']) ? $_POST['emergency-contact-relationship'] : $current_data['E_Contact_relationship'];
    $emergency_contact_phone = !empty($_POST['emergency-contact-phone']) ? $_POST['emergency-contact-phone'] : $current_data['E_Contact_phone'];

    $full_insurance = !empty($full_insurance) ? $full_insurance : $current_data['Insurance_Provider'];
    $full_allergies = !empty($full_allergies) ? $full_allergies : $current_data['Allergies'];

    // Update query
    $update_sql = "UPDATE patient SET 
        address = '$address',
        Insurance_Provider = '$full_insurance',
        Medical_History = '$medical_history',
        Current_Medications = '$current_medications',
        Allergies = '$full_allergies',
        E_Contact_Name = '$emergency_contact_name',
        E_Contact_relationship = '$emergency_contact_relationship',
        E_Contact_phone = '$emergency_contact_phone'
        WHERE Patient_No = '$patient_id'";

    if (mysqli_query($connect, $update_sql)) {
        echo "<script>alert('Account updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update account!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        .popup {
            display: none;
            position: absolute;
        top: 50%!important;
        left: 50%!important;
            transform: translate(-50%, -40%);
            background: white;

            height: 450px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px #000;
            overflow-y: auto;
            padding-top: 10px!important;
            width: 600px;
            display: none;
            
            
        }
        .popup-content {
            text-align: center;
        
        }


   
    
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 30px;
            cursor: pointer;
            color:rgb(196, 23, 23);
        }

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
    <?php include("../include/header.php"); ?>
    
    <div class="container-fluid main1">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -20px;">
                <?php include("../patient/patient-sidenav.php") ?>
            </div>
            <div class="col-md-10 main--content">
                <div class="container-fluid">
                    <h5 class="text-center">Settings</h5>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3 my-2 bg-light p-3 mx-2 border rounded">
                                <h6>Notification Settings</h6>
                                <p>Manage how you receive notifications.</p>
                                <ul>
                                    <li>Email Notifications: <input type="checkbox" checked></li>
                                    <li>SMS Alerts: <input type="checkbox"></li>
                                    <li>In-App Alerts: <input type="checkbox" checked></li>
                                </ul>
                            </div>
                            <div class="col-md-3 my-2 bg-light p-3 mx-2 border rounded">
                                <h6>Theme Settings</h6>
                                <p>Choose your preferred theme.</p>
                                <select class="form-control">
                                    <option>Default</option>
                                    <option>Dark Mode</option>
                                    <option>Blue Theme</option>
                                    <option>Lavender Theme</option>
                                </select>
                            </div>
                            <div class="col-md-3 my-2 bg-light p-3 mx-2 border rounded">
                                <h6>Security Settings</h6>
                                <p>Update your password and enable security features.</p>
                                <a href="../patient/patient-profile.php?tab_id=<?php echo $tab_id; ?>" class="btn btn-primary">Change Password</a>
                            </div>
                            <div class="col-md-3 my-2 bg-light p-3 mx-2 border rounded">
                                <h6>Account Settings</h6>
                                <p>Manage your account preferences.</p>
                                <button onclick="openPopup('accountSettingsPopup')"  class="btn btn-info">Update Info</button>
                            </div>

                            <div class="col-md-3 my-2 bg-light p-3 mx-2 border rounded">
                                <h6>Language Settings</h6>
                                <p>Select your preferred language.</p>
                                <select class="form-control">
                                    <option>English</option>
                                    <option>Spanish</option>
                                    <option>French</option>
                                    <option>German</option>
                                </select>
                            </div>

                            <div class="col-md-3 my-2 bg-light p-3 mx-2 border rounded">
                                <h6>Privacy Settings</h6>
                                <p>Manage your privacy options.</p>
                                <button onclick="openPopup('privacySettingsPopup')" class="btn btn-warning">Review Privacy</button>
                            </div>
                            <div class="col-md-3 my-2 bg-light p-3 mx-2 border rounded">
                                <h6>Backup & Restore</h6>
                                <p>Backup or restore your data.</p>
                                <a href="#" class="btn btn-secondary">Backup Data</a>
                            </div>
                            <div class="col-md-3 my-2 bg-light p-3 mx-2 border rounded">
                                <h6>Delete Account</h6>
                                <p>Permanently remove your account.</p>
                                <button class="btn btn-danger" id="deleteAccount" name="delete_account">Delete My Account</button>
                            </div>
                        </div>
                    </div>
                    <!-- Account Settings Pop-up -->
                    <div id="accountSettingsPopup" class="popup" style="display:none;">
                        <div class="popup-content">
                            <span class="close-btn" onclick="closePopup('accountSettingsPopup')">&times;</span>
                            <h4>Update Account Settings</h4>
                            <form method="POST">
                            <label for="address">Address:</label>
                            <textarea name="address" class="form-control" placeholder="Enter Address"><?php echo htmlspecialchars($current_data['address'] ?? ''); ?></textarea><br>

                            <label for="insurance-provider">Insurance Provider:</label>
                            <select name="insurance-provider" id="insurance-provider" class="form-control">
                                <option value="">Select an insurance provider</option>
                                <?php
                                    $providers = ["Aetna", "Blue Cross Blue Shield", "Cigna", "Humana", "UnitedHealthcare", "None", "Other"];
                                    foreach ($providers as $provider) {
                                        $selected = ($current_data['Insurance_Provider'] == $provider) ? "selected" : "";
                                        echo "<option value='$provider' $selected>$provider</option>";
                                    }
                                ?>
                            </select><br>

                            <div id="other-insurance-container" style="display: none;">
                                <label for="other-insurance">Specify Other:</label>
                                <input type="text" name="other-insurance" class="form-control" >
                            </div><br>

                            <label for="medical-history">Medical History:</label>
                            <textarea name="medical-history" class="form-control" placeholder="Enter Medical History"><?php echo htmlspecialchars($current_data['Medical_History'] ?? ''); ?></textarea><br>

                            <label for="current-medications">Current Medications:</label>
                            <input type="text" name="current-medications" class="form-control" value="<?php echo htmlspecialchars($current_data['Current_Medications'] ?? ''); ?>"><br>

                            <label for="allergies">Allergies:</label>
                            <p>Press Ctrl key to select more than one</p>

                            <select name="allergies[]" id="allergies" multiple class="form-control">
                                <?php
                                    $preset_allergies = ["Peanuts", "Shellfish", "Tree Nuts", "Fish", "Dairy", "Gluten", "Other"];
                                    $saved_allergies = explode(", ", $current_data['Allergies'] ?? '');
                                    foreach ($preset_allergies as $allergy) {
                                        $selected = in_array($allergy, $saved_allergies) ? "selected" : "";
                                        echo "<option value='$allergy' $selected>$allergy</option>";
                                    }
                                ?>
                            </select><br>

                                                        
                            <div id="selected-tags"></div>
                            <br>
                            <div id="other-allergy-container" style="margin-top: 10px; display: none;">
                                <label for="other-allergy">Specify other allergy:</label>
                                <input type="text" id="other-allergy" name="other-allergy" class="form-control" placeholder="Enter Other Allergy" autocomplete="off">
                            </div>
                                                
                            <label for="emergency-contact-name">Emergency Contact Name:</label>
                            <input type="text" name="emergency-contact-name" class="form-control" value="<?php echo htmlspecialchars($current_data['E_Contact_Name'] ?? ''); ?>"><br>

                            <label for="emergency-contact-relationship">Relationship:</label>
                            <input type="text" name="emergency-contact-relationship" class="form-control" value="<?php echo htmlspecialchars($current_data['E_Contact_relationship'] ?? ''); ?>"><br>

                            <label for="emergency-contact-phone">Phone Number:</label>
                            <input type="text" name="emergency-contact-phone" class="form-control" value="<?php echo htmlspecialchars($current_data['E_Contact_phone'] ?? ''); ?>"><br>

                            <input type="submit" name="update_account" class="btn btn-success" value="Update">
                                                        </form>
                                                    </div>
                                                </div>
                     <!-- Privacy Settings Pop-up -->
                    
                    
                    </div>
                    <div id="privacySettingsPopup" class="popup" style="display:none;">
                            <div class="popup-content">
                                <span class="close-btn" onclick="closePopup('privacySettingsPopup')">&times;</span>
                                <h4>Privacy Policy</h4>
                                <p>At our hospital, we take your privacy seriously and are committed to protecting your personal health information. This privacy policy outlines how we collect, use, and protect your data while you access our healthcare services. Please take the time to read this policy carefully.</p>

                                <h6>1. Information We Collect</h6>
                                <p>We collect the necessary information to provide healthcare services and comply with healthcare regulations. You have control over the information you provide, but certain data is necessary to ensure quality care.</p>

                                <ul>
                                    <li><strong>a. Personal Identification Information:</strong> For example, your full name, contact details (email, phone number), and identification documents.</li>
                                    <li><strong>b. Health Information:</strong> This includes medical history, diagnoses, treatments, prescriptions, allergies, and any other health-related information relevant to your care.</li>
                                    <li><strong>c. Payment and Billing Information:</strong> If you pay for services, we collect billing details, including insurance information, payment history, and transaction records.</li>
                                </ul>

                                <h6>2. How We Use Your Information</h6>
                                <p>Your personal and health information is used to provide medical care, coordinate with other healthcare providers, process billing and insurance claims, and maintain patient records. We will not share your health information without your consent unless required by law.</p>

                                <h6>3. Security of Your Information</h6>
                                <p>We implement appropriate physical, administrative, and technical safeguards to protect your data. Access to your information is limited to authorized personnel only, and we comply with all data protection laws applicable to healthcare services.</p>

                                <h6>4. Information Sharing</h6>
                                <p>Your information may be shared with medical professionals, insurance companies, and other entities involved in your care. We ensure that these parties comply with the privacy regulations governing healthcare data.</p>
                                        
                            </div>
                    </div>
            </div>
        </div>
    </div>
</div>
        <script defer>
            // Function to open the popup
            function openPopup(id) {
                document.getElementById(id).style.display = 'block';
            }

            // Function to close the popup
            function closePopup(id) {
                document.getElementById(id).style.display = 'none';
            }
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#deleteAccount").click(function(event) {
                    event.preventDefault();

                    if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
                        $.ajax({
                            url: "delete_account.php?tab_id=<?php echo $tab_id; ?>", // append tab_id to the URL
                            type: "POST",
                            data: { delete_account: true },
                            success: function(response) {
                                alert(response);
                                window.location.href = "../patient-login.php";
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX Error:", error);
                                alert("Error: Unable to delete your account.");
                            }
                        });
                    }
                });
            });
</script>
</body>
</html>