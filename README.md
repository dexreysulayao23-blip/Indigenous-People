# IPs System V10 - Indigenous Peoples Management System

## System Overview

Ang **IPs System V10** usa ka comprehensive web-based management system para sa Indigenous Peoples (IPs) communities. Kini nag-provide og complete solution para sa:

- **Resident Registration & Management**
- **Certificate Request & Processing**
- **Official Management**
- **GCash Payment Tracking**
- **Direct Messaging System**
- **Activity Logging & Reporting**

## Key Features

### 👥 **Resident Portal**
- Online registration with comprehensive personal information
- Certificate request system with GCash payment integration
- Personal record management (spouse, children)
- Direct messaging with administrators
- Profile management and password recovery
- Real-time request status tracking

### 🏛️ **Admin Portal**
- Complete resident management
- Certificate request approval/rejection system
- Official management (add, edit, archive)
- GCash transaction tracking and management
- Registration request approval system
- System settings and configuration
- Activity logs and reporting
- Income reports and statistics

### 💳 **Payment System**
- GCash payment integration
- Automatic transaction tracking
- Payment status management
- Reference number validation
- Transaction history

### 📋 **Certificate Management**
- Multiple certificate types support
- Customizable certificate fees
- Certificate validity tracking
- Digital certificate file management
- Print-ready certificate generation

## System Requirements

- **Web Server:** Apache (XAMPP recommended)
- **PHP Version:** 7.4 or higher (8.1+ recommended)
- **Database:** MySQL 5.7+ or MariaDB 10.4+
- **Browser:** Modern browsers (Chrome, Firefox, Edge, Safari)

## Quick Start

1. **Install XAMPP**
   - Download from https://www.apachefriends.org/
   - Install and start Apache and MySQL services

2. **Database Setup**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create database: `ipsdb`
   - Import `IPs_SystemV10.sql` file

3. **Configure Connection**
   - Edit `connection.php` if needed (default: root, no password)

4. **Access System**
   - Main page: `http://localhost/IPs_System/`
   - Login: `http://localhost/IPs_SystemV10/login.php`

## Directory Structure

```
IPs_SystemV10/
├── admin/              # Admin portal files
├── resident/          # Resident portal files
├── assets/             # CSS, JS, images, plugins
├── certificates/       # Certificate templates
├── uploads/           # Uploaded files
├── signup/            # Registration handlers
├── connection.php      # Database connection
├── index.php          # Landing page
├── login.php          # Login page
├── register.php       # Registration page
└── IPs_SystemV10.sql  # Database schema
```

## User Types

### **Admin**
- Full system access
- Manage residents, officials, certificates
- Approve/reject requests
- System configuration
- View reports and statistics

### **Resident**
- Personal information management
- Certificate requests
- View personal records
- Direct messaging with admin
- Profile updates

## Security Features

- Session-based authentication
- Password protection
- SQL injection prevention (prepared statements)
- XSS protection
- File upload validation
- Activity logging
- Account deactivation system

## Main Modules

1. **Resident Management** - Complete CRUD operations for residents
2. **Official Management** - IPs official information and status
3. **Certificate System** - Request, approval, and generation
4. **Messaging System** - Direct communication between admin and residents
5. **Registration System** - Online registration with approval workflow
6. **Reporting** - Activity logs, income reports, statistics

## Documentation

- **[INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md)** - Detailed setup instructions
- **[SYSTEM_DOCUMENTATION.md](SYSTEM_DOCUMENTATION.md)** - Complete feature documentation
- **[DATABASE_GUIDE.md](DATABASE_GUIDE.md)** - Database structure and tables

## Support

For technical support o questions, Contact ang system Administrator.

## Version

**Version:** 10.0  
**Last Updated:** 2025  
**Database Version:** 2.2

---

Note: Make sure MySQL service is running on XAMPP before accessing the system.

---

![image alt](https://github.com/dexreysulayao23-blip/Indigenous-People/blob/9f0db3271477eeb8956348ade963dd54d9e3d032/1.png)
![image alt](https://github.com/dexreysulayao23-blip/Indigenous-People/blob/e290ba5584ee7392a080127aa40a1e04aa4dbd39/2.png)
![image alt](https://github.com/dexreysulayao23-blip/Indigenous-People/blob/e290ba5584ee7392a080127aa40a1e04aa4dbd39/3.png)
![image alt](https://github.com/dexreysulayao23-blip/Indigenous-People/blob/e290ba5584ee7392a080127aa40a1e04aa4dbd39/4.png)
![image alt](https://github.com/dexreysulayao23-blip/Indigenous-People/blob/e290ba5584ee7392a080127aa40a1e04aa4dbd39/5.png)
![image alt](https://github.com/dexreysulayao23-blip/Indigenous-People/blob/e290ba5584ee7392a080127aa40a1e04aa4dbd39/6.png)
![image alt](https://github.com/dexreysulayao23-blip/Indigenous-People/blob/e290ba5584ee7392a080127aa40a1e04aa4dbd39/7.png)
![image alt](https://github.com/dexreysulayao23-blip/Indigenous-People/blob/e290ba5584ee7392a080127aa40a1e04aa4dbd39/8.png)
![image alt](https://github.com/dexreysulayao23-blip/Indigenous-People/blob/e290ba5584ee7392a080127aa40a1e04aa4dbd39/9.png)
![image alt](https://github.com/dexreysulayao23-blip/Indigenous-People/blob/e290ba5584ee7392a080127aa40a1e04aa4dbd39/10.png)
![image alt](https://github.com/dexreysulayao23-blip/Indigenous-People/blob/e290ba5584ee7392a080127aa40a1e04aa4dbd39/11.png)
![image alt](https://github.com/dexreysulayao23-blip/Indigenous-People/blob/e290ba5584ee7392a080127aa40a1e04aa4dbd39/12.png)


