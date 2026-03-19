# Car Rental Agency Web App

A simple car rental web application built with core PHP, MySQL, HTML, CSS, JavaScript, and Bootstrap.

## Features

- Separate registration pages for customers and car rental agencies
- Shared login page for both user types
- Agency-only add car and edit car functionality
- Public page to browse all available cars
- Customer-only car booking flow
- Agency view to check bookings, including bookings for a particular car
- MySQL SQL file included for database setup

## Tech Stack

- Frontend: HTML, CSS, JavaScript, Bootstrap
- Backend: Core PHP
- Database: MySQL

## Project Structure

- `pages/` - application pages
- `includes/` - shared helper functions
- `css/` - styles
- `js/` - scripts
- `car_rental.sql` - database schema and sample data

## Setup Instructions

1. Copy the project into your web server folder, for example `C:\xampp\htdocs\car-rental-app`
2. Start Apache and MySQL from XAMPP
3. Open phpMyAdmin or MySQL
4. Import the file `car_rental.sql`
5. Open the project in the browser:

```text
http://localhost/car-rental-app/
```

## Sample Login Accounts

These sample accounts are included in `car_rental.sql`:

- Agency
  - Email: `agency@example.com`
  - Password: `password123`
- Customer
  - Email: `customer@example.com`
  - Password: `password123`

## Main Pages

- `pages/register.php` - choose registration type
- `pages/register_customer.php` - customer registration
- `pages/register_agency.php` - agency registration
- `pages/login.php` - login
- `pages/view_cars.php` - available cars page
- `pages/add_car.php` - add new car
- `pages/edit_car.php` - edit car
- `pages/view_my_cars.php` - agency car list
- `pages/bookings.php` - agency bookings page
- `pages/my_bookings.php` - customer bookings page

## Notes

- Only agencies can add or edit cars.
- Only customers can book cars.
- The available cars page is accessible even without login.
- If a logged-out user tries to rent a car, they are directed to login.

