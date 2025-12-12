# SETUP INSTRUCTIONS - LAPORINAJA

## Prerequisites
- PHP 8.4.12 (tested)
- MySQL 8.0+
- Composer
- Node.js (optional, untuk frontend build)
- Laragon/XAMPP (recommended for Windows)

## Initial Setup

### 1. Environment Configuration
```bash
# Copy .env.example to .env
cp .env.example .env

# Generate application key
php artisan key:generate

# Set your database credentials in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laporinaja
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Database Setup
```bash
# Create database
CREATE DATABASE laporinaja CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Run migrations
php artisan migrate --force

# Seed test data
php artisan db:seed

# Verify with
php artisan migrate:status
```

### 3. Storage Configuration
```bash
# Create storage symlink
php artisan storage:link

# Make storage writable
chmod -R 775 storage/ bootstrap/cache/

# On Windows (already handled by Laravel)
```

### 4. Cache & Config
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache for production only
php artisan config:cache
php artisan route:cache
```

### 5. Start Server
```bash
# Development server
php artisan serve --port=8000

# Application ready at: http://127.0.0.1:8000
```

### 6. First Access
```
1. Open: http://127.0.0.1:8000/simple-login
2. Select user: Seprian Siagian
3. Password: password
4. Click Login
```

---

## Directory Structure

```
project/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Report.php
│   │   ├── Category.php
│   │   ├── Vote.php
│   │   ├── Comment.php
│   │   └── Solution.php
│   └── Http/
│       └── Controllers/
│           ├── AuthController.php
│           ├── ReportController.php
│           ├── VoteController.php
│           └── CommentController.php
│
├── database/
│   ├── migrations/
│   │   ├── 2025_01_01_*_create_users_table.php
│   │   ├── 2025_01_01_*_create_categories_table.php
│   │   ├── 2025_01_01_*_create_reports_table.php
│   │   ├── 2025_01_01_*_create_comments_table.php
│   │   ├── 2025_01_01_*_create_votes_table.php
│   │   ├── 2025_01_01_*_create_solutions_table.php
│   │   └── 2025_01_01_*_create_sessions_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── auth/
│   │   │   └── simple_login.blade.php
│   │   ├── homepage.blade.php
│   │   ├── homepage_auth.blade.php
│   │   ├── create_report.blade.php
│   │   └── profile.blade.php
│   └── css/
│
├── storage/
│   ├── app/
│   │   └── public/
│   │       └── reports/  (← User uploaded images stored here)
│   └── logs/
│
├── routes/
│   └── web.php
│
├── ARCHITECTURE.md  (← READ THIS FIRST)
├── TESTING_GUIDE.md (← Testing procedures)
└── .env             (← Configuration)
```

---

## Key Files to Understand

### Routes (routes/web.php)
- All public/protected routes defined here
- Session-based auth checks
- Simple login is default entry point

### Database Schema (database/migrations/)
- Migration files define authoritative schema
- No duplicate migrations
- All foreign keys defined with CASCADE/SET NULL
- Indexes optimized for common queries

### Controllers (app/Http/Controllers/)
- Authentication: Session-based, no API dependency
- Report CRUD: Create, read, list with relationships
- Voting: Polymorphic relationship (reports & comments)
- Comments: Reply system for reports

### Models (app/Models/)
- User: has-many reports, votes, comments
- Report: belongs-to user & category, has-many votes
- Category: has-many reports
- Vote: Polymorphic (for reports & comments)

### Views (resources/views/)
- Blade templates with Tailwind CSS
- homepage_auth.blade.php: Main authenticated feed
- create_report.blade.php: Report submission form
- Simple responsive design

---

## Database Users (Test Credentials)

```sql
-- 5 seeded users:
1. Seprian Siagian     | seprian@test.com | password | user
2. Budi Santoso        | budi@test.com    | password | user
3. Ani Wijaya          | ani@test.com     | password | user
4. Rini Kusuma         | rini@test.com    | password | admin
5. Admin               | admin@test.com   | admin123 | admin

-- All passwords hashed with bcrypt
-- Default for testing: "password" except admin user uses "admin123"
```

---

## Troubleshooting

### Issue: "SQLSTATE Connection refused"
**Solution:**
- Check MySQL is running
- Verify DB credentials in .env
- Ensure database exists: `CREATE DATABASE laporinaja`

### Issue: "Class not found" errors
**Solution:**
```bash
# Regenerate autoload
composer dump-autoload

# Clear cache
php artisan cache:clear
php artisan config:clear
```

### Issue: "Permission denied" on storage/
**Solution:**
```bash
# Make writable
chmod -R 775 storage/ bootstrap/cache/

# On Windows (Laragon): Already handled
```

### Issue: "Route not found"
**Solution:**
```bash
php artisan route:clear
php artisan route:list  # Verify routes exist
```

### Issue: "No login appearing"
**Solution:**
```bash
# Check simple-login route exists
php artisan route:list | grep simple-login

# If not, restart server:
php artisan serve --port=8000
```

---

## Production Deployment

### Before Going Live

1. **Environment**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Database**
   ```bash
   php artisan migrate --force --env=production
   php artisan db:seed --env=production
   ```

3. **Security**
   ```bash
   # Generate unique APP_KEY
   php artisan key:generate
   
   # Update .env:
   APP_KEY=base64:xxx...xxx
   ```

4. **Storage**
   ```bash
   # Create symlink
   php artisan storage:link
   
   # Ensure writable
   chmod 755 storage/app/public
   ```

5. **Caching**
   ```bash
   # Enable caching
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. **Logging**
   ```bash
   # Setup proper logging in config/logging.php
   # Monitor storage/logs/ directory
   ```

### Deployment Checklist
- [ ] .env configured with production values
- [ ] Database migrations ran
- [ ] Storage symlink created
- [ ] Caches warmed
- [ ] SSL certificate installed
- [ ] Email service configured
- [ ] Monitoring alerts setup
- [ ] Backup strategy implemented
- [ ] Rate limiting configured
- [ ] CORS headers configured if needed

---

## Performance Monitoring

### Laravel Telescope (Development Only)
```bash
composer require laravel/telescope --dev
php artisan telescope:install
```

### Query Monitoring
```php
// In config/database.php for development:
'log' => env('DB_LOG', ''),
'log_level' => env('DB_LOG_LEVEL', 'debug'),

// Then check storage/logs/laravel.log
```

### Application Logs
```bash
# Watch logs in real-time
tail -f storage/logs/laravel.log
```

---

## Common Commands

```bash
# Development
php artisan serve --port=8000

# Database
php artisan migrate                 # Run migrations
php artisan migrate:rollback        # Rollback
php artisan db:seed                 # Run seeders
php artisan db:wipe --force          # Delete all

# Cache
php artisan cache:clear             # Clear app cache
php artisan config:clear            # Clear config cache
php artisan route:clear             # Clear route cache

# Maintenance
php artisan down                     # Maintenance mode ON
php artisan up                       # Maintenance mode OFF

# Tinker (REPL)
php artisan tinker                   # Interactive shell

# Storage
php artisan storage:link             # Create public symlink

# Utilities
php artisan tinker
>>> User::count()                    # Check user count
>>> Report::count()                  # Check report count
>>> exit
```

---

## Support & Documentation

### Inside Project
- **ARCHITECTURE.md** - System design & components
- **TESTING_GUIDE.md** - Testing procedures & scenarios

### External Resources
- Laravel Documentation: https://laravel.com/docs
- Blade Templates: https://laravel.com/docs/blade
- Eloquent ORM: https://laravel.com/docs/eloquent

---

## Version Info

- **Laravel:** 12.x
- **PHP:** 8.4.12
- **MySQL:** 8.0+
- **Node.js:** Optional (for frontend build)
- **Last Updated:** 12 December 2025

---

## Support Contacts

For issues or questions:
1. Check TESTING_GUIDE.md
2. Review ARCHITECTURE.md
3. Check storage/logs/laravel.log
4. Run: `php artisan tinker` to debug

---

**Status: Ready for Production QA** ✅
