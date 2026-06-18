# 🎓 Online Examination System

A modern web-based examination platform built with **PHP**, **MySQL**, **Bootstrap**, and **JavaScript** that enables administrators, teachers, and students to manage and participate in online assessments efficiently.

The system provides a complete examination workflow—from user management and exam creation to automatic grading and result analytics—through a simple and intuitive interface.

---

## 📌 Overview

The Online Examination System is designed to digitize the examination process in schools, colleges, universities, and training institutions.

The platform supports three user roles:

### 👨‍💼 Administrator
- Manage users
- Create teacher accounts
- Create administrator accounts
- Monitor system activities

### 👨‍🏫 Teacher
- Create and manage exams
- Add, edit, and delete questions
- Publish and unpublish exams
- View student performance analytics

### 👨‍🎓 Student
- Register and log in
- Take timed examinations
- View scores instantly
- Access examination history

---

## ✨ Features

### 🔐 Authentication & Authorization

- Secure Login System
- Student Registration
- Session Management
- Role-Based Access Control
- Protected Pages

---

### 👨‍💼 Administrator Features

- Dashboard Overview
- User Management
- Create Teacher Accounts
- Create Admin Accounts
- View Registered Students

---

### 👨‍🏫 Teacher Features

#### Exam Management

- Create Exams
- Search Exams
- Publish Exams
- Unpublish Exams
- Delete Exams
- Manage Exam Duration

#### Question Management

- Add Questions
- Edit Questions
- Delete Questions
- Assign Marks
- Configure Correct Answers

#### Analytics & Reporting

- View Student Results
- View Exam Attempts
- Calculate Pass Rate
- Calculate Average Scores
- Performance Monitoring

---

### 👨‍🎓 Student Features

#### Exam Portal

- Browse Available Exams
- Start Online Exams
- Answer Multiple Choice Questions
- Timed Examinations
- Automatic Submission

#### Results

- Instant Score Calculation
- Percentage Calculation
- Pass/Fail Evaluation
- Complete Examination History

---

## ⏱️ Exam Timer System

The examination system includes a built-in countdown timer.

### Features

- Real-time countdown
- Automatic submission when time expires
- Warning indicators as time decreases
- Prevents students from exceeding allocated exam duration

---

## 📊 Analytics Dashboard

Teachers can monitor:

- Total Attempts
- Average Scores
- Pass Rate
- Student Performance
- Exam Statistics

---

## 🛠️ Technology Stack

### Backend

- PHP 8+
- MySQL
- Apache

### Frontend

- HTML5
- CSS3
- Bootstrap 5
- JavaScript

### Development Tools

- XAMPP
- phpMyAdmin
- Visual Studio Code

---

## 📁 Project Structure

```text
online_exam_system/
│
├── admin/
│   ├── dashboard.php
│   └── users.php
│
├── teacher/
│   ├── dashboard.php
│   ├── exams.php
│   ├── create_exam.php
│   ├── questions.php
│   ├── edit_question.php
│   ├── delete_question.php
│   ├── publish_exam.php
│   ├── unpublish_exam.php
│   ├── delete_exam.php
│   └── results.php
│
├── student/
│   ├── dashboard.php
│   ├── exams.php
│   ├── take_exam.php
│   ├── result.php
│   └── results.php
│
├── includes/
│   ├── auth.php
│   ├── db.php
│   ├── header.php
│   └── footer.php
│
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   └── images/
│
├── database/
│   └── online_exam_system.sql
│
├── login.php
├── register.php
├── logout.php
├── index.php
│
└── README.md
```

---

## 🗄️ Database Design

### users

Stores all user accounts.

| Column | Description |
|----------|-------------|
| id | User ID |
| fullname | Full Name |
| email | Email Address |
| password | User Password |
| role | admin, teacher, student |

---

### exams

Stores exam information.

| Column | Description |
|----------|-------------|
| id | Exam ID |
| teacher_id | Exam Owner |
| title | Exam Title |
| description | Exam Description |
| duration | Duration (Minutes) |
| status | Draft / Published |

---

### questions

Stores examination questions.

| Column | Description |
|----------|-------------|
| id | Question ID |
| exam_id | Related Exam |
| question_text | Question Content |
| marks | Question Marks |

---

### options

Stores multiple-choice options.

| Column | Description |
|----------|-------------|
| id | Option ID |
| question_id | Related Question |
| option_text | Option Content |
| is_correct | Correct Option Flag |

---

### exam_attempts

Stores submitted examinations.

| Column | Description |
|----------|-------------|
| id | Attempt ID |
| exam_id | Related Exam |
| student_id | Student |
| score | Obtained Score |
| total_marks | Total Marks |
| submitted_at | Submission Date |

---

### answers

Stores selected answers.

| Column | Description |
|----------|-------------|
| id | Answer ID |
| attempt_id | Related Attempt |
| question_id | Question |
| selected_option_id | Selected Answer |

---

## 🚀 Installation Guide

### Step 1: Clone Repository

```bash
git clone https://github.com/your-username/online_exam_system.git
```

or download the ZIP file.

---

### Step 2: Move Project

Place the project inside:

```text
C:\xampp\htdocs\
```

Example:

```text
C:\xampp\htdocs\online_exam_system
```

---

### Step 3: Start XAMPP

Start:

- Apache
- MySQL

---

### Step 4: Create Database

Open:

```text
http://localhost/phpmyadmin
```

Create a new database:

```sql
CREATE DATABASE online_exam_system;
```

---

### Step 5: Import Database

Import:

```text
database/online_exam_system.sql
```

into phpMyAdmin.

---

### Step 6: Configure Database Connection

Edit:

```php
includes/db.php
```

```php
<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "online_exam_system"
);

if(!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}
```

---

### Step 7: Launch Application

Open:

```text
http://localhost/online_exam_system
```

---

## 🔒 Security Features

Current security measures include:

- Session Authentication
- Role-Based Authorization
- Protected Dashboards
- Exam Ownership Verification
- Anti-Retake Protection
- Automatic Exam Submission

---

## 📈 Future Improvements

Planned enhancements:

- PDF Result Export
- Certificate Generation
- Question Categories
- Student Profiles
- Teacher Profiles
- System Settings
- Exam Scheduling
- Email Notifications
- Dark Mode
- REST API
- Mobile Application

---

## 🎯 Educational Applications

This project can be used in:

- Schools
- Colleges
- Universities
- Professional Training Centers
- Certification Programs
- Learning Management Systems (LMS)

---

## 🤝 Contributing

Contributions, feature suggestions, and improvements are welcome.

1. Fork the repository
2. Create a new branch
3. Commit your changes
4. Submit a pull request

---

## 📄 License

This project is released for educational and learning purposes.

You are free to modify, improve, and extend the system to suit your institution or project requirements.

---

## 👨‍💻 Author

Developed as a full-stack PHP web application project demonstrating:

- Authentication Systems
- Role-Based Access Control
- Database Design
- Online Examination Workflows
- Automated Grading
- Analytics & Reporting
- Modern Bootstrap User Interfaces

---

### ⭐ If you find this project useful, consider giving it a star on GitHub.
