# Laravel Auth Blade Starter

A ready-to-use Laravel 12 project with a complete **Authentication system** (Register, Login, Logout) built using **Blade** and **Bootstrap 5**.  
This project is designed to be a quick starting point for new Laravel applications without the need to set up authentication from scratch.

---

## 🚀 Features
- Laravel **12.x**
- Native Authentication (**no Breeze or Jetstream**)
- Blade Templates with **Bootstrap 5**
- User **Registration**, **Login**, and **Logout**
- MySQL database with a pre-configured **users** table
- Validation rules and error messages included
- Clean and extendable structure for quick development

---

## 📦 Installation

### Steps
1. Clone the repository  
2. Navigate into the project  
3. Install dependencies with composer  
4. Copy `.env.example` to `.env`  
5. Generate application key  
6. Set up database credentials in `.env` and run migrations  
7. Start the server  

### Commands
```bash
git clone https://github.com/AbdulbasetRS/Laravel-Auth-Blade-Starter.git
cd Laravel-Auth-Blade-Starter
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```
