# TESTING GUIDE - LAPORINAJA

## Quick Start (5 menit)

### Step 1: Access Simple Login
1. Open: http://127.0.0.1:8000/simple-login
2. Select user: "Seprian Siagian (seprian@test.com)"
3. Click "Login"
4. Redirect to homepage → You should see feed with 5 test reports

### Step 2: View Homepage
- **Feed:** 5 test reports displayed
- **Sidebar - Masalah Penting:**
  - Report "Air Sumur Tercemar Oli" - 12 Votes (highest)
  - Report "Sampah Tidak Diangkut Seminggu" - 8 Votes
  - Report "Lampu Taman Mati" - 6 Votes
  - Report "Lubang di Jalan Utama" - 5 Votes
  - Report "Macet Parah" - 3 Votes
- **Sidebar - Masalah Trending:**
  - Kategori dari 5 reports yang ada
  - Badge showing severity (Urgent/Medium/Low)

### Step 3: Create New Report
1. Click "Laporan Baru" button
2. Fill form:
   - **Judul:** "Test Laporan - [Your name]"
   - **Deskripsi:** "Ini adalah test report untuk verifikasi sistem"
   - **Lokasi:** "Lokasi Test"
   - **Kategori:** Select any
   - **Gambar:** Upload optional
3. Click "Post"
4. Redirect to homepage
5. **VERIFY:** Your new report appears in feed at top

### Step 4: My Reports Page
1. Click "Laporan Saya" in sidebar
2. Should see:
   - All 5 test reports (from seeder)
   - Your newly created report
   - Total count matches

### Step 5: Profile Page
1. Click "Profil" in sidebar
2. View user information:
   - Name: Seprian Siagian
   - Email: seprian@test.com
   - Phone, Bio, Address displayed

### Step 6: Logout
1. Click "Logout" button
2. Session cleared
3. Redirected to homepage (not authenticated)

---

## Test Scenarios

### Scenario A: Create Report dengan Image
**Expected:** Image display di feed + stored di storage/reports/
```
1. Buat report baru dengan image
2. Check storage/reports/ folder
3. Check homepage - image visible
4. Check DB - image column has path
```

### Scenario B: Multiple Users
**Expected:** Reports dari user berbeda visible
```
1. Login as Seprian (create 2 reports)
2. Logout
3. Login as Budi (create 1 report)
4. Check feed shows reports dari semua users
5. Check My Reports - only shows own reports
```

### Scenario C: Voting System (Future)
**Expected:** Vote count increase/decrease
```
1. Create report
2. POST /votes with upvote=true
3. Check report.upvotes incremented
4. Check Vote table has record
```

### Scenario D: Comments (Future)
**Expected:** Comments visible on detail page
```
1. Go to /reports/{id}
2. POST /comments to create comment
3. Check GET /comments/{id} returns comments
```

---

## Database Verification

### Check Users
```sql
SELECT id, name, email, role FROM users;
-- Should show 5 users
```

### Check Reports
```sql
SELECT id, user_id, category_id, title, status, upvotes FROM reports;
-- Should show 5 initial + any new ones created
```

### Check Votes
```sql
SELECT id, user_id, votable_id, is_upvote FROM votes;
-- Should be empty initially (tests can add)
```

### Check Session
```php
// In controller:
dd(session()->all());
// Should show user array and authenticated flag
```

---

## Common Issues & Fixes

### Issue: "Page not found" or 404
**Fix:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Issue: "Laporan Baru button tidak bekerja"
**Fix:** Check if authenticated
```php
session('authenticated') // Should be true
```

### Issue: "Image tidak muncul"
**Fix:** Check image path
```php
// In storage/app/public/reports/ folder
// Check storage symlink: php artisan storage:link
```

### Issue: "Cannot find route 'simple-login'"
**Fix:** Regenerate routes
```bash
php artisan route:cache
php artisan route:clear
```

---

## Performance Baseline

**Target Response Times:**
- Homepage load: < 500ms
- Report create: < 1s
- Image upload (5MB): < 3s

**Query Optimization:**
- Homepage uses indexed queries on (user_id, created_at)
- Votes count using aggregation
- Trending uses 7-day filter with grouping

---

## Manual Test Checklist

- [ ] Login dengan /simple-login works
- [ ] Homepage show 5 test reports
- [ ] Sidebar "Masalah Penting" shows reports sorted by votes
- [ ] Sidebar "Masalah Trending" shows trending categories
- [ ] Create report dengan title, description, location
- [ ] Create report dengan image (image stored & displayed)
- [ ] My Reports shows only user's reports
- [ ] Profile page shows user info
- [ ] Logout works
- [ ] Login as different user works
- [ ] Feed shows reports dari multiple users
- [ ] Vote endpoints return 200 (via API testing)
- [ ] Comment endpoints return 200 (via API testing)

---

## API Testing (cURL / Postman)

### Create Vote
```bash
curl -X POST http://127.0.0.1:8000/votes \
  -H "Content-Type: application/json" \
  -H "Cookie: LARAVEL_SESSION=..." \
  -d '{
    "votable_id": 1,
    "votable_type": "App\\Models\\Report",
    "is_upvote": true
  }'
```

### Create Comment
```bash
curl -X POST http://127.0.0.1:8000/comments \
  -H "Content-Type: application/json" \
  -H "Cookie: LARAVEL_SESSION=..." \
  -d '{
    "report_id": 1,
    "content": "Great report!"
  }'
```

### Get Comments
```bash
curl http://127.0.0.1:8000/comments/1
```

---

## Deployment Testing

Before deploying to production:

1. **Database:** 
   - [ ] Migrations run successfully
   - [ ] Seeders populate test data
   - [ ] Foreign keys intact

2. **Authentication:**
   - [ ] Session works
   - [ ] Logout clears session
   - [ ] Multiple users can login

3. **File Upload:**
   - [ ] storage/ directory writable
   - [ ] Images stored correctly
   - [ ] Symlink created: `php artisan storage:link`

4. **Performance:**
   - [ ] No N+1 queries (use ->with())
   - [ ] Indexes on frequently queried columns
   - [ ] Cache warming for static data

5. **Security:**
   - [ ] Input validation on all forms
   - [ ] CSRF protection enabled
   - [ ] Rate limiting configured
   - [ ] XSS protection in blade templates

---

## Test Users

| Email | Password | Role | Notes |
|-------|----------|------|-------|
| seprian@test.com | password | user | Reputation: 45 |
| budi@test.com | password | user | Reputation: 32 |
| ani@test.com | password | user | Reputation: 28 |
| rini@test.com | password | admin | Reputation: 100 |
| admin@test.com | admin123 | admin | Reputation: 150 |

---

## Test Reports (Seeded)

| ID | Title | Category | User | Status | Votes |
|----|----|---|---|---|---|
| 1 | Lubang di Jalan Utama | Jalan Rusak | Seprian | Baru | 5 ↑ |
| 2 | Sampah Tidak Diangkut | Sampah | Budi | Diproses | 8 ↑ |
| 3 | Air Sumur Tercemar Oli | Air Kotor | Ani | Baru | 12 ↑ |
| 4 | Lampu Taman Mati | Fasilitas | Seprian | Diproses | 6 ↑ |
| 5 | Macet Parah Jam 5-6 | Kemacetan | Budi | Baru | 3 ↑ |

---

## Success Criteria

All tests PASS if:
✅ Homepage displays without errors
✅ Authentication works with test users
✅ Reports display real data (not dummy)
✅ Sidebar shows correct vote counts
✅ New reports immediately appear after creation
✅ Images upload and display
✅ User can only see own reports in "My Reports"
✅ Logout clears session
✅ Multiple users can login
✅ All database constraints intact
✅ No SQL errors in logs

---

**Last Updated:** 12 December 2025
**Status:** READY FOR QA TESTING
