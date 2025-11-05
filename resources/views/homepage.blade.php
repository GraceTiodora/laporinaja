{{-- resources/views/homepage.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Laporin Aja</title>
    <style>
        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
            line-height: 1.5;
        }

        /* Container Layout */
        .container {
            display: flex;
            height: 100vh;
            max-width: 1920px;
            margin: 0 auto;
        }

        /* Left Sidebar */
        .sidebar-left {
            width: 280px;
            background-color: #ffffff;
            border-right: 1px solid #e5e7eb;
            padding: 20px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .logo h2 {
            font-size: 24px;
            font-weight: 700;
            color: #3b82f6;
            margin-bottom: 30px;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 16px;
            border-radius: 8px;
            color: #4b5563;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-item:hover {
            background-color: #f3f4f6;
            color: #1f2937;
        }

        .nav-item.active {
            background-color: #eff6ff;
            color: #3b82f6;
        }

        .nav-item .icon {
            font-size: 20px;
        }

        .btn-new-report {
            margin-top: 20px;
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 24px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-new-report:hover {
            background-color: #2563eb;
        }

        .user-profile {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar-small {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: #1f2937;
        }

        .username {
            font-size: 13px;
            color: #6b7280;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border-right: 1px solid #e5e7eb;
        }

        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
        }

        .btn-post {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-post:hover {
            background-color: #2563eb;
        }

        .feed {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        /* Post Input Card */
        .post-input-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .input-post {
            flex: 1;
            border: none;
            outline: none;
            font-size: 14px;
            color: #9ca3af;
        }

        .post-actions {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 12px 12px;
            padding: 12px 16px;
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 20px;
            margin-top: -12px;
        }

        .action-btn {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: background-color 0.2s;
        }

        .action-btn:hover {
            background-color: #f3f4f6;
        }

        .btn-post-submit {
            margin-left: auto;
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-post-submit:hover {
            background-color: #2563eb;
        }

        /* Post Card */
        .post-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .post-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .post-user-info {
            flex: 1;
        }

        .post-user-details {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .post-username {
            font-weight: 600;
            font-size: 15px;
            color: #1f2937;
        }

        .post-time {
            font-size: 13px;
            color: #6b7280;
        }

        .post-text {
            font-size: 14px;
            color: #374151;
            margin-bottom: 12px;
            line-height: 1.6;
        }

        .post-image {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 12px;
            object-fit: cover;
            max-height: 400px;
        }

        .post-tags {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
        }

        .tag {
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 500;
        }

        .tag-new {
            background-color: #fce7f3;
            color: #be185d;
        }

        .tag-category {
            background-color: #e0e7ff;
            color: #4338ca;
        }

        .post-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            border-top: 1px solid #f3f4f6;
        }

        .post-stats {
            display: flex;
            gap: 16px;
            font-size: 14px;
            color: #6b7280;
        }

        /* Right Sidebar */
        .sidebar-right {
            width: 320px;
            background-color: #ffffff;
            padding: 24px;
            overflow-y: auto;
        }

        .sidebar-section {
            margin-bottom: 32px;
        }

        .sidebar-section h2 {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 16px;
        }

        /* Urgent List */
        .urgent-list {
            list-style: none;
        }

        .urgent-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .urgent-item:last-child {
            border-bottom: none;
        }

        .urgent-title {
            font-size: 14px;
            font-weight: 500;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .urgent-location {
            font-size: 13px;
            color: #6b7280;
        }

        .urgent-votes {
            font-size: 14px;
            font-weight: 600;
            color: #dc2626;
        }

        /* Trending List */
        .trending-list {
            list-style: none;
        }

        .trending-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .trending-item:last-child {
            border-bottom: none;
        }

        .trending-title {
            font-size: 14px;
            font-weight: 500;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .trending-subtitle {
            font-size: 12px;
            color: #6b7280;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-urgent {
            background-color: #fce7f3;
            color: #be185d;
        }

        .badge-medium {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-low {
            background-color: #dbeafe;
            color: #1e40af;
        }

        /* Scrollbar Styling */
        .sidebar-left::-webkit-scrollbar,
        .main-content::-webkit-scrollbar,
        .sidebar-right::-webkit-scrollbar,
        .feed::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-left::-webkit-scrollbar-track,
        .main-content::-webkit-scrollbar-track,
        .sidebar-right::-webkit-scrollbar-track,
        .feed::-webkit-scrollbar-track {
            background: #f3f4f6;
        }

        .sidebar-left::-webkit-scrollbar-thumb,
        .main-content::-webkit-scrollbar-thumb,
        .sidebar-right::-webkit-scrollbar-thumb,
        .feed::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .sidebar-right {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .sidebar-left {
                width: 80px;
            }
            
            .sidebar-left .nav-item span:not(.icon) {
                display: none;
            }
            
            .logo h2 {
                font-size: 18px;
            }
            
            .user-info {
                display: none;
            }
            
            .btn-new-report {
                padding: 12px;
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Sidebar -->
        <aside class="sidebar-left">
            <div class="logo">
                <h2>LaporinAja</h2>
            </div>
            <nav class="nav-menu">
                <a href="#" class="nav-item active">
                    <span class="icon">🏠</span>
                    <span>Home</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon">#</span>
                    <span>Explore</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon">🔔</span>
                    <span>Notification</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon">💬</span>
                    <span>Messages</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon">📋</span>
                    <span>My Reports</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon">👥</span>
                    <span>Communities</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon">👤</span>
                    <span>Profile</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon">⚙️</span>
                    <span>More</span>
                </a>
            </nav>
            <button class="btn-new-report">+ New Report</button>
            <div class="user-profile">
                <img src="{{ asset('images/profile-user.jpg') }}" alt="User" class="user-avatar-small">
                <div class="user-info">
                    <p class="user-name">User</p>
                    <p class="username">username</p>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <header class="header">
                <h1>Home</h1>
            </header>

            <div class="feed">
                <!-- Post Input -->
                <div class="post-input-card">
                    <img src="{{ asset('images/profile-user.jpg') }}" alt="User" class="user-avatar">
                    <input type="text" placeholder="Laporkan masalah di lingkunganmu..." class="input-post">
                </div>
                <div class="post-actions">
                    <button class="action-btn">📷</button>
                    <button class="action-btn">🖼️</button>
                    <button class="action-btn">📍</button>
                    <button class="action-btn">🏷️</button>
                    <button class="action-btn">✏️</button>
                    <button class="btn-post-submit">Post</button>
                </div>

                <!-- Recent Report 1 - Audrey Stark -->
                <article class="post-card">
                    <div class="post-header">
                        <img src="{{ asset('images/profile-audrey.jpg') }}" alt="Audrey Stark" class="user-avatar">
                        <div class="post-user-info">
                            <div class="post-user-details">
                                <span class="post-username">Audrey Stark</span>
                                <span class="post-time">2 jam • Jl. Melati</span>
                            </div>
                        </div>
                    </div>
                    <p class="post-text">Jalan berlubang besar dekat sekolah...</p>
                    <img src="{{ asset('images/jalan_berlubang.jpg') }}" alt="Jalan Berlubang" class="post-image">
                    <div class="post-tags">
                        <span class="tag tag-new">Baru</span>
                        <span class="tag tag-category">Infrastruktur</span>
                    </div>
                    <div class="post-footer">
                        <div class="post-stats">
                            <span>🗨️ 3</span>
                            <span>❤️ 10</span>
                        </div>
                    </div>
                </article>

                <!-- Recent Report 2 - David Blend -->
                <article class="post-card">
                    <div class="post-header">
                        <img src="{{ asset('images/profile-david.jpg') }}" alt="David Blend" class="user-avatar">
                        <div class="post-user-info">
                            <div class="post-user-details">
                                <span class="post-username">David Blend</span>
                                <span class="post-time">12 menit • Jl. Ahmad Yani</span>
                            </div>
                        </div>
                    </div>
                    <p class="post-text">Sebuah pohon besar tumbang menutupi jalan raya, menyebabkan kemacetan parah. Mohon segera ditangani agar jalan bisa dilewati kembali.</p>
                    <img src="{{ asset('images/pohon-tumbang.jpg') }}" alt="Pohon Tumbang" class="post-image">
                    <div class="post-tags">
                        <span class="tag tag-new">Baru</span>
                        <span class="tag tag-category">Bencana Alam</span>
                    </div>
                    <div class="post-footer">
                        <div class="post-stats">
                            <span>🗨️ 1</span>
                            <span>❤️ 5</span>
                        </div>
                    </div>
                </article>
            </div>
        </main>

        <!-- Right Sidebar -->
        <aside class="sidebar-right">
            <section class="sidebar-section">
                <h2>Masalah Urgent</h2>
                <ul class="urgent-list">
                    <li class="urgent-item">
                        <div>
                            <p class="urgent-title">Jalan Rusak</p>
                            <p class="urgent-location">Jl. Melati</p>
                        </div>
                        <span class="urgent-votes">128 Votes</span>
                    </li>
                    <li class="urgent-item">
                        <div>
                            <p class="urgent-title">Sampah Menumpuk</p>
                            <p class="urgent-location">Pasar Baru</p>
                        </div>
                        <span class="urgent-votes">96 Votes</span>
                    </li>
                    <li class="urgent-item">
                        <div>
                            <p class="urgent-title">Lampu Jalan Mati</p>
                            <p class="urgent-location">RT 05</p>
                        </div>
                        <span class="urgent-votes">54 Votes</span>
                    </li>
                </ul>
            </section>

            <section class="sidebar-section">
                <h2>Masalah Trending</h2>
                <ul class="trending-list">
                    <li class="trending-item">
                        <div>
                            <p class="trending-title">Infrastruktur Jalan</p>
                            <p class="trending-subtitle">5 laporan hari ini</p>
                        </div>
                        <span class="badge badge-urgent">Urgent</span>
                    </li>
                    <li class="trending-item">
                        <div>
                            <p class="trending-title">Sampah Menumpuk</p>
                            <p class="trending-subtitle">Pasar Baru</p>
                        </div>
                        <span class="badge badge-medium">Medium</span>
                    </li>
                    <li class="trending-item">
                        <div>
                            <p class="trending-title">Lampu Jalan Mati</p>
                            <p class="trending-subtitle">RT 05</p>
                        </div>
                        <span class="badge badge-low">Low</span>
                    </li>
                </ul>
            </section>
        </aside>
    </div>
</body>
</html>