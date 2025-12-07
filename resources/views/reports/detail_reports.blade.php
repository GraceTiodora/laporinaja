@extends('layouts.app')

@section('title', 'Detail Laporan - LaporinAja')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/detail_reports.css') }}">
@endpush

@section('content')
<div class="container-main">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <span class="brand">Laporin</span>Aja
            </div>
            <ul class="sidebar-menu">
                <li><a href="#"><i class="fa-solid fa-house"></i> Home</a></li>
                <li><a href="#"><i class="fa-solid fa-hashtag"></i> Explore</a></li>
                <li><a href="#"><i class="fa-regular fa-bell"></i> Notification</a></li>
                <li><a href="#"><i class="fa-regular fa-envelope"></i> Messages</a></li>
                <li><a href="#"><i class="fa-solid fa-clipboard-list"></i> My Reports</a></li>
                <li><a href="#"><i class="fa-solid fa-users"></i> Communities</a></li>
                <li><a href="#"><i class="fa-regular fa-user"></i> Profile</a></li>
                <li><a href="#"><i class="fa-solid fa-ellipsis-h"></i> More</a></li>
            </ul>
        </aside>
 
        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <a href="#" class="back-btn">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </header>

            <div class="content">
                <!-- Report Section -->
                <div class="report-section">
                    <div class="report-author">
                        <div class="author-avatar">A</div>
                        <div class="author-info">
                            <h4>Audrey Black</h4>
                            <p>@audreyblack • 1 min agao</p>
                        </div>
                    </div>

                    <p class="report-description-text">
                        Jalan berlubang besar di Jl. Melati, sangat membahayakan kendaraan roda dua. Lubang ini sudah ada sejak 3 minggu lalu dan belum diperbaiki. Mohon segera ditangani lebih cepat sebelum menimbulkan kecelakaan yang lebih parah.
                    </p>

                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='600' height='400'%3E%3Crect fill='%23ccc' width='600' height='400'/%3E%3C/svg%3E" alt="Report Image" class="report-image">

                    <div class="report-meta">
                        <div class="meta-item">
                            <i class="fa-solid fa-location-dot"></i>
                            Jalan Melati
                        </div>
                        <div class="meta-item">
                            <span class="meta-status-badge">Baru</span>
                        </div>
                    </div>
                </div>

                <!-- Voting Section -->
                <div class="voting-section">
                    <div class="voting-title">
                        <i class="fa-solid fa-thumbs-up"></i> Apakah menurut anda ini penting?
                    </div>

                    <div class="vote-buttons">
                        <button class="vote-btn penting">
                            <i class="fa-solid fa-thumbs-up"></i>
                            Penting
                        </button>
                        <button class="vote-btn tidak-penting">
                            <i class="fa-solid fa-thumbs-down"></i>
                            Tidak Penting
                        </button>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="comments-section">
                    <h3 class="comments-title">
                        <i class="fa-solid fa-comments"></i> Komentar (3)
                    </h3>

                    <div class="comment-form">
                        <textarea class="comment-input" placeholder="Berikan komentar Anda..."></textarea>
                        <button type="button">
                            <i class="fa-solid fa-paper-plane"></i> Kirim
                        </button>
                    </div>

                    <div class="comments-list">
                        <div class="comment-item">
                            <div class="comment-avatar">J</div>
                            <div class="comment-content">
                                <div class="comment-header">
                                    <span class="comment-author">Jerinta Kari</span>
                                    <span class="comment-time">3 jam</span>
                                </div>
                                <p class="comment-text">
                                    Saya juga pernah lewat sini setidak raja... Lubang tersebut memang sangat besar dan sungguh membahayakan. Mohon juga segerakan proses perbaikan agar tidak terjadi kecelakaan.
                                </p>
                                <div class="comment-likes">
                                    <i class="fa-solid fa-thumbs-up"></i> 1
                                </div>
                            </div>
                        </div>

                        <div class="comment-item">
                            <div class="comment-avatar">J</div>
                            <div class="comment-content">
                                <div class="comment-header">
                                    <span class="comment-author">Jerinta Kari</span>
                                    <span class="comment-time">3 jam</span>
                                </div>
                                <p class="comment-text">
                                    Saya juga pernah lewat sini setidak raja... Lubang tersebut memang sangat besar dan sungguh membahayakan. Mohon juga segerakan proses perbaikan agar tidak terjadi kecelakaan.
                                </p>
                                <div class="comment-likes">
                                    <i class="fa-solid fa-thumbs-up"></i> 1
                                </div>
                            </div>
                        </div>

                        <div class="comment-item">
                            <div class="comment-avatar">J</div>
                            <div class="comment-content">
                                <div class="comment-header">
                                    <span class="comment-author">Jerinta Kari</span>
                                    <span class="comment-time">3 jam</span>
                                </div>
                                <p class="comment-text">
                                    Saya juga pernah lewat sini setidak raja... Lubang tersebut memang sangat besar dan sungguh membahayakan. Mohon juga segerakan proses perbaikan agar tidak terjadi kecelakaan.
                                </p>
                                <div class="comment-likes">
                                    <i class="fa-solid fa-thumbs-up"></i> 1
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </main>
</div>
@endsection