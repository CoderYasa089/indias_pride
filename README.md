# India's Pride

A dynamic, full-stack restaurant management and food ordering website designed to handle reservations, showcase menus, and track order statuses.

## Technologies Used
* **Frontend:** HTML5, CSS3, JavaScript
* **Backend:** PHP
* **Database:** MySQL

## Key Features
* **Interactive Menu:** Displays available dishes with high-quality imagery dynamically loaded from the database.
* **Table Reservations:** A streamlined booking system allowing users to reserve tables in advance.
* **Order Tracking:** Enables customers to check the real-time status of their food orders.
* **Contact & Information:** User inquiry forms and restaurant background, including chef profiles.
* **Modular Architecture:** Centralized database connection handling for secure and scalable code.

## Project Structure
* `/database` - Contains `indias_pride_db.sql`, the database schema and mock data required to run the application.
* `/images` - UI assets and food photography used across the site.
* `/*.php` - Core logic and frontend views.

## Local Setup Instructions

To run this project locally, a local server environment such as XAMPP or WAMP is required.

1. **Clone the repository:**
    git clone https://github.com/yourusername/indias_pride.git

2. **Move to local server:**
    Place the cloned `indias_pride` folder into your `C:/xampp/htdocs/` directory (or the equivalent `www` folder if using WAMP).

3. **Database Configuration:**
    * Open the XAMPP Control Panel and start **Apache** and **MySQL**.
    * Navigate to `http://localhost/phpmyadmin` in your web browser.
    * Create a new database named `indias_pride_db`.
    * Click on the **Import** tab and upload the `database/indias_pride_db.sql` file provided in this repository.

4. **Launch the application:**
    * Open your web browser and navigate to `http://localhost/indias_pride/index.php`.
