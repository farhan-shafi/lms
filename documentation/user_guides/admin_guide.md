# EduLearn LMS - Administrator Guide

Welcome to the EduLearn LMS Administrator Guide. This comprehensive document will help you effectively manage all aspects of the learning management system.

## Table of Contents

1. [Administrator Dashboard](#administrator-dashboard)
2. [User Management](#user-management)
3. [Course Management](#course-management)
4. [Category Management](#category-management)
5. [Payment and Financial Management](#payment-and-financial-management)
6. [System Settings](#system-settings)
7. [Content Moderation](#content-moderation)
8. [Reports and Analytics](#reports-and-analytics)
9. [System Maintenance](#system-maintenance)

## Administrator Dashboard

The administrator dashboard provides a comprehensive overview of the entire LMS platform.

### Dashboard Overview

![Admin Dashboard](../assets/images/documentation/admin-dashboard.png)

1. **Navigation Sidebar**: Access all administrative functions
2. **System Overview**: Key metrics including users, courses, and revenue
3. **Recent Activity**: Latest user registrations and course enrollments
4. **System Notifications**: Important alerts about system performance
5. **Quick Actions**: Frequently used administrative functions

### Navigation

The sidebar menu provides access to:

- **Dashboard**: Return to the main dashboard
- **Users**: Manage all platform users
- **Courses**: Oversee all courses
- **Categories**: Manage course categories
- **Announcements**: Create system-wide announcements
- **Discussions**: Monitor all platform discussions
- **Reviews**: Moderate course reviews
- **Certificates**: Manage certificate templates and issuance
- **Progress Reports**: View platform-wide learning progress
- **Payments**: Track all financial transactions
- **Settings**: Configure system settings

## User Management

### User Overview

1. Navigate to "Users" in the sidebar
2. View all users with filtering options:
   - Role (Student, Instructor, Admin)
   - Status (Active, Inactive, Pending)
   - Registration date
   - Last login

### Managing Users

#### Creating New Users

1. Click "Add User" button
2. Fill in the user details:
   - Name
   - Email
   - Password
   - Role
   - Status
3. Click "Create User"

#### Editing User Information

1. Click on a user's name to access their profile
2. Edit any information as needed
3. Click "Save Changes"

#### User Roles and Permissions

- **Student**: Can enroll in courses and access learning content
- **Instructor**: Can create and manage courses
- **Admin**: Has full system access and control

Change a user's role:

1. Go to the user's profile
2. Change the "Role" dropdown
3. Click "Save Changes"

#### Deactivating Users

1. Navigate to the user's profile
2. Change their status to "Inactive"
3. Click "Save Changes"

This prevents the user from logging in without deleting their account and data.

### Bulk User Actions

1. Select multiple users using the checkboxes
2. Use the "Bulk Actions" dropdown to:
   - Send email notifications
   - Change status
   - Export user data
   - Delete accounts (use with caution)

## Course Management

### Course Overview

1. Navigate to "Courses" in the sidebar
2. View all courses with filtering options:
   - Status (Published, Draft, Archived)
   - Category
   - Instructor
   - Creation date
   - Enrollment count

### Course Moderation

#### Reviewing New Courses

1. Filter courses by "Pending Review" status
2. Click on a course to review its content
3. Check for quality, appropriateness, and compliance with guidelines
4. Approve or reject the course with feedback

#### Featuring Courses

1. Navigate to a course's settings
2. Check "Feature this Course"
3. Set the featuring priority (1-10)
4. Click "Save Changes"

Featured courses appear on the homepage and in featured sections.

#### Managing Course Status

Change a course's status:

1. Go to the course details page
2. Use the status dropdown to select:
   - Published: Visible to all users
   - Draft: Only visible to the instructor
   - Archived: No longer available for new enrollments
   - Pending Review: Awaiting administrator approval
3. Click "Save Changes"

### Course Analytics

1. Click on a course name to access detailed analytics
2. View metrics including:
   - Enrollment numbers
   - Completion rates
   - Average ratings
   - Revenue generated
   - Student engagement data

## Category Management

### Managing Course Categories

1. Navigate to "Categories" in the sidebar
2. View all existing categories

#### Creating Categories

1. Click "Add Category"
2. Fill in the category details:
   - Name
   - Slug (URL-friendly name)
   - Parent category (if applicable)
   - Description
   - Icon (from Font Awesome)
3. Click "Create Category"

#### Editing Categories

1. Click on a category name
2. Modify any details
3. Click "Save Changes"

#### Category Hierarchy

Create a nested structure of categories:

1. When creating or editing a category, select a parent category
2. This creates a hierarchical navigation for students

## Payment and Financial Management

### Payment Overview

1. Navigate to "Payments" in the sidebar
2. View all transactions with filtering options:
   - Status (Completed, Pending, Failed, Refunded)
   - Date range
   - Payment method
   - Course
   - User

### Processing Refunds

1. Locate the transaction in the payments list
2. Click "Process Refund"
3. Enter refund amount and reason
4. Click "Confirm Refund"

### Instructor Payouts

1. Navigate to "Instructor Payouts" tab
2. View pending payout requests
3. Review instructor earnings details
4. Approve or reject payout requests
5. Process approved payouts

### Financial Reports

1. Go to "Financial Reports" tab
2. Generate reports for:
   - Revenue by time period
   - Revenue by course category
   - Instructor earnings
   - Refund rates
   - Transaction fees
3. Export reports in CSV or PDF format

## System Settings

### General Settings

1. Navigate to "Settings" in the sidebar
2. Under "General" tab, configure:
   - Site name
   - Site description
   - Contact email
   - User registration options
   - Default language
   - Time zone

### Payment Settings

Configure payment gateways and options:

1. Go to "Payment" tab in Settings
2. Set up payment gateways:
   - PayPal
   - Stripe
   - Bank transfer
3. Configure currency settings
4. Set platform fee percentage
5. Configure payout schedules and minimums

### Email Settings

Manage system email configuration:

1. Navigate to "Email" tab in Settings
2. Configure SMTP settings:
   - SMTP host
   - Username and password
   - Port and encryption
3. Set sender email and name
4. Customize email templates for:
   - Welcome emails
   - Course enrollment
   - Password reset
   - Certificate issuance
   - Administrative notifications

### Appearance Settings

Customize the platform's look and feel:

1. Go to "Appearance" tab in Settings
2. Upload logo and favicon
3. Set primary and secondary colors
4. Choose theme options
5. Customize homepage layout
6. Add custom CSS if needed

### Certificate Settings

Manage certificate templates:

1. Navigate to "Certificates" tab in Settings
2. Configure global certificate settings:
   - Enable/disable certificates
   - Default certificate template
   - Certificate verification options
3. Design certificate templates:
   - Upload background image
   - Set text content and positioning
   - Add logo and signature
   - Configure verification QR code

### Maintenance Settings

System maintenance options:

1. Go to "Maintenance" tab in Settings
2. Configure maintenance mode:
   - Enable/disable with custom message
   - IP whitelist for access during maintenance
3. Database backup options:
   - Schedule automatic backups
   - Download manual backups
4. Cache management:
   - Clear system cache
   - Configure caching options
5. View system information and logs

## Content Moderation

### Discussion Moderation

1. Navigate to "Discussions" in the sidebar
2. View all platform discussions
3. Filter by course, user, or date
4. Monitor for inappropriate content
5. Take moderation actions:
   - Edit posts
   - Delete content
   - Lock threads
   - Warn users

### Review Moderation

1. Go to "Reviews" in the sidebar
2. View all course reviews
3. Filter by course, rating, or date
4. Moderate reviews:
   - Approve pending reviews
   - Remove inappropriate reviews
   - Respond to reviews as administrator

### Announcement Management

1. Navigate to "Announcements" in the sidebar
2. Create system-wide announcements:
   - Title and content
   - Target audience (All, Students, Instructors)
   - Display period
   - Priority level
3. Manage existing announcements:
   - Edit content
   - Extend or shorten display period
   - Remove announcements

## Reports and Analytics

### Platform Analytics

1. Navigate to "Reports" in the sidebar
2. View comprehensive platform metrics:
   - User growth
   - Course enrollments
   - Revenue trends
   - Completion rates
   - Popular categories
   - Peak usage times

### Custom Reports

Generate specialized reports:

1. Go to "Custom Reports" tab
2. Select report parameters:
   - Data points to include
   - Filtering criteria
   - Date range
   - Grouping options
3. Generate and export reports in various formats

### User Activity Logs

Monitor platform usage:

1. Navigate to "Activity Logs" tab
2. View detailed user actions:
   - Logins and logouts
   - Course enrollments
   - Content access
   - Quiz attempts
   - Payment transactions
3. Filter logs by user, action type, or date

## System Maintenance

### Database Management

1. Navigate to "Maintenance" in Settings
2. Under "Database" tab:
   - Create database backups
   - Restore from backup
   - Optimize database tables

### Cache Management

1. Go to "Cache" tab in Maintenance
2. Clear different cache types:
   - System cache
   - Page cache
   - Object cache

### System Logs

1. Navigate to "Logs" tab in Maintenance
2. View various system logs:
   - Error logs
   - Access logs
   - Security logs
3. Filter logs by severity, date, or type
4. Download logs for offline analysis

### System Updates

1. Go to "Updates" tab in Maintenance
2. Check for available system updates
3. Review update details and compatibility
4. Create backup before updating
5. Apply updates with one click

### Security Management

1. Navigate to "Security" tab in Maintenance
2. Configure security settings:
   - Password policies
   - Login attempt limits
   - Two-factor authentication requirements
   - Session timeout settings
3. View security audit logs
4. Configure IP blocking for suspicious activity

---

For technical support, please contact our development team at dev-support@edulearn.com
