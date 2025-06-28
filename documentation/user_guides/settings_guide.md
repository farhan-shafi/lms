# EduLearn LMS - System Settings Guide

This guide provides detailed instructions for administrators on configuring and managing all system settings in the EduLearn LMS.

## Table of Contents

1. [Accessing System Settings](#accessing-system-settings)
2. [General Settings](#general-settings)
3. [Payment Settings](#payment-settings)
4. [Email Settings](#email-settings)
5. [Appearance Settings](#appearance-settings)
6. [Certificate Settings](#certificate-settings)
7. [Maintenance Settings](#maintenance-settings)

## Accessing System Settings

The Settings area is accessible only to administrators and provides control over all aspects of the LMS platform.

### How to Access Settings

1. Log in with your administrator account
2. Click on "Settings" in the admin sidebar
3. You'll be directed to the General Settings page by default

### Settings Navigation

The settings area includes a sidebar with the following sections:

- **General**: Basic system configuration
- **Payment**: Payment gateway and financial settings
- **Email**: Email server and template configuration
- **Appearance**: Visual customization options
- **Certificates**: Certificate template and issuance settings
- **Maintenance**: System maintenance and backup tools

## General Settings

The General Settings page allows you to configure core system parameters.

![General Settings](../assets/images/documentation/general-settings.png)

### Site Information

- **Site Name**: The name of your LMS platform (appears in browser title, emails, etc.)
- **Site Description**: A brief description of your platform (used in meta tags)
- **Contact Email**: The primary contact email for your platform

### Registration Settings

- **Enable Registration**: Toggle user registration on/off
- **Enable Public Courses**: Allow courses to be viewed without login
- **Maintenance Mode**: Put the site in maintenance mode (only admins can access)

### How to Update General Settings

1. Navigate to Settings > General
2. Modify the desired settings
3. Click "Save Changes" at the bottom of the page

## Payment Settings

Configure payment gateways and financial parameters for your LMS.

![Payment Settings](../assets/images/documentation/payment-settings.png)

### Currency Configuration

- **Currency**: Select your platform's primary currency (USD, EUR, GBP, etc.)
- **Currency Symbol**: Set the symbol to display (e.g., $, €, £)

### Payment Gateways

#### PayPal Configuration

- **Enable PayPal**: Toggle PayPal payments on/off
- **PayPal Email**: Enter your PayPal business email
- **PayPal Sandbox**: Enable for testing (no real payments)

#### Stripe Configuration

- **Enable Stripe**: Toggle Stripe payments on/off
- **Stripe Public Key**: Enter your Stripe public key
- **Stripe Secret Key**: Enter your Stripe secret key
- **Stripe Test Mode**: Enable for testing (uses test keys)

#### Bank Transfer

- **Enable Bank Transfer**: Toggle manual bank transfer option on/off
- **Bank Details**: Enter your banking information for manual transfers

### How to Update Payment Settings

1. Navigate to Settings > Payment
2. Configure your desired payment gateways
3. Enter all required API credentials
4. Click "Save Changes"

### Testing Payment Configuration

Before going live:

1. Enable test/sandbox mode
2. Make a test purchase
3. Verify the transaction in your payment gateway dashboard
4. Disable test mode when ready for real transactions

## Email Settings

Configure your email server and customize email templates.

![Email Settings](../assets/images/documentation/email-settings.png)

### Email Server Configuration

- **From Email Address**: The email address emails will be sent from
- **From Name**: The name that will appear as the sender

#### SMTP Settings

- **SMTP Host**: Your mail server hostname (e.g., smtp.gmail.com)
- **SMTP Username**: Your mail server username
- **SMTP Password**: Your mail server password
- **SMTP Port**: Server port (typically 587 for TLS, 465 for SSL)
- **SMTP Encryption**: Select TLS, SSL, or none

### Email Templates

- **Email Template Header**: HTML for the header of all system emails
- **Email Template Footer**: HTML for the footer of all system emails

### Testing Email Configuration

1. Configure your email settings
2. Scroll to the "Test Email" section
3. Enter a test email address
4. Click "Send Test"
5. Check the recipient inbox to confirm delivery

### Troubleshooting Email Issues

If test emails fail:

1. Verify SMTP credentials are correct
2. Check that the SMTP port is not blocked by your server
3. Ensure the From Email Address is valid
4. Check your mail server logs for specific errors

## Appearance Settings

Customize the visual aspects of your LMS platform.

![Appearance Settings](../assets/images/documentation/appearance-settings.png)

### Brand Identity

- **Site Logo**: Upload your platform logo (recommended size: 200x50px)
- **Site Favicon**: Upload a favicon (recommended size: 32x32px)

### Color Scheme

- **Primary Color**: Set the main color for buttons and highlights
- **Secondary Color**: Set the secondary accent color

### Theme Options

- **Theme**: Select from available themes (Light, Dark, Custom)

### Custom Code

- **Custom CSS**: Add custom CSS to override default styles
- **Custom JavaScript**: Add custom JavaScript for additional functionality

### How to Update Appearance Settings

1. Navigate to Settings > Appearance
2. Upload your logo and favicon
3. Select your color scheme
4. Add any custom code
5. Click "Save Changes"
6. View the live preview to confirm your changes look correct

## Certificate Settings

Configure certificate templates and issuance settings.

![Certificate Settings](../assets/images/documentation/certificate-settings.png)

### Certificate Options

- **Enable Certificates**: Toggle certificate issuance on/off
- **Certificate Text Template**: Customize the text that appears on certificates
  - Available variables: {student_name}, {course_name}, {completion_date}, {instructor_name}, {certificate_id}

### Certificate Design

- **Certificate Background**: Upload a background image (recommended size: 1920x1080px)
- **Certificate Logo**: Enter the URL for your logo on certificates
- **Certificate Signature**: Enter the URL for the signature image

### Certificate Preview

The preview section shows how your certificates will look with the current settings.

### How to Update Certificate Settings

1. Navigate to Settings > Certificates
2. Configure certificate options
3. Upload background and images
4. Customize certificate text
5. Check the preview to ensure proper formatting
6. Click "Save Certificate Settings"

## Maintenance Settings

Manage system maintenance, backups, and technical information.

![Maintenance Settings](../assets/images/documentation/maintenance-settings.png)

### Database Backup

- **Create Backup**: Generate a backup of your database
- The backup will be downloaded as a SQL file in ZIP format

### Cache Management

- **Clear Cache**: Remove cached data to refresh system content
- Use this option if you notice outdated content or display issues

### System Information

This section displays important technical information about your system:

- PHP Version
- CodeIgniter Version
- Database Driver and Version
- Server OS
- Server Software
- Upload Max Size
- Memory Limit

### System Logs

View recent system logs to identify and diagnose issues.

### How to Use Maintenance Tools

#### Creating a Database Backup

1. Navigate to Settings > Maintenance
2. In the Database Backup section, click "Create Backup"
3. Save the downloaded file in a secure location
4. Store backups regularly in multiple locations

#### Clearing the System Cache

1. Navigate to Settings > Maintenance
2. In the Clear Cache section, click "Clear Cache"
3. Wait for confirmation message
4. Refresh the page to see updated content

#### Reviewing System Logs

1. Navigate to Settings > Maintenance
2. Scroll to the System Logs section
3. Review log entries for errors or warnings
4. Use the timestamp and error codes to diagnose issues

---

For technical support, please contact our development team at dev-support@edulearn.com
