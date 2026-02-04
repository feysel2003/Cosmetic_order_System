# Cosmetic_order_System

## 🛠 Tech Stack

Backend: PHP  
Database: MySQL  
Frontend: HTML, CSS, JavaScript  
Web Server: Apache (XAMPP / WAMP)  
Email Service: PHPMailer  

## 📌 About

Cosmetic_order_System is a **PHP & MySQL based online cosmetic ordering system**.  
It allows customers to register, browse cosmetic products, search items, and place orders.  
Brand users (sellers) can manage cosmetics, orders, and customer messages through a dedicated dashboard.

## 🗄 Database

Create a MySQL database (for example: `cosmetic_order_db`) and import the SQL file provided in the project (if available).

### Common Tables Used

users (id, name, email, password, role)

brands (id, name, contact, logo)

categories (id, name)

cosmetics (id, category_id, brand_id, name, price, stock, image)

orders (id, customer_id, brand_id, order_date, status)

messages (id, sender_id, receiver_id, message, date)

## ⚙ Installation & Setup

### Prerequisites

PHP 7.x or higher

MySQL Server (XAMPP / WAMP recommended)

Apache Web Server

Web Browser

### Steps

#### Clone the Repository

git clone https://github.com/feysel2003/Cosmetic_order_System.git

#### Move Project to Server Folder

XAMPP → htdocs  
WAMP → www  

#### Database Setup

Open phpMyAdmin.

Create a database named cosmetic_order_db.

Import the SQL file (if included in the project).

Update database connection details in the PHP config/connection file.

#### Run the Project

Start Apache and MySQL.

Open your browser and visit:

http://localhost/Cosmetic_order_System/

## 🔑 Usage

### Customer

Register a new account

Login

Browse cosmetic products

Search cosmetics

Place orders

View order history

### Brand (Seller)

Brand registration & login

Manage cosmetic products

Upload product images

View and update orders

Respond to customer messages

## 📸 Screenshots

(Optional: Add screenshots of Home Page, Login Page, Product List, Brand Dashboard, and Order Page)

## 🤝 Contributing

Fork the project.

Create your feature branch (git checkout -b feature/AmazingFeature).

Commit your changes (git commit -m 'Add some AmazingFeature').

Push to the branch (git push origin feature/AmazingFeature).

Open a Pull Request.

## 📜 License

This project is for educational purposes only.
