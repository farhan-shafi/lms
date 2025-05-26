# LMS Database Quick-Start Guide

This guide provides quick instructions for importing the `lms_db.sql` file into your MySQL database.

## Option 1: Using phpMyAdmin (Recommended for beginners)

1. **Start your local server environment**

   - Start XAMPP, WAMP, or MAMP control panel
   - Ensure both Apache and MySQL services are running

2. **Open phpMyAdmin**

   - Go to `http://localhost/phpmyadmin` in your browser
   - Log in if required (default XAMPP username: `root`, password: blank)

3. **Create database (if not automatically created by the script)**

   - Click "New" in the left sidebar
   - Enter database name: `lms_db`
   - Choose collation: `utf8mb4_general_ci`
   - Click "Create"

4. **Import the SQL file**
   - Select the `lms_db` database from the left sidebar
   - Click the "Import" tab at the top
   - Click "Choose File" and select the `lms_db.sql` file
   - Scroll down and click "Go"
   - Wait for the import to complete

## Option 2: Using Command Line

### For macOS/Linux:

```bash
# Navigate to MySQL bin directory (if MySQL is not in PATH)
cd /Applications/XAMPP/xamppfiles/bin

# Log in to MySQL
./mysql -u root -p

# Within the MySQL prompt, create the database
CREATE DATABASE IF NOT EXISTS lms_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
EXIT;

# Import the SQL file
./mysql -u root -p lms_db < /Applications/XAMPP/xamppfiles/htdocs/lms/lms_db.sql
```

### For Windows:

```bash
# Navigate to MySQL bin directory
cd C:\xampp\mysql\bin

# Log in to MySQL
mysql -u root -p

# Within the MySQL prompt, create the database
CREATE DATABASE IF NOT EXISTS lms_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
EXIT;

# Import the SQL file
mysql -u root -p lms_db < C:\xampp\htdocs\lms\lms_db.sql
```

## Verification

To verify the database was imported correctly:

1. Open phpMyAdmin
2. Select the `lms_db` database
3. You should see tables including `users`, `courses`, `modules`, etc.
4. Check the `users` table to confirm it contains the admin user

## Default Login Credentials

After successfully importing the database, you can log in with:

- **URL**: http://localhost/lms/
- **Email**: admin@lms.com
- **Password**: admin123

## Troubleshooting

- **Import Timeout**: If phpMyAdmin times out during import, try using the command line method or increase PHP timeout limits in `php.ini`
- **Access Denied**: Ensure your MySQL credentials are correct
- **Database Already Exists**: If you get an error about the database already existing, you can either drop it first or use the `-f` flag with the command line to force import

## Next Steps

After importing the database:

1. Configure your CodeIgniter database settings in `application/config/database.php`
2. Start building your courses and content
3. Customize the LMS appearance using the theme settings

For complete installation instructions, see the [INSTALLATION.md](INSTALLATION.md) file.
