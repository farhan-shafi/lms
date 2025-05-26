# EduLearn LMS Installation Guide

This guide will walk you through the process of setting up the EduLearn Learning Management System on your local development environment.

## System Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher / MariaDB 10.2 or higher
- Apache with mod_rewrite enabled
- XAMPP, WAMP, MAMP, or similar local development stack
- Composer (for dependency management)
- Git (optional, for version control)

## Installation Steps

### 1. Set Up Local Development Environment

If you don't already have a local development environment:

- Download and install [XAMPP](https://www.apachefriends.org/index.html) (cross-platform)
- Start Apache and MySQL services from the XAMPP Control Panel

### 2. Clone or Download the Repository

#### Option 1: Using Git

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/
git clone https://github.com/yourusername/edulearn-lms.git lms
cd lms
```

#### Option 2: Manual Download

- Download the ZIP file from the repository
- Extract it to your `/Applications/XAMPP/xamppfiles/htdocs/lms` directory

### 3. Database Setup

#### Option 1: Using phpMyAdmin

1. Open your browser and navigate to `http://localhost/phpmyadmin`
2. Create a new database named `lms_db` with collation `utf8mb4_general_ci`
3. Import the database by selecting the `lms_db.sql` file from the project root

#### Option 2: Using Command Line

```bash
# Navigate to MySQL bin directory if needed
cd /Applications/XAMPP/xamppfiles/bin

# Import the database
./mysql -u root -p < /Applications/XAMPP/xamppfiles/htdocs/lms/lms_db.sql
```

### 4. Configure Database Connection

1. Open the file `application/config/database.php`
2. Update the database configuration:

```php
$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost',
    'username' => 'root',          // Change if your DB username is different
    'password' => '',              // Change if your DB password is different
    'database' => 'lms_db',
    'dbdriver' => 'mysqli',
    // ... other settings remain unchanged
);
```

### 5. Configure Base URL

1. Open the file `application/config/config.php`
2. Set the base URL:

```php
$config['base_url'] = 'http://localhost/lms/';
```

### 6. File Permissions

Ensure these directories have write permissions:

```bash
chmod -R 755 application/cache/
chmod -R 755 application/logs/
chmod -R 755 assets/uploads/
```

### 7. Install Dependencies (if using Composer)

```bash
composer install
```

### 8. Access the Application

- Open your browser and navigate to `http://localhost/lms/`
- You should see the EduLearn LMS homepage

### 9. Log In with Default Admin Account

- **Email**: admin@lms.com
- **Password**: admin123

## Post-Installation Steps

1. **Change the default admin password**

   - After logging in, go to Admin > Profile
   - Update the password to something secure

2. **Configure system settings**

   - Go to Admin > Settings
   - Update site name, email, and other settings

3. **Create categories and courses**
   - Start by creating categories
   - Then add courses, modules, and lessons

## Troubleshooting

### Common Issues

1. **White Screen / 500 Error**

   - Check PHP error logs: `/Applications/XAMPP/xamppfiles/logs/php_error_log`
   - Ensure PHP version meets requirements
   - Check file permissions

2. **Database Connection Issues**

   - Verify database credentials
   - Ensure MySQL service is running
   - Check if database exists and is properly imported

3. **Missing .htaccess Functionality**

   - Ensure Apache mod_rewrite is enabled
   - Check .htaccess file exists in root directory

4. **File Upload Issues**
   - Check PHP upload_max_filesize and post_max_size in php.ini
   - Verify upload directory permissions

## Development Guidelines

### CSS Customization

All CSS styles are organized in the following files:

- `assets/css/lms-style.css` - Main styles
- `assets/css/additional-styles.css` - Enhanced elements
- `assets/css/ui-components.css` - UI components
- `assets/css/animations.css` - Animations and transitions
- `assets/css/responsive.css` - Mobile responsiveness

### JavaScript Files

Key JavaScript files:

- `assets/js/ui-interactions.js` - UI interactions
- `assets/js/course-learning.js` - Course learning experience
- `assets/js/theme-customizer.js` - Theme customization

### Adding New Features

Follow the MVC pattern of CodeIgniter:

1. Create/modify models in `application/models/`
2. Create/modify controllers in `application/controllers/`
3. Create/modify views in `application/views/`

## Need Help?

- Check the [Documentation](docs/index.html)
- Visit our [GitHub repository](https://github.com/yourusername/edulearn-lms)
- Contact support at info@edulearn.com
