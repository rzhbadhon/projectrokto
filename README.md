# 🩸 ROKTO – Emergency Blood Donation Platform

**Rokto** (which means "Blood" in Bengali) is a simple, user-friendly blood donation platform made using PHP, HTML, CSS, and MySQL (XAMPP). It allows users to **search for fresh blood by group and area**, and lets willing donors **register themselves** to help in emergencies.

---

## 🚀 Features

- ✅ Donor Registration (with name, age, blood group, phone, area)
- ✅ Search for blood by **type and area**
- ✅ Optional user (seeker) registration and login
- ✅ Logs every search request (even anonymous)
- ✅ Modern responsive UI with gradient and soft layout
- ✅ Database created with MySQL and schema uploaded

---

## 🛠 Technologies Used

| Part       | Tech           |
|------------|----------------|
| Frontend   | HTML, CSS      |
| Backend    | PHP            |
| Database   | MySQL (via XAMPP) |
| Tooling    | VS Code, phpMyAdmin |
| Hosting    | Localhost (XAMPP) |

---

## 📦 Folder Contents

- `index.html` – Homepage with options for donor or seeker
- `donor.php` – Donor registration form with PHP validation
- `search.php` – Seeker search form and result display
- `register.php` – Optional seeker registration
- `login.php` – Optional seeker login
- `schema.sql` – SQL file to create database and tables

---

## 📥 How to Run This Project

1. Import `schema.sql` into your phpMyAdmin (XAMPP) to create database and tables.
2. Copy all project files into your `C:/xampp/htdocs/projectrokto` folder.
3. Open XAMPP and start **Apache** and **MySQL**.
4. Visit `http://localhost/projectrokto/` in your browser.

---

## 📝 Update Log

- 📅 May 26, 2025: Upgraded project with:
  - Seeker registration & login (optional)
  - `requests` table to track blood search activity
  - UI improvements and mobile-friendly layout
  - SQL queries for registration, search, logging

---

## 🧠 Project Vision

Rokto was made for **real-time emergency blood connection**, not for frozen/stored blood. It helps people quickly find **available, live donors** nearby in times of need.

---

## 👤 Author

Created by [@rzhbadhon](https://github.com/rzhbadhon) as a student project for learning backend development and database management.

---

## 📌 Note

This is a **student-level academic project** made for educational purpose. It can be improved further with:
- Admin panel
- Email/SMS alerts
- Location-based search map
- Donor availability calendar

