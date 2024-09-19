# Job Posting Interface

This is a minimalistic interface for job postings, developed as a test task for a Koba company. The project was designed to be completed within two days, with encouragement for additional enhancements

# Job Posting Interface Task

## Task Description

"You are required to create a minimalistic interface for job postings. This is a test task for our company to evaluate your coding skills and creativity within a limited timeframe. The core functionality must be completed within two days, with any additional features being optional but encouraged"

### Core Requirements
   - Ability to post job offers
   - Users should be able to view details of job offers
   - Users can respond to job offers
   - Profiles should contain relevant user information

### Optional Enhancements

While the core functionality is expected to be completed within two days, additional enhancements such as file uploading, history tracking, and other innovative features are welcomed and will be considered a plus

## Setup Instructions

To set up the environment and start the project, follow these steps:

1. Clone the repository
2. Navigate to the project directory
3. Run setup commands:
    ```bash
    npm install
    composer install
    npm run build
    ```
4. Configure your `.env` file to connect to the database
5. Execute the database migrations and seeding:
    ```bash
    php artisan migrate
    php artisan db:seed --class=RoleSeeder
    ```
6. Additional setup commands:
    ```bash
    composer update
    php artisan storage:link
    php artisan serve
    ```
7. Access the project at `localhost:8000` or the configured port

## Recommended Environment

- **PHP Version**: 8.1 or higher is recommended for compatibility with Laravel 9.

This test is designed to gauge both the foundational implementation of a simple application and the potential for scaling with additional features. We look forward to seeing your innovative approaches and how you manage time and project constraints

