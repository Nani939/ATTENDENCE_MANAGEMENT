#  STUDENTS_ATTENDENCE_MANAGEMENT
# Student Attendance Management System (PHP + MySQL + XAMPP)

A simple and effective web-based Student Attendance Management System where:
- **Admins** can register, login, and mark attendance.
- **Students** can register, login, and view their individual attendance percentage and bar graph.

## Features

### Admin:
- Secure login system.
- Mark attendance for students by date.
- View all student attendance records.
- Logout securely.

### Student:
- Register with hall ticket, email, and password.
- Login to view attendance.
- Attendance percentage and graphical chart using Chart.js.
- Logout securely.

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL (via XAMPP)
- **Charting**: Chart.js
- **Tool**: Visual Studio Code, XAMPP


## Database Tables.
1. `students` – stores student details.
2. `attendance` – stores student attendance records (date-wise).

## Installation Steps

1. Clone this repository or download the ZIP.
2. Open **XAMPP** and start Apache & MySQL.
3. Import the SQL file located in `sql/database_setup.sql` into **phpMyAdmin**.
4. Place the project folder into `C:\\xampp\\htdocs\\`.
5. Open browser and go to `http://localhost/Student_Attendance_Management/`.


## Future Enhancements

- Email alerts for low attendance.
- Forgot password feature.
- Admin dashboard with analytics.
- Export attendance reports to PDF/Excel.
- Role-based access control (RBAC).

## License

This project is free to use under the MIT License.
"""
