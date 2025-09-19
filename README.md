# Laravel Auth Blade Starter

A ready-to-use Laravel 12 project with a complete **Authentication system** (Register, Login, Logout) built using **Blade** and **Bootstrap 5**.  
This project is designed to be a quick starting point for new Laravel applications without the need to set up authentication from scratch.

---

## Features
- Laravel **12.x**
- Native Authentication (**no Breeze or Jetstream**)
- Blade Templates with **Bootstrap 5**
- User **Registration**, **Login**, and **Logout**
- MySQL database with a pre-configured **users** table
- Validation rules and error messages included
- Clean and extendable structure for quick development
- Built-in localization using **mcamara/laravel-localization** (i18n-ready)

---

##  Installation

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

---

## Routes
| Method | URI                                  | Name                          | Description                          |
|--------|--------------------------------------|-------------------------------|--------------------------------------|
| GET    | /admin/login                         | admin.login                   | Show admin login form                |
| POST   | /admin/login                         | admin.login.submit            | Handle admin login form              |
| GET    | /admin/dashboard                     | admin.dashboard               | Admin dashboard                      |
| POST   | /admin/logout                        | admin.logout                  | Logout admin                         |
| GET    | /admin/forgot-password               | admin.password.request        | Show admin forgot password form      |
| POST   | /admin/forgot-password               | admin.password.email          | Send admin reset link via email      |
| GET    | /admin/reset-password/{token}        | admin.password.reset          | Show admin reset password form       |
| POST   | /admin/reset-password                | admin.password.update         | Handle admin reset password          |
| GET    | /admin/email/verify                  | admin.verification.notice     | Show admin email verification notice |
| GET    | /admin/email/verify/{id}/{hash}      | admin.verification.verify     | Verify admin email                   |
| POST   | /admin/email/verification-notification | admin.verification.send     | Resend admin verification link       |
| GET    | /admin/users                         | admin.users.index             | List all users                       |
| GET    | /admin/users/{id}                    | admin.users.show              | Show single user details             |
| GET    | /admin/users/create                  | admin.users.create            | Show create user form                |
| POST   | /admin/users                         | admin.users.store             | Save new user                        |
| GET    | /admin/users/{id}/edit               | admin.users.edit              | Show edit user form                  |
| PUT    | /admin/users/{id}                    | admin.users.update            | Update user                          |
| DELETE | /admin/users/{id}                    | admin.users.destroy           | Delete user                          |

---