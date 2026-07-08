# IPs_System - Installation Guide

## Complete Setup Instructions

### Prerequisites

1. **XAMPP** (Latest version recommended)
   - Download: https://www.apachefriends.org/
   - Includes: Apache, MySQL, PHP, phpMyAdmin

2. **Web Browser** (Chrome, Firefox, Edge, or Safari)

---

## Step 1: Install XAMPP

1. Download XAMPP installer
2. Run installer ug follow ang instructions
3. Install sa default location: `C:\xampp`
4. **Important:** Ayaw i-install sa Program Files folder (permission issues)

---

## Step 2: Start Services

### Option A: Gamit ang XAMPP Control Panel
1. Open **XAMPP Control Panel**
2. I-click ang **Start** button sa **Apache**
3. I-click ang **Start** button sa **MySQL**
4. Wait until ang status maging **Running** (green)

### Option B: Gamit ang Command Line
```powershell
# Open PowerShell as Administrator
cd C:\xampp
.\apache_start.bat
.\mysql_start.bat
```

---

## Step 3: Copy Project Files

1. Copy ang **IPs_System** folder sa:
   ```
   C:\xampp\htdocs\IPs_SystemV10
   ```

2. Make sure ang folder structure complete:
   ```
   C:\xampp\htdocs\IPs_System\
   ├── admin/
   ├── resident/
   ├── assets/
   ├── connection.php
   ├── index.php
   └── IPs_System.sql
   ```

---

## Step 4: Database Setup

### Method 1: Used the phpMyAdmin (Recommended)

1. Open browser: `http://localhost/phpmyadmin`

2. **Create Database:**
   - I-click ang **New** sa left sidebar
   - Database name: `ipsdb`
   - Collation: `utf8mb4_general_ci`
   - I-click **Create**

3. **Import SQL File:**
   - I-select ang `ipsdb` database
   - I-click ang **Import** tab
   - I-click **Choose File**
   - Choose the `IPs_System.sql` from the project folder
   - I-click **Go**
   - Wait until the import is completed 

### Method 2: Used the Command Line

```powershell
# Open Command Prompt
cd C:\xampp\mysql\bin
mysql -u root -p < "C:\xampp\htdocs\IPs_System\IPs_System.sql"
# Press Enter (no password by default)
```

---

## Step 5: Configure Database Connection

1. Open: `C:\xampp\htdocs\IPs_System\connection.php`

2. Check ang database credentials:
   ```php
   define("DB_USER", 'root');        // Default: root
   define("DB_PASSWORD", '');        // Default: empty
   define("DB_NAME", 'ipsdb');       // Database name
   define("DB_HOST", 'localhost');   // Default: localhost
   ```

3. **If their is a custom MySQL password:**
   - Update the `DB_PASSWORD` value

---

## Step 6: Verify Installation

### Check Database Connection

1. Open: `http://localhost/IPs_System/`
2. To show the landing page
3. If their is some error, check the MySQL service

### Check Database Tables

1. Open: `http://localhost/phpmyadmin`
2. Select the `ipsdb` database
3. Make sure that the tables is shown:
   - `users`
   - `residence_information`
   - `certificate_types`
   - `certificate_request`
   - `messages`
   - etc

---

## Step 7: Create Admin Account

### Option A: Used Database Directly

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. I-select ang `ipsdb` database
3. I-click ang `users` table
4. I-click **Insert** tab
5. Fill in:
   - `id`: (auto-generated or unique ID)
   - `username`: admin123
   - `password`: (your desired password)
   - `user_type`: admin
   - `first_name`: Admin
   - `last_name`: User
   - `is_active`: 1
6. I-click **Go**

### Option B: Used the SQL Query

```sql
INSERT INTO `users` (`id`, `username`, `password`, `user_type`, `first_name`, `last_name`, `is_active`) 
VALUES ('1506135735699', 'admin123', 'yourpassword', 'admin', 'Admin', 'User', 1);
```

---

## Step 8: Test Login

1. Open: `http://localhost/IPs_SystemV10/login.php`
2. Enter credentials:
   - **Username:** admin123
   - **Password:** (your password)
3. I-click **Sign In**
4. Dapat ma-redirect sa admin dashboard

---

## Common Issues & Solutions

### Issue 1: MySQL Server Has Gone Away

**Solution:**
- Check if MySQL is running on XAMPP Control Panel
- Restart ang MySQL service
- Check ang MySQL port (default: 3306)

### Issue 2: Cannot Connect to Database

**Solution:**
- Verify ang database credentials sa `connection.php`
- Check kung naa ang `ipsdb` database
- Verify ang MySQL service naka-running

### Issue 3: Access Denied for User 'root'

**Solution:**
- Check ang MySQL password
- Update ang `connection.php` with correct password
- Or reset MySQL password sa XAMPP

### Issue 4: Database Not Found

**Solution:**
- Import ang SQL file again
- Or manually create ang database:
  ```sql
  CREATE DATABASE ipsdb CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
  ```

### Issue 5: Port 3306 Already in Use

**Solution:**
- I-close all applications that used port 3306
- Or i-change ang MySQL port sa XAMPP config
- Restart ang MySQL service

### Issue 6: Permission Denied Errors

**Solution:**
- Make sure the `uploads/` folder write the permissions
- Check the `certificates/` folder permissions
- Run XAMPP as Administrator if needed

---

## File Permissions Setup

### Windows:
1. Right-click sa `uploads/` folder
2. Properties → Security tab
3. I-click **Edit**
4. I-add ang **Everyone** user
5. Check **Full control**
6. Apply sa subfolders

### Required Writable Folders:
- `uploads/certificate_files/`
- `certificates/`

---

## PHP Configuration

### Check PHP Settings (if needed):

1. Open: `C:\xampp\php\php.ini`

2. Verify ang settings:
   ```ini
   upload_max_filesize = 10M
   post_max_size = 10M
   max_execution_time = 300
   memory_limit = 256M
   ```

3. Restart Apache after changes

---

## Verification Checklist

- [ ] XAMPP installed successfully
- [ ] Apache service naka-running
- [ ] MySQL service naka-running
- [ ] Project files copied sa htdocs folder
- [ ] Database `ipsdb` created
- [ ] SQL file imported successfully
- [ ] Database connection configured
- [ ] Admin account created
- [ ] Login working
- [ ] Can access admin dashboard
- [ ] Can access resident portal

---

## Next Steps

After successful installation:

1. **Configure System Settings:**
   - Go to Admin → Settings
   - Update IPs information
   - Upload logo and cover image

2. **Add Certificate Types:**
   - Go to Admin → Certificate Management
   - Add certificate types with fees

3. **Test Registration:**
   - Go to Register page
   - Test registration process
   - Approve registration sa admin panel

4. **Test Certificate Request:**
   - Login as resident
   - Request certificate
   - Test approval process

---

## Database Information

- **Database Name:** `ipsdb`
- **Username:** `root` (default)
- **Password:** (empty by default)
- **Host:** `localhost`
- **Port:** `3306`
- **Charset:** `utf8mb4`

---

## Support

having an issues during installation:

1. Check ang XAMPP error logs
2. Check ang browser console for errors
3. Verify ang database connection
4. Check ang file permissions
5. Contact system administrator

---

**Installation Complete!** 🎉

You can now start using the IPs System.

