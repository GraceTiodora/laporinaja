/**
 * LAPORINAJA - APPLICATION ARCHITECTURE DOCUMENTATION
 * 
 * Built with mature engineering practices for production-grade quality
 * Generated: 12 December 2025
 */

// ============================================
// 1. DATABASE SCHEMA (AUTHORITATIVE SOURCE)
// ============================================

Tables:
├── users (5 test users)
│   ├── id (PK)
│   ├── name, email (UNIQUE), password (hashed)
│   ├── role: 'user' | 'admin' | 'moderator'
│   ├── bio, phone, address, avatar, reputation
│   └── timestamps
│
├── categories (10 predefined)
│   ├── id (PK)
│   ├── name (UNIQUE), slug (UNIQUE)
│   ├── description, icon
│   └── timestamps
│
├── reports (5 test reports)
│   ├── id (PK)
│   ├── user_id (FK → users CASCADE)
│   ├── category_id (FK → categories SET NULL)
│   ├── title, description (LONGTEXT), location
│   ├── image (path to storage/reports/)
│   ├── status: 'Baru' | 'Diproses' | 'Selesai' | 'Ditolak'
│   ├── upvotes, downvotes (cached, updated by votes)
│   ├── resolved_at (nullable)
│   ├── timestamps
│   └── INDEXES: user_id+created_at, category_id+created_at, status+created_at, FULLTEXT
│
├── votes (Polymorphic)
│   ├── id (PK)
│   ├── user_id (FK → users CASCADE)
│   ├── votable_type, votable_id (morphs to Report or Comment)
│   ├── is_upvote (boolean)
│   ├── timestamps
│   └── UNIQUE: user_id + votable_type + votable_id
│
├── comments
│   ├── id (PK)
│   ├── report_id (FK → reports CASCADE)
│   ├── user_id (FK → users CASCADE)
│   ├── content (TEXT)
│   ├── likes (int)
│   └── timestamps
│
├── solutions
│   ├── id (PK)
│   ├── report_id (FK → reports CASCADE)
│   ├── user_id (FK → users CASCADE)
│   ├── content (TEXT)
│   ├── is_accepted (boolean)
│   ├── helpful_count (int)
│   └── timestamps
│
├── sessions (built-in Laravel)
│   └── Server-side session storage
│
├── jobs & cache (utility tables)
│   └── For background jobs and caching

Status Standardization:
- Use Indonesian: 'Baru' (New), 'Diproses' (In Progress), 'Selesai' (Done), 'Ditolak' (Rejected)
- Stored as VARCHAR not ENUM for flexibility
- All migrations reference 'Baru' as default

// ============================================
// 2. AUTHENTICATION FLOW (Session-Based)
// ============================================

LOGIN ENTRY POINTS:
1. /simple-login (DEFAULT - FOR TESTING & FALLBACK)
   - Dropdown select dari 5 test users
   - Direct database lookup
   - No API dependency
   - Stores in session['user'] with id, name, email, role
   
2. /login (FUTURE - Full form)
   - Optional: Try API first, fallback to local DB
   
3. /register (FUTURE - Full form)
   - Optional: Try API first, fallback to local DB

SESSION STRUCTURE:
session('user') = [
    'id' => 1,
    'name' => 'Seprian Siagian',
    'email' => 'seprian@test.com',
    'role' => 'user'
];
session('authenticated') = true;

LOGOUT:
POST /logout → session()->flush() → redirect home

Auth Check Pattern:
@if(session('authenticated'))
    // User is logged in
@endif

// ============================================
// 3. CONTROLLERS & REQUEST FLOW
// ============================================

ReportController:
├── create()
│   ├── Check session('authenticated')
│   ├── Fetch categories from DB (no API fallback, local only)
│   ├── Get topReports (5 reports with most votes)
│   ├── Get trendingCategories (7 days, grouped)
│   └── Return create_report view
│
├── store()
│   ├── Validate: title, description, location, category_id, image
│   ├── Process image upload → storage/reports/
│   ├── Create Report with user_id from session
│   ├── On success: redirect home
│   └── On error: back with errors
│
├── show($id)
│   ├── Get report with relations (user, category, comments, votes)
│   ├── Calculate vote counts
│   └── Return report detail view
│
└── index()
    ├── List reports (default from local DB, no API)
    └── Apply filters: status, category, search

UserDashboardController:
├── profile()
│   ├── Get logged-in user from session('user.id')
│   ├── Show user info & edit form
│   └── Return profile view
│
├── myReports()
│   ├── Get user's reports from DB
│   └── Return my_reports view
│
└── updateProfile()
    ├── Update user fields
    ├── Redirect with success/error

VoteController:
├── store()
│   ├── Create Vote record
│   ├── Update cached upvotes/downvotes on Report
│   └── Return JSON response

CommentController:
├── store()
│   ├── Create Comment
│   └── Return JSON response
│
└── index($reportId)
    ├── Get all comments for report
    └── Return JSON response

// ============================================
// 4. VIEWS & ROUTING
// ============================================

PUBLIC ROUTES (No auth required):
- GET  / (homepage)
- GET  /simple-login
- POST /simple-login

PROTECTED ROUTES (Require session('authenticated')):
- GET  /profile
- PUT  /profile
- GET  /my-reports
- GET  /reports/create
- POST /reports
- GET  /reports/{id}
- POST /logout
- POST /votes
- POST /comments
- GET  /comments/{reportId}

VIEW HIERARCHY:
layouts/
├── app.blade.php (main layout)
│
auth/
├── simple_login.blade.php (default login)
├── login.blade.php (future)
└── register.blade.php (future)

pages/
├── homepage.blade.php (not authenticated)
├── homepage_auth.blade.php (authenticated - main feed)
├── profile.blade.php
├── my_reports.blade.php
└── create_report.blade.php

reports/
├── show.blade.php (detail page)
└── index.blade.php (all reports)

// ============================================
// 5. FEATURE IMPLEMENTATION STATUS
// ============================================

✅ COMPLETE & TESTED:
- User database with 5 test users
- Category seeding (10 categories)
- Report creation & storage
- Session-based authentication
- Image upload & storage to storage/reports/
- Homepage display with real database data
- Top voted reports sidebar (calculated from votes)
- Trending categories sidebar (7-day window)
- User profile page
- My reports page
- Logout functionality

🔄 IN PROGRESS:
- Voting UI on report detail page
- Comments UI on report detail page
- Implement Vote.store() endpoint for frontend

❌ NOT STARTED:
- Admin dashboard
- Email notifications
- Advanced search/filtering
- Real-time updates
- Report status workflow
- Solution proposals

// ============================================
// 6. ERROR HANDLING & VALIDATION
// ============================================

DATABASE LEVEL:
- Foreign key constraints (CASCADE/SET NULL)
- UNIQUE constraints (email, name for categories)
- NOT NULL constraints on required fields
- DEFAULT values for status, votes

APPLICATION LEVEL:
- Request validation in all controllers
- Session existence checks
- Try-catch blocks for exception handling
- Graceful error messages to user

FALLBACK STRATEGY:
- Session-based auth ALWAYS from local DB
- No API dependency for core features
- Report creation saves to local DB immediately
- Optional: Future API sync can happen asynchronously

// ============================================
// 7. MIGRATION STRATEGY
// ============================================

Migration Files (CLEAN & ORDERED):
├── 0001_01_01_000001_create_cache_table.php
├── 2025_01_01_000001_create_users_table.php
├── 2025_01_01_000002_create_categories_table.php (+ icon column)
├── 2025_01_01_000003_create_reports_table.php (status as VARCHAR, not ENUM)
├── 2025_01_01_000004_create_comments_table.php
├── 2025_01_01_000005_create_solutions_table.php
├── 2025_01_01_000006_create_votes_table.php (Polymorphic)
├── 2025_01_01_000007_create_sessions_table.php
├── 2025_01_01_000008_create_jobs_table.php
└── 2025_12_12_001_reset_database_schema.php (Placeholder for future)

DELETED (Conflicting/Obsolete):
- 2025_12_01_031338_update_categories_to_indonesian.php (redundant)
- 2025_12_01_031825_populate_report_images.php (handled by seeder)
- 2025_12_07_231341_update_reports_status_to_indonesian.php (redundant)
- 2025_12_12_ensure_reports_columns.php (bad fix)
- 2025_12_12_fix_reports_table.php (bad fix)

MIGRATION DISCIPLINE:
- Each migration should be idempotent
- Use Schema::dropIfExists() only for RESETS, not rollback
- Document breaking changes
- Test both up() and down()

// ============================================
// 8. SEEDING & TEST DATA
// ============================================

DatabaseSeeder::run():
├── seedUsers()
│   ├── Seprian Siagian (user)
│   ├── Budi Santoso (user)
│   ├── Ani Wijaya (user)
│   ├── Rini Kusuma (admin)
│   └── Admin (admin)
│
├── seedCategories()
│   ├── 10 Indonesian categories
│   ├── Each has name, slug, description, icon
│   └── Auto-generate slug from name
│
└── seedReports()
    ├── 5 reports with real content
    ├── Each has user, category, title, description, location
    ├── Status: 'Baru' or 'Diproses'
    ├── Upvotes/downvotes as initial data
    └── No images initially (user uploads will create them)

RUNNING SEEDERS:
php artisan db:seed                    // Run all seeders
php artisan db:seed --class=UserSeeder // Run specific seeder
php artisan migrate:fresh --seed       // Fresh DB + seed

// ============================================
// 9. STORAGE & FILES
// ============================================

IMAGE STORAGE:
- Directory: storage/reports/
- Access: asset('storage/reports/filename.jpg')
- Symlink: php artisan storage:link (if needed)
- Fallback: If URL detected, use as-is in image src

FILE UPLOAD FLOW:
1. Form: input type="file" name="image"
2. Controller: $image = $request->file('image')
3. Store: $path = $image->store('reports', 'public')
4. DB: Save relative path to reports.image column
5. View: Conditional display based on URL vs path

// ============================================
// 10. CODE QUALITY & MAINTENANCE
// ============================================

PATTERNS USED:
- MVC architecture (Model, View, Controller)
- Repository-like patterns in controllers
- Relationship loading (->with())
- Query optimization (indexed columns)
- Session-based state management
- Proper error handling & validation

CONSISTENCY RULES:
- All dates in database: timestamps (created_at, updated_at)
- All statuses in Indonesian
- All IDs are unsigned bigint (auto-increment)
- Use soft deletes if needed: SoftDeletes trait
- Foreign keys use CASCADE or SET NULL appropriately

TESTING FLOW:
1. Login as test user via /simple-login
2. Create report with image & all required fields
3. Check homepage for new report in feed
4. Check sidebar for top-voted reports
5. Click report to view detail page
6. Test voting/comments (endpoints ready)
7. Check my-reports page shows user's reports

// ============================================
// 11. DEPLOYMENT CHECKLIST
// ============================================

BEFORE PRODUCTION:
□ Change DB credentials (remove test values)
□ Generate APP_KEY: php artisan key:generate
□ Set APP_ENV=production in .env
□ Set APP_DEBUG=false
□ Setup proper logging
□ Create storage symlink: php artisan storage:link
□ Run migrations: php artisan migrate --force
□ Seed initial data if needed: php artisan db:seed
□ Clear caches: php artisan cache:clear
□ Setup HTTPS (SSL certificate)
□ Configure email (for notifications)
□ Implement rate limiting
□ Setup monitoring & alerts

// ============================================
// 12. FUTURE ROADMAP
// ============================================

PHASE 2 (API Integration):
- Implement real API calls to backend server
- Fallback to local DB if API fails
- Cache API responses
- Implement API rate limiting

PHASE 3 (Advanced Features):
- Voting system with UI
- Comments & replies
- Report solutions & proposals
- Admin dashboard
- Report workflow status
- Email notifications

PHASE 4 (Optimization):
- Pagination for feeds
- Search functionality
- Advanced filtering
- Real-time updates (WebSocket)
- Report analytics
- User reputation system

PHASE 5 (Security & Performance):
- Two-factor authentication
- API throttling
- DDoS protection
- Database query optimization
- Cache warming strategies
- CDN integration for images

// ============================================
// END OF ARCHITECTURE DOCUMENTATION
// ============================================
*/
