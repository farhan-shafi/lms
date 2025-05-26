# EduLearn LMS - Learning Management System

A comprehensive Learning Management System built with CodeIgniter, featuring courses, quizzes, certificates, student/instructor dashboards, and more.

## Documentation

- [Installation Guide](INSTALLATION.md) - Complete setup instructions
- [Database Schema](DATABASE_SCHEMA.md) - Detailed database structure reference
- [Database Quick-Start](DB_QUICKSTART.md) - Quick guide for importing the database

## Database Setup Instructions

### Prerequisites

- XAMPP, WAMP, MAMP, or similar local development environment
- MySQL/MariaDB database server
- Apache web server
- PHP 7.4 or higher

### Setting up the Database

1. **Start your local server environment**

   - Start Apache and MySQL services in your XAMPP/WAMP/MAMP control panel

2. **Access phpMyAdmin**

   - Open your browser and navigate to `http://localhost/phpmyadmin`
   - Log in with your database credentials (default XAMPP credentials are username: `root`, password: ``)

3. **Create the database**

   - You can create the database manually:
     - Click on "New" in the left sidebar
     - Enter `lms_db` as the database name
     - Select `utf8mb4_general_ci` as the collation
     - Click "Create"

   OR

   - **Import the entire SQL file directly**:
     - Click on the "Import" tab in phpMyAdmin
     - Click "Choose File" and select the `lms_db.sql` file from the project root directory
     - Click "Go" at the bottom of the page to import the database

4. **Alternative: Using the command line**

   ```bash
   # Navigate to your MySQL bin directory (if not in PATH)
   cd /Applications/XAMPP/xamppfiles/bin

   # Import the database
   ./mysql -u root -p < /Applications/XAMPP/xamppfiles/htdocs/lms/lms_db.sql
   ```

### Database Structure

The LMS database includes the following main tables:

1. **users** - Stores all user information (admin, instructors, students)
2. **categories** - Course categories
3. **courses** - All course information
4. **modules** - Course modules/sections
5. **lessons** - Individual lessons within modules (video, text, etc.)
6. **quizzes** - Quizzes attached to modules
7. **quiz_questions** - Questions within quizzes
8. **quiz_answers** - Answer options for questions
9. **enrollments** - Student enrollment in courses
10. **progress_tracking** - Tracks student progress through lessons and quizzes
11. **quiz_attempts** - Records of student quiz attempts
12. **quiz_responses** - Student responses to quiz questions
13. **course_reviews** - Student reviews of courses
14. **discussions** - Course discussion threads
15. **discussion_replies** - Replies to discussion threads
16. **announcements** - Course announcements
17. **certificates** - Completion certificates
18. **settings** - System settings

### Default Credentials

After importing the database, you can log in with the following default admin credentials:

- **Email**: admin@lms.com
- **Password**: admin123

_Note: It is strongly recommended to change the default admin password after first login._

### Database Configuration in CodeIgniter

The database configuration file is located at `application/config/database.php`. Make sure it has the correct settings:

```php
$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost',
    'username' => 'root',     // your database username
    'password' => '',         // your database password
    'database' => 'lms_db',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
```

## Key Features

- User roles: Admin, Instructor, Student
- Course management with modules and lessons
- Multiple lesson types: video, text, document, audio, external link
- Quiz system with various question types
- Student progress tracking
- Course discussions and announcements
- Certificate generation
- Student enrollments and course reviews
- Responsive design for all devices
- Dark mode support

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For any questions or issues related to database setup, please contact support at info@edulearn.com
