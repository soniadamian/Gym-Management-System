# Gym-Management-System
A web-based gym management platform developed using PHP, SQL and HTML, enabling administration of members, classes, trainers, and subscriptions through a structured relational database system.

# Gym Management System

A web-based gym management platform developed using **PHP, MySQL, and HTML/CSS**, enabling administration of members, classes, trainers, and subscriptions through a structured relational database system with role-based access control.

---

## Project Overview

The Gym Management System is a database-driven web application designed to streamline gym operations.  
It provides a centralized platform for managing:

- Members
- Staff/Admin users
- Trainers
- Classes
- Subscriptions
- Class bookings

The system supports secure authentication, role-based access control, and full CRUD functionality across all major entities.

---


---

##  Database Design

The system is built on a structured relational database including the following core tables:

### Users
Internal system operators (Admin / Staff)

Fields:
- id
- username
- password (hashed)
- role

---

### Members
Gym clients

Fields:
- id
- first_name
- last_name
- email
- password (hashed)
- phone
- date of birth
- gender

---

### Classes
Gym training sessions

Fields:
- id
- class_name
- description
- trainer_id
- schedule_time
- duration_minutes
- capacity

---

### Subscriptions

Fields:
- id
- member_id
- plan_name
- start_date
- end_date
- price
- status

---

### Class Bookings

Fields:
- id
- class_id
- member_id
- booking_time

---

### Trainers

Fields:
- id
- user_id
- full_name
- speciality
- phone
- hire_date

---

## Authentication & Security

- Session-based authentication
- Password hashing using `password_hash()`
- Password verification using `password_verify()`
- Role-based redirection (Admin / Member)
- Prepared statements (PDO) to prevent SQL injection

---

##  Core Functionalities

### Admin / Staff
- Add, edit, delete members
- Manage classes
- Manage subscriptions
- View system dashboard

### Members
- Login securely
- View personal data
- View subscriptions
- Book classes

---

##  Technologies Used

**Backend**
- PHP (PDO)

**Database**
- MySQL

**Frontend**
- HTML
- CSS

**Security Concepts**
- Role-Based Access Control (RBAC)
- Password hashing (bcrypt)
- Session management
- Prepared SQL statements

---

