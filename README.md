# Laravel Developer Recruitment Assessment Project #
This project combines Laravel 11 as the backend framework with Vue.js for the frontend. Follow the instructions to set up and run the project.

## Prerequisites ##
- PHP >= 8.2
- Composer
- MySql Database

## How to Install and Run the Project
1. Clone the repository:

   ```bash
   git clone https://github.com/s-ahmed007/interactive-inventory-management.git
   
2. Install dependencies:

   ```bash
   composer install

3. Copy .env from .env.example:

   ```bash
   cp .env.example .env

4. Generate key:

   ```bash
   php artisan key:generate

5. Configure Database in your .env:
    ```
    DB_CONNECTION=mysql
    DB_HOST=db_host
    DB_PORT=db_port
    DB_DATABASE=db_name
    DB_USERNAME=db_user_name
    DB_PASSWORD=db_password
   ```
   
6. Run migration and seed
    ```bash
   php artisan migrate --seed
    ```
   This command will create the database table and a user.

7. Run the application
    ```bash
   php artisan serve
   ```

8. To access the application open your browser and visit this url http://127.0.0.1:8000 or desired port show in your terminal

9. The application login page will show. Log in to the application with below credentials
   - Email
     ```
     john@gmail.com
     ```
   - Password
     ```
     password
     ```
