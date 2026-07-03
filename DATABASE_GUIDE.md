# IPs System V10 - Database Guide

## Database Overview

**Database Name:** `ipsdb`  
**Character Set:** `utf8mb4`  
**Collation:** `utf8mb4_general_ci`  
**Version:** 2.2

---

## Core Tables

### 1. `users`
User accounts for both admin and resident users.

**Columns:**
- `id` (VARCHAR) - Primary key, unique user ID
- `username` (VARCHAR) - Login username
- `password` (VARCHAR) - User password (plain text - consider hashing)
- `user_type` (ENUM) - 'admin' or 'resident'
- `first_name` (VARCHAR) - First name
- `middle_name` (VARCHAR) - Middle name
- `last_name` (VARCHAR) - Last name
- `contact_number` (VARCHAR) - Contact number
- `email_address` (VARCHAR) - Email address
- `is_active` (TINYINT) - Account status (1=active, 0=inactive)
- `deactivation_reason` (TEXT) - Reason for deactivation (optional)
- `created_at` (TIMESTAMP) - Account creation date
- `updated_at` (TIMESTAMP) - Last update date

**Indexes:**
- PRIMARY KEY (`id`)
- UNIQUE KEY (`username`)

---

### 2. `residence_information`
Complete resident information and personal details.

**Key Columns:**
- `a_i` (INT) - Auto increment primary key
- `residence_id` (VARCHAR) - Foreign key to users.id
- `first_name`, `middle_name`, `last_name` - Personal names
- `age`, `gender`, `birth_date`, `birth_place` - Personal details
- `civil_status` - Marital status
- `contact_number`, `email_address` - Contact info
- `address`, `municipality`, `zip` - Address information
- `IPs`, `ip_status`, `tribe` - IPs details
- `family_number`, `household_number` - Family identifiers
- `cadt_ad` - CADT/AD information
- `spouse_name`, `spouse_sex`, `spouse_birthday` - Spouse info
- `registered_civil_registry` - Civil registry status
- `place_of_origin`, `sitio_purok` - Location details
- `image`, `image_path` - Profile image
- `created_at`, `updated_at` - Timestamps

**Indexes:**
- PRIMARY KEY (`a_i`)
- UNIQUE KEY (`residence_id`)
- KEY (`IPs`)

**Relationships:**
- `residence_id` → `users.id` (1:1)

---

### 3. `certificate_types`
Available certificate types and their configurations.

**Columns:**
- `a_i` (INT) - Auto increment primary key
- `certificate_type_id` (VARCHAR) - Unique certificate type ID
- `certificate_name` (VARCHAR) - Certificate name
- `description` (TEXT) - Certificate description
- `fee` (DECIMAL) - Certificate fee (₱)
- `validity_days` (INT) - Validity period in days
- `is_active` (TINYINT) - Active status (1=active, 0=inactive)
- `created_at` (TIMESTAMP) - Creation date
- `updated_at` (TIMESTAMP) - Last update date

**Indexes:**
- PRIMARY KEY (`a_i`)
- UNIQUE KEY (`certificate_type_id`)

---

### 4. `certificate_request`
Certificate requests from residents.

**Columns:**
- `a_i` (INT) - Auto increment primary key
- `id` (VARCHAR) - Unique request ID
- `residence_id` (VARCHAR) - Foreign key to users.id
- `certificate_type_id` (VARCHAR) - Foreign key to certificate_types
- `certificate_name` (VARCHAR) - Certificate name
- `certificate_fee` (DECIMAL) - Fee amount
- `certificate_validity_days` (INT) - Validity days
- `certificate_description` (TEXT) - Description
- `purpose` (VARCHAR) - Request purpose
- `message` (VARCHAR) - Admin message
- `resident_message` (TEXT) - Resident's message
- `gcash_payment` (VARCHAR) - Payment amount
- `gcash_number` (VARCHAR) - GCash number
- `reference_number` (VARCHAR) - GCash reference number
- `gcash_transaction_id` (VARCHAR) - Link to gcash_transactions
- `date_request` (VARCHAR) - Request date
- `date_issued` (VARCHAR) - Issue date
- `date_expired` (VARCHAR) - Expiry date
- `status` (VARCHAR) - Request status (PENDING, ACCEPTED, REJECTED)
- `template_updated_at` (TIMESTAMP) - Template update time
- `created_at` (TIMESTAMP) - Creation date
- `updated_at` (TIMESTAMP) - Last update date

**Indexes:**
- PRIMARY KEY (`a_i`)
- UNIQUE KEY (`id`)
- UNIQUE KEY (`reference_number`)
- KEY (`residence_id`)
- KEY (`status`)
- KEY (`certificate_type_id`)
- KEY (`gcash_transaction_id`)

**Relationships:**
- `residence_id` → `users.id` (many:1)
- `certificate_type_id` → `certificate_types.certificate_type_id` (many:1)
- `gcash_transaction_id` → `gcash_transactions.id` (1:1)

---

### 5. `gcash_transactions`
GCash payment transaction records.

**Columns:**
- `a_i` (INT) - Auto increment primary key
- `id` (VARCHAR) - Unique transaction ID
- `residence_id` (VARCHAR) - Foreign key to users.id
- `certificate_request_id` (VARCHAR) - Link to certificate_request
- `client_name` (VARCHAR) - Client/resident name
- `reference_number` (VARCHAR) - GCash reference number
- `amount` (DECIMAL) - Payment amount
- `certificate_type` (VARCHAR) - Certificate type
- `purpose` (TEXT) - Payment purpose
- `status` (VARCHAR) - Transaction status (PENDING, COMPLETED, FAILED, CANCELLED)
- `transaction_date` (TIMESTAMP) - Transaction date
- `processed_date` (TIMESTAMP) - Processed date
- `payment_date` (TIMESTAMP) - Payment date
- `completion_date` (TIMESTAMP) - Completion date
- `created_at` (TIMESTAMP) - Creation date
- `updated_at` (TIMESTAMP) - Last update date

**Indexes:**
- PRIMARY KEY (`a_i`)
- UNIQUE KEY (`id`)
- UNIQUE KEY (`reference_number`)
- KEY (`residence_id`)
- KEY (`certificate_request_id`)
- KEY (`status`)

**Relationships:**
- `residence_id` → `users.id` (many:1)
- `certificate_request_id` → `certificate_request.id` (1:1)

---

### 6. `messages`
Direct messages between admin and residents.

**Columns:**
- `id` (INT) - Auto increment primary key
- `sender_id` (VARCHAR) - Sender user ID
- `sender_type` (ENUM) - 'admin' or 'resident'
- `receiver_id` (VARCHAR) - Receiver user ID
- `receiver_type` (ENUM) - 'admin' or 'resident'
- `message` (TEXT) - Message content
- `is_read` (TINYINT) - Read status (1=read, 0=unread)
- `created_at` (TIMESTAMP) - Message date

**Indexes:**
- PRIMARY KEY (`id`)
- KEY (`sender_id`, `sender_type`)
- KEY (`receiver_id`, `receiver_type`)
- KEY (`created_at`)

**Relationships:**
- `sender_id` → `users.id` (many:1)
- `receiver_id` → `users.id` (many:1)

---

### 7. `registration_requests`
Resident registration requests awaiting approval.

**Columns:**
- `request_id` (INT) - Auto increment primary key
- `username` (VARCHAR) - Requested username
- `status` (VARCHAR) - Request status (PENDING, APPROVED, REJECTED)
- `date_requested` (TIMESTAMP) - Request date
- `date_processed` (TIMESTAMP) - Processing date
- `admin_notes` (TEXT) - Admin notes/reason
- `residence_data` (TEXT) - JSON encoded residence data
- `created_at` (TIMESTAMP) - Creation date
- `updated_at` (TIMESTAMP) - Last update date

**Indexes:**
- PRIMARY KEY (`request_id`)
- UNIQUE KEY (`username`)
- KEY (`status`)

---

### 8. `official_information`
IPs official information.

**Columns:**
- `a_i` (INT) - Auto increment primary key
- `official_id` (VARCHAR) - Unique official ID
- `first_name`, `middle_name`, `last_name` - Official names
- `age`, `gender`, `birth_date` - Personal details
- `contact_number`, `email_address` - Contact info
- `address` - Address
- `image`, `image_path` - Profile image
- `created_at`, `updated_at` - Timestamps

**Indexes:**
- PRIMARY KEY (`a_i`)
- UNIQUE KEY (`official_id`)

---

### 9. `official_status`
Official status and position information.

**Columns:**
- `a_i` (INT) - Auto increment primary key
- `official_id` (VARCHAR) - Foreign key to official_information
- `position` (VARCHAR) - Official position
- `term_from`, `term_to` (VARCHAR) - Term dates
- `status` (VARCHAR) - Status (active, inactive)
- `senior`, `pwd`, `pwd_info` - Additional info
- `voters`, `single_parent` - Status flags
- `date_added`, `date_undeleted` - Date tracking

**Indexes:**
- PRIMARY KEY (`a_i`)
- KEY (`official_id`)

**Relationships:**
- `official_id` → `official_information.official_id` (many:1)

---

### 10. `position`
Available official positions.

**Columns:**
- `a_i` (INT) - Auto increment primary key
- `position_id` (VARCHAR) - Unique position ID
- `position_name` (VARCHAR) - Position name
- `description` (TEXT) - Position description
- `is_active` (TINYINT) - Active status
- `created_at`, `updated_at` - Timestamps

**Indexes:**
- PRIMARY KEY (`a_i`)
- UNIQUE KEY (`position_id`)

---

### 11. `activity_log`
System activity logging and audit trail.

**Columns:**
- `id` (INT) - Auto increment primary key
- `message` (VARCHAR) - Activity message
- `date` (VARCHAR) - Activity date
- `status` (VARCHAR) - Activity status

**Indexes:**
- PRIMARY KEY (`id`)

---

### 12. `IPs_information`
System-wide IPs community information.

**Columns:**
- `id` (VARCHAR) - Primary key
- `IPs` (VARCHAR) - IPs name
- `zone` (VARCHAR) - Zone
- `district` (VARCHAR) - District
- `address` (VARCHAR) - Address
- `postal_address` (VARCHAR) - Postal address
- `image` (VARCHAR) - Logo filename
- `image_path` (VARCHAR) - Logo path
- `background_image_path` (VARCHAR) - Background image path

**Indexes:**
- PRIMARY KEY (`id`)

---

### 13. `children`
Resident children information.

**Columns:**
- `a_i` (INT) - Auto increment primary key
- `residence_id` (VARCHAR) - Foreign key to users.id
- `first_name`, `middle_name`, `last_name` - Child names
- `age`, `sex`, `birthday` - Personal details
- `civil_status` - Marital status
- `religion` - Religion
- `phic`, `4ps`, `pensioner` - Status flags
- `registered_voter` - Voter status
- `pwd`, `pwd_info` - PWD information
- `senior_citizen` - Senior status
- `has_children` - Has children flag
- `created_at`, `updated_at` - Timestamps

**Indexes:**
- PRIMARY KEY (`a_i`)
- KEY (`residence_id`)

**Relationships:**
- `residence_id` → `users.id` (many:1)

---

## Archive Tables

### `inactive_official_information`
Archived official records.

### `inactive_official_status`
Archived official status records.

---

## Database Relationships Diagram

```
users (1) ──┬── (1) residence_information
            │
            ├── (many) certificate_request
            │           │
            │           └── (1) gcash_transactions
            │
            ├── (many) messages (as sender)
            │
            └── (many) messages (as receiver)

certificate_types (1) ── (many) certificate_request

official_information (1) ── (many) official_status

position (1) ── (many) official_status
```

---

## Important Notes

### Data Integrity
- Foreign key constraints ensure data consistency
- Unique constraints prevent duplicate entries
- Indexes improve query performance

### Character Encoding
- All tables use `utf8mb4` character set
- Supports full Unicode including emojis
- Proper handling of special characters

### Timestamps
- Most tables have `created_at` and `updated_at`
- Automatic timestamp management
- Used for audit and tracking

### Status Fields
- Multiple status fields throughout system
- Standardized status values
- Easy filtering and reporting

---

## Backup & Restore

### Backup Database
```sql
-- Using mysqldump
mysqldump -u root -p ipsdb > backup.sql
```

### Restore Database
```sql
-- Using mysql
mysql -u root -p ipsdb < backup.sql
```

### Using phpMyAdmin
1. Select database
2. Click Export tab
3. Choose format (SQL recommended)
4. Click Go

---

## Maintenance Queries

### Check Table Sizes
```sql
SELECT 
    table_name AS 'Table',
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Size (MB)'
FROM information_schema.TABLES
WHERE table_schema = 'ipsdb'
ORDER BY (data_length + index_length) DESC;
```

### Count Records
```sql
SELECT 
    'users' AS table_name, COUNT(*) AS count FROM users
UNION ALL
SELECT 'residence_information', COUNT(*) FROM residence_information
UNION ALL
SELECT 'certificate_request', COUNT(*) FROM certificate_request
UNION ALL
SELECT 'gcash_transactions', COUNT(*) FROM gcash_transactions;
```

### Check Foreign Keys
```sql
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = 'ipsdb'
AND REFERENCED_TABLE_NAME IS NOT NULL;
```

---

## Database Version History

- **Version 2.2** - Current version
  - Complete table structure
  - All foreign keys
  - All indexes
  - Archive tables

---

**Last Updated:** 2025

