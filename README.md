<img src="janakpurdham-logo.png" alt="Janakpurdham Logo" width="150" />

# eSifaris Project

A citizen recommendation and document management system for local government offices, built with PHP, HTML, CSS, and MySQL.

## Features

- Citizen registration and login
- Admin login and dashboard
- Application form for various certificates (birth, death, citizenship, marriage, poverty, etc.)
- File uploads for documents and citizenship images
- Admin dashboard with quick stats (total, pending, approved, rejected)
- Admin can view, approve, or reject applications
- Application status tracking
- Complaint submission
- Responsive and modern UI for both admin and citizen dashboards

---

## Setup Guide

### Prerequisites

- Windows OS (recommended)
- XAMPP installed ([Download here](https://www.apachefriends.org/index.html))

### Steps

#### 1. Install XAMPP

- Download and install XAMPP from the official website.
- Start Apache and MySQL from the XAMPP Control Panel.

#### 2. Place Project in `htdocs`

- Copy the entire `esifarish` project folder into `C:/xampp/htdocs/`.
- The main project path should be: `C:/xampp/htdocs/esifarish`

#### 3. Create the Database and Tables

- Open `phpMyAdmin` (usually at [http://localhost/phpmyadmin](http://localhost/phpmyadmin)).
- Create a new database, e.g., `esifarish`.
- Import the SQL schema:
  - Click the database name.
  - Go to the `Import` tab.
  - Select `backend/schema.sql` from your project folder and import.

#### 4. Configure Database Connection

- By default, the project uses `db.php` for database connection.
- Ensure your MySQL username and password in `db.php` match your XAMPP setup (default is `root` with no password).

#### 5. Create the First Admin

In your browser, go to: [http://localhost/esifarish/backend/first_admin.php](http://localhost/esifarish/backend/first_admin.php)
This will create the first admin user with the following credentials:

- Username: `first admin`
- Phone: `12345678`
- Password: `qwerty`

You can now log in as admin and create more admins using the "New Admin" option in the dashboard.

#### 6. Run the Project

- Access the project at [http://localhost/esifarish/](http://localhost/esifarish/)
- Citizens can register, apply for certificates, and track status.
- Admins can log in, view applications, approve/reject, and upload documents for applicants.

#### 7. Uploads and Documents

- Uploaded files are stored in the `uploads` folder.
- Admins can upload documents for each application; applicants can download them from their history page.

#### 8. Troubleshooting

- If you see database errors, check your `db.php` credentials and ensure the database/tables exist.
- Make sure Apache and MySQL are running in XAMPP.
- For file upload issues, ensure the `uploads` folder is writable.

---

## Folder Structure

```
├── backend/
│   ├── admin_login.php
│   ├── applications.php
│   ├── applications_stats.php
│   ├── application_details.php
│   ├── db.php
│   ├── logout.php
│   ├── register.php
│   ├── schema.sql
│   ├── submit.php
│   ├── update_application_status.php
│   ├── first_admin.php
│   ├── new_admin.php
│   ├── upload_document.php
├── admin-dashboard.php
├── admin-login.html
├── apply.html
├── citizen-login.html
├── nagrikdashboard.php
├── success.html
├── style.css
└── ...other HTML and asset files
```

## Usage

- Citizens can log in, apply for certificates, upload documents, and track status.
- Admins can log in, view all applications, approve/reject, and see dashboard stats.

## Notes

- Always run `first_admin.php` once after setup to create the initial admin.
- For security, change the default admin password after first login.
- You can create more admins using the "New Admin" feature in the dashboard.

---

## License

MIT
