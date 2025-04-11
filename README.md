
# Hospital Clinical Management System

This is a web-based **Hospital/Clinical Management System** developed using **HTML, CSS, Bootstrap, JavaScript, PHP, and MySQL**. It includes roles for **Admin**, **Doctors** and **Patients** to manage appointments, patients, schedules, income, and more.

## 🔍 Overview

This system helps hospitals and clinics manage doctor appointments, patient data, schedules, and invoices efficiently. It provides different dashboards for Admins, Doctors and Patients enabling easy management of clinical tasks.

## ✨ Key Features

### Admin Dashboard
- View and manage all appointments
- View and filter patient data
- Assign doctors to appointments
- Manage doctor availability and schedules
- View system income (invoices, fees)
- Responsive and scrollable tables

### Doctor Dashboard
- View personal appointments
- Mark appointments as **Confirmed**, **Completed**, or **Discharged**
- Generate and submit invoices
- View patient details and notes
- Track appointment statuses and history

### Patient Dashboard
- View personal appointments
- Book Appointments and view previous appointments
- View past invoices and pay for new ones
- View their details and track their medical history
- Track appointment statuses and history

### System Modules
- Authentication for doctors (login with tab tracking)
- Appointments table with multiple statuses:
  - `PENDING`
  - `CONFIRMED`
  - `COMPLETED`
  - `DISCHARGED`
  - `CANCELLED`
- Automatic tracking of status timestamps:
  - `confirmed_at`
  - `completed_at`
  - `discharged_at`
  - `cancelled_at`
- Invoice generation and fee tracking

## 🛠️ Technologies Used

- **Frontend:** HTML, CSS, Bootstrap, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Server:** Apache (via XAMPP)


## ⚙️ Setup Instructions

1. **Install XAMPP**  
   Download and install XAMPP from [https://www.apachefriends.org](https://www.apachefriends.org).

2. **Start Apache and MySQL**  
   Launch the XAMPP control panel and start **Apache** and **MySQL**.

3. **Create the Database**
   - Open **phpMyAdmin**
   - Create a new database (e.g., `clinical_db`)
   - Import the SQL schema (provided in `database.sql` or write your own)

4. **Update Database Connection**
   - Open `include/connection.php`
   - Set your database name, user, and password

   ```php
   $connect = mysqli_connect("localhost", "root", "", "clinical_db");
Run the Project

Move the project folder into htdocs

Open your browser and go to:
http://localhost/project-folder/

🧪 Testing Login
You can manually insert login credentials for doctors or patients in the database via phpMyAdmin.

📌 To-Do
Add patient self-registration

Implement search/filter using AJAX

Improve role-based permissions

🙌 Contributing
Feel free to fork this repository and make changes. Pull requests are welcome!

📄 License
This project is open-source and free to use for educational purposes.








