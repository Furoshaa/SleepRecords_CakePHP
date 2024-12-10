# Sleep Tracking Application

## Overview
This web application helps users track and manage their sleep patterns. Users can record their sleep times, wake times, and monitor their sleep quality over time. The application provides insights into sleep habits and helps maintain a healthy sleep schedule.

## Features
- User registration and authentication
- Record sleep and wake times
- Track sleep duration
- View sleep history
- Basic sleep statistics

## Installation & Setup

### Prerequisites
- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer
- Git

### Installation Steps

1. Clone the repository
git clone [your-repository-url]
cd [project-directory]

2. Install dependencies
composer install

3. Configure your database
- Copy `config/.env.example` to `config/.env`
  (If .env.example doesn't exist, create a new file named `.env` in the config directory)
- Update the database configuration in `config/.env`:
export DATABASE_HOST="localhost"
export DATABASE_USER="your_username"
export DATABASE_PASS="your_password"
export DATABASE_NAME="sleep_tracker"

4. Set up the database
- Create a new MySQL database named 'sleep_tracker'
- Import the database structure from `config/schema/sleep_tracker.sql`
  (This file contains the initial database structure with the following tables:
  - users (id, email, password, firstname, lastname, created)
  - sleep_records (id, user_id, sleep_time, wake_time, quality, notes, created))

5. Start the development server
bin/cake server

The application should now be running at http://localhost:8765

## Project Structure and Key Components

### Controllers
- SleepRecordsController.php: 
  - Located in src/Controller/
  - Handles CRUD operations for sleep records
  - Manages sleep record validation
  - Processes sleep statistics

### Models
- SleepRecord.php:
  - Located in src/Model/Table/
  - Defines relationships and validation rules
  - Contains methods for calculating sleep metrics

### Templates
- templates/SleepRecords/:
  - index.php: Displays list of sleep records
  - add.php: Form for adding new sleep records
  - edit.php: Form for modifying existing records
  - view.php: Detailed view of a single record

### Database Schema
The application uses two main tables:
1. users
   - id: Primary key
   - email: User's email address
   - password: Hashed password
   - firstname: User's first name
   - lastname: User's last name
   - created: Account creation timestamp

2. sleep_records
   - id: Primary key
   - user_id: Foreign key to users table
   - sleep_time: When the user went to sleep
   - wake_time: When the user woke up
   - quality: Sleep quality rating
   - notes: Additional comments
   - created: Record creation timestamp

## Usage Guide

### Recording Sleep
1. Log in to your account
2. Click "Add Sleep Record" button
3. Enter your sleep time and wake time
4. Optionally add quality rating and notes
5. Submit the form

### Viewing Statistics
1. Navigate to the dashboard
2. View your sleep patterns in the graphs
3. Check weekly and monthly averages
4. Export data if needed

## Common Issues & Troubleshooting

### Database Connection Issues
- Verify database credentials in your `.env` file
- Make sure your `.env` file is properly loaded (check if debug messages show DATABASE_* variables are set)
- Ensure MySQL service is running
- Check if the database exists and is accessible

### Permission Issues
For Linux:
chmod -R 777 tmp/
chmod -R 777 logs/

For Windows:
- Right-click on the tmp/ and logs/ folders
- Properties -> Security -> Edit
- Give full control to the user running the web server
- Apply and OK

### Installation Problems
- Clear cache after configuration changes:
bin/cake cache clear_all

- If composer shows errors, try:
composer update --no-scripts
composer dump-autoload

### Common Runtime Errors
1. "Database connection failed"
   - Check credentials in .env file
   - Verify MySQL is running
   - Ensure database exists

2. "Permission denied"
   - Check file permissions
   - Verify web server user permissions

3. "Class not found"
   - Run composer dump-autoload
   - Clear CakePHP cache

## Development Guidelines

### Coding Standards
- Follow PSR-12 coding standards
- Use CakePHP coding conventions
- Document all methods and classes
- Write unit tests for new features

### Git Workflow
1. Create feature branch from main
2. Make changes and test
3. Submit pull request
4. Wait for review and approval

### Testing
Run tests using:
vendor/bin/phpunit

## Contributing
1. Fork the repository
2. Create your feature branch (git checkout -b feature/AmazingFeature)
3. Commit your changes (git commit -m 'Add some AmazingFeature')
4. Push to the branch (git push origin feature/AmazingFeature)
5. Open a Pull Request

## Security
- All passwords are hashed using bcrypt
- SQL injection prevention through ORM
- XSS protection via form helper
- CSRF protection enabled

## License
This project is licensed under the MIT License - see the LICENSE file for details.

## Support
For support, please:
1. Check the documentation
2. Search existing issues
3. Create a new issue if needed
4. Contact the maintainers

## Acknowledgments
- Built with CakePHP framework
- Uses Bootstrap for frontend
- Charts powered by Chart.js
