# Clinic Management System (PHP & MySQL)

A full-stack **Clinic Management System** developed using **PHP, MySQL, HTML, CSS, JavaScript, and Bootstrap 5**.  
This application helps clinics manage patients, appointments, and clinic operations digitally instead of using physical registers.

The project includes separate dashboards for **Admin**, **Doctor**, and **Patient**, and is fully responsive for desktop and mobile devices.

---

## 🔹 Project Overview

This system is designed for **small to medium-sized clinics** to streamline daily operations such as:
- Patient registration and verification
- Online appointment booking
- Appointment management
- Clinic and service management

The project can be run **locally** (XAMPP/WAMP) and can also be **hosted online for free** on PHP-supported hosting platforms.

---

## 🚀 Features

### 👩‍⚕️ Doctor Module
- Doctor dashboard overview
- View total patients
- View today’s appointments
- View upcoming appointments
- Manage clinic details
- Manage services
- Responsive sidebar and mobile navigation

### 🧑‍🦱 Patient Module
- Patient registration and login
- Email / OTP-based verification
- Online appointment booking
- View appointment status
- Profile management

### 🛠️ Admin Module
- View and manage patients
- Verify / reject patients
- Manage appointments
- Manage clinic information and services

---

## 🧰 Tech Stack

- **Frontend:** HTML, CSS, JavaScript, Bootstrap 5
- **Backend:** Core PHP
- **Database:** MySQL (phpMyAdmin)
- **Server:** Apache (XAMPP / WAMP / Live Hosting)

---

## 📁 Folder Structure (MANDATORY)

⚠️ The following folder structure is **required** for the project to work correctly.  
Do **not rename or rearrange folders**, as PHP includes and URL paths depend on this structure.

CMS-NEW/
├── admin/ # Admin dashboard files
│
├── doctor/ # Doctor dashboard
│ ├── includes/
│ │ ├── header.php
│ │ ├── sidebar.php
│ │ └── functions.php
│ ├── index.php
│ ├── clinic-details.php
│ ├── add-services.php
│ └── total-appointments.php
│
├── includes/ # Shared application logic
│ ├── patient/ # Patient dashboard files
│ ├── db_connect.php # Database connection (NOT committed)
│ └── db_connect.example.php # Database config template
│
├── phpmailer/ # Email / OTP functionality
│
├── uploads/ # User uploads (ignored by Git)
│
├── cms_db.sql # Database schema (MANDATORY)
│
├── index.php # Landing page
├── patient-login.php # Patient login
├── verify-message.php # OTP / verification handling
│
├── README.md # Project documentation
└── .gitignore # Git ignore rules


### ❗ Important Notes
- `cms_db.sql` **must be in the project root**
- `db_connect.php` must exist locally but is **ignored by Git**
- `uploads/` folder must exist (even if empty)
- Folder names are **case-sensitive on hosting servers**

---

## 🗄️ Database Information

- **Database Name:** `cms_db`
- **Database File:** `cms_db.sql`

The SQL file includes all required tables such as:
- Patients
- Appointments
- Clinic details
- Services
- Admin and verification data

---

## ⚙️ Local Installation & Setup

### 1️⃣ Clone or Download the Project

```bash
git clone https://github.com/YOUR_USERNAME/clinic-management-system.git
