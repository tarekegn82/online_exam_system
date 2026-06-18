# Online Examination System

A web-based examination platform built with PHP, MySQL, Bootstrap, and JavaScript that allows administrators, teachers, and students to manage and participate in online assessments.

The system provides a complete workflow for creating exams, managing questions, conducting timed assessments, automatic grading, and reviewing examination results.

---

## Features

### Authentication

- User registration
- Secure login system
- Session management
- Role-based access control

### Administrator

- Manage users
- Create teacher accounts
- Create administrator accounts
- View registered students

### Teacher

- Create exams
- Publish and unpublish exams
- Delete exams
- Search exams
- Add questions
- Edit questions
- Delete questions
- Assign marks
- View student results
- Review exam analytics

### Student

- Register an account
- Browse available exams
- Take timed examinations
- Receive instant results
- View examination history

### Examination Features

- Multiple-choice questions
- Automatic grading
- Countdown timer
- Auto submission when time expires
- Pass/fail evaluation
- Result tracking

---

## Technology Stack

### Backend

- PHP 8+
- MySQL

### Frontend

- HTML5
- CSS3
- Bootstrap 5
- JavaScript

### Development Environment

- XAMPP
- phpMyAdmin
- Visual Studio Code

---

## Project Structure

```text
online_exam_system/
├── admin/
├── teacher/
├── student/
├── includes/
├── assets/
├── database/
├── login.php
├── register.php
├── logout.php
└── index.php
```

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-username/online_exam_system.git
```

### 2. Move the project

Place the project inside:

```text
C:\xampp\htdocs\
```

### 3. Start Apache and MySQL

Open XAMPP and start:

- Apache
- MySQL

### 4. Create the database

```sql
CREATE DATABASE online_exam_system;
```

### 5. Import the SQL file

Import:

```text
database/online_exam_system.sql
```

using phpMyAdmin.

### 6. Configure database connection

Edit:

```php
includes/db.php
```

```php
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "online_exam_system"
);
```

### 7. Run the application

```text
http://localhost/online_exam_system
```

---

## Database Tables

- users
- exams
- questions
- options
- exam_attempts
- answers

---

## Current Features

- Role-based authentication
- Student registration
- Exam creation and management
- Question management
- Timed examinations
- Automatic grading
- Result analytics
- Examination history
- Bootstrap user interface

---

## Future Improvements

- PDF result export
- Certificate generation
- Exam scheduling
- Email notifications
- Student profiles
- Teacher profiles
- System settings panel
- REST API

---

## License

This project is intended for educational and learning purposes. You are free to modify and extend it according to your requirements.

---

## Author

Developed as a practical full-stack web application project using PHP, MySQL, Bootstrap, and JavaScript.
