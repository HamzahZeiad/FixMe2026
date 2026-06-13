<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Timeline — AuthenticityHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a7fd0, #6bc5f3);
            min-height: 100vh;
            opacity: 0;
            animation: fadeIn 0.6s ease forwards;
        }
        @keyframes fadeIn { to { opacity: 1; } }

        /* Top Bar */
        .top-bar {
            position: fixed; top: 0; left: 0; right: 0; height: 56px;
            background: #d2dbf6; display: flex; align-items: center;
            padding: 0 2rem; z-index: 100; box-shadow: 0 2px 8px rgba(59,130,246,0.07);
        }
        .top-bar .logo { font-weight: 700; font-size: 1.3rem; color: #283d63; position: absolute; left: 2rem; }
        .user-info-topbar {
            display: flex; flex-direction: row-reverse; align-items: center;
            position: absolute; right: 2rem; top: 50%; transform: translateY(-50%);
        }
        .user-info-topbar .user-pic { width: 40px; height: 40px; border-radius: 50%; overflow: hidden; border: 2px solid #b9c8f6; margin-left: 0.7rem; background: #f3f4f6; }
        .user-info-topbar .user-pic img { width: 100%; height: 100%; object-fit: cover; }
        .user-info-topbar .user-name { font-size: 1rem; color: #283d63; font-weight: 600; text-align: right; }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 56px; left: 0; width: 14rem; height: calc(100vh - 56px);
            background: #d2dbf6; box-shadow: 0 4px 15px rgba(40,61,99,0.1);
            border-top-right-radius: 1.5rem; border-bottom-right-radius: 1.5rem;
            padding: 2rem 0; display: flex; flex-direction: column; gap: 1.5rem; z-index: 99;
        }
        .sidebar-nav { display: flex; flex-direction: column; gap: 1rem; padding: 0 1.5rem; flex: 1; }
        .sidebar-link {
            display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem;
            color: #283d63; text-decoration: none; font-weight: 500; border-radius: 0.75rem; transition: all 0.3s;
        }
        .sidebar-link:hover { background: #b9c8f6; color: #0057ff; transform: translateX(4px); }
        .sidebar-link.active { background: #b9c8f6; color: #0057ff; font-weight: 600; }

        /* Main */
        .main-content { margin-left: 14rem; margin-top: 56px; padding: 2rem; min-height: calc(100vh - 56px); }

        /* Card */
        .card { background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(40,61,99,0.1); margin-bottom: 1.5rem; }

        /* Status banner */
        .status-banner {
            display: flex; align-items: center; gap: 1rem; padding: 1.25rem 1.5rem;
            border-radius: 14px; margin-bottom: 1.5rem;
        }
        .status-banner .icon-wrap {
            width: 3rem; height: 3rem; border-radius: 12px; display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; color: white; flex-shrink: 0;
        }
        .status-banner .status-text { font-size: 1.1rem; font-weight: 700; }
        .status-banner .status-sub  { font-size: 0.8rem; margin-top: 1px; }
        .banner-submitted     { background: #fef9c3; } .banner-submitted     .icon-wrap { background: #eab308; }
        .banner-under-review  { background: #ede9fe; } .banner-under-review  .icon-wrap { background: #7c3aed; }
        .banner-assigned      { background: #e0e7ff; } .banner-assigned      .icon-wrap { background: #4f46e5; }
        .banner-in-progress   { background: #dbeafe; } .banner-in-progress   .icon-wrap { background: #2563eb; }
        .banner-clarification { background: #fff7ed; } .banner-clarification .icon-wrap { background: #ea580c; }
        .banner-resolved      { background: #dcfce7; } .banner-resolved      .icon-wrap { background: #16a34a; }
        .banner-closed        { background: #ccfbf1; } .banner-closed        .icon-wrap { background: #0d9488; }
        .banner-rejected      { background: #fee2e2; } .banner-rejected      .icon-wrap { background: #dc2626; }

        /* Timeline */
        .timeline { position: relative; padding-left: 2rem; }
        .timeline::before {
            content: ''; position: absolute; left: 11px; top: 0; bottom: 0; width: 2px;
            background: linear-gradient(to bottom, #d2dbf6, #b9c8f6);
        }
        .timeline-item { position: relative; margin-bottom: 1.5rem; }
        .timeline-dot {
            position: absolute; left: -2rem; top: 0.2rem;
            width: 1.5rem; height: 1.5rem; border-radius: 50%; border: 3px solid white;
            box-shadow: 0 0 0 2px #d2dbf6; display: flex; align-items: center; justify-content: center;
            font-size: 0.55rem; color: white;
        }
        .timeline-card {
            background: #f8faff; border-radius: 12px; padding: 1rem 1.25rem;
            border-left: 3px solid transparent; transition: all 0.2s;
        }
        .timeline-card:hover { transform: translateX(3px); box-shadow: 0 4px 12px rgba(40,61,99,0.08); }
        .timeline-top { display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; flex-wrap: wrap; }
        .timeline-badge {
            padding: 0.2rem 0.75rem; border-radius: 100px; font-size: 0.72rem; font-weight: 700;
        }
        .timeline-actor { font-size: 0.78rem; color: #6b7280; }
        .timeline-time  { font-size: 0.72rem; color: #9ca3af; white-space: nowrap; }
        .timeline-notes { margin-top: 0.5rem; font-size: 0.85rem; color: #374151; line-height: 1.6; }

        /* Info grid */
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .info-item { }
        .info-label { font-size: 0.75rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem; }
        .info-value { font-size: 0.9rem; color: #111; font-weight: 500; }
        @media (max-width: 640px) { .info-grid { grid-template-columns: 1fr; } }

        /* Buttons */
        .btn-back {
            display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.25rem;
            background: linear-gradient(145deg, #d1d9f0, #a6b1d7); border-radius: 0.75rem;
            color: #283d63; font-weight: 600; text-decoration: none; font-size: 0.875rem;
            box-shadow: 4px 4px 8px #9badcd,-4px -4px 8px #fff; transition: all 0.2s;
        }
        .btn-back:hover { transform: translateY(-1px); }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>
        <div class="user-info-topbar">
            @auth
                <div class="user-pic">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->UserName) }}&background=cccccc&color=555555" alt="Profile">
                </div>
                <div class="user-name">{{ Auth::user()->UserName }}</div>
            @endauth
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('public.user.home') }}" class="sidebar-link"><i class="fas fa-home"></i><span>Home</span></a>
            <a href="{{ route('inquiries.index') }}" class="sidebar-link active"><i class="fas fa-clipboard-list"></i><span>Inquiry List</span></a>
            <a href="{{ route('submit.inquiry') }}" class="sidebar-link"><i class="fas fa-edit"></i><span>Submit Inquiry</span></a>
            @auth
                <a href="{{ route('manage.profile') }}" class="sidebar-link"><i class="fas fa-user"></i><span>Manage Profile</span></a>
            @endauth
            <div style="flex:1"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link" style="background:none;border:none;width:100%;text-align:left;cursor:pointer;">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">

        <!-- Back Button -->
        <div style="margin-bottom:1.25rem;">
            <a href="{{ route('inquiries.show', $inquiry->InquiryID) }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Details
            </a>
        </div>

        <!-- Status Banner -->
        @php
            $bannerMap = [
                'Submitted'             => ['banner-submitted',     'file-alt',       '#eab308', 'Your inquiry has been received and is awaiting admin review.'],
                'Under Review'          => ['banner-under-review',  'eye',            '#7c3aed', 'An administrator is currently reviewing your inquiry.'],
                'Assigned'              => ['banner-assigned',      'paper-plane',    '#4f46e5', 'Your inquiry has been assigned to a specialist agency.'],
                'In Progress'           => ['banner-in-progress',   'search',         '#2563eb', 'The agency is actively investigating your inquiry.'],
                'Pending Clarification' => ['banner-clarification',  'question-circle','#ea580c', 'The agency has requested additional information from you.'],
                'Resolved'              => ['banner-resolved',      'check-circle',   '#16a34a', 'Your inquiry has been resolved by the assigned agency.'],
                'Closed'                => ['banner-closed',        'lock',           '#0d9488', 'Your inquiry has been closed.'],
                'Rejected'              => ['banner-rejected',      'times-circle',   '#dc2626', 'Your inquiry has been rejected. See the notes below for details.'],
            ];
            [$bannerClass, $bannerIcon, $bannerColor, $bannerMsg] = $bannerMap[$inquiry->InquiryStatus] ?? ['banner-submitted', 'circle', '#6b7280', ''];
        @endphp
        <div class="status-banner {{ $bannerClass }}">
            <div class="icon-wrap">
                <i class="fas fa-{{ $bannerIcon }}"></i>
            </div>
            <div>
                <div class="status-text" style="color:{{ $bannerColor }};">{{ $inquiry->InquiryStatus }}</div>
                <div class="status-sub" style="color:{{ $bannerColor }};">{{ $bannerMsg }}</div>
            </div>
        </div>

        <!-- Inquiry Summary Card -->
        <div class="card">
            <div style="font-size:1rem;font-weight:700;color:#283d63;margin-bottom:1rem;">
                <i class="fas fa-info-circle" style="color:#6a7fd0;margin-right:0.4rem;"></i>
                Inquiry #{{ $inquiry->InquiryID }} — {{ $inquiry->InquiryTitle }}
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Submitted</div>
                    <div class="info-value">{{ $inquiry->InquirySendDate?->format('M j, Y g:i A') ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Assigned Agency</div>
                    <div class="info-value">{{ $inquiry->agency?->AgencyName ?? '— Pending assignment —' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">News Source</div>
                    <div class="info-value">{{ $inquiry->InquirySource ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Last Updated</div>
                    <div class="info-value">{{ $inquiry->updated_at?->diffForHumans() ?? 'N/A' }}</div>
                </div>
            </div>
            @if($inquiry->VerificationDescription)
                <div style="margin-top:1rem;padding:0.9rem 1rem;background:#f0fdf4;border-radius:10px;border-left:3px solid #16a34a;">
                    <div style="font-size:0.75rem;font-weight:700;color:#16a34a;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">
                        <i class="fas fa-comment-dots"></i> Verification / Resolution Notes
                    </div>
                    <div style="font-size:0.875rem;color:#374151;">{{ $inquiry->VerificationDescription }}</div>
                </div>
            @endif
        </div>

        <!-- Timeline / Communication Log -->
        <div class="card">
            <div style="font-size:1rem;font-weight:700;color:#283d63;margin-bottom:1.5rem;">
                <i class="fas fa-history" style="color:#6a7fd0;margin-right:0.4rem;"></i>
                Inquiry Timeline — Communication Log
            </div>

            @if($inquiry->statusLogs->isEmpty())
                <!-- Synthesise initial log from inquiry data -->
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot" style="background:#6a7fd0;">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="timeline-card" style="border-color:#6a7fd0;">
                            <div class="timeline-top">
                                <span class="timeline-badge" style="background:#dbeafe;color:#1d4ed8;">Submitted</span>
                                <span class="timeline-actor">Submitted by you</span>
                                <span class="timeline-time">{{ $inquiry->InquirySendDate?->format('M j, Y g:i A') }}</span>
                            </div>
                            <div class="timeline-notes">Your inquiry was successfully submitted and is awaiting admin review.</div>
                        </div>
                    </div>
                </div>
                <div style="text-align:center;padding:1.5rem 0;color:#9ca3af;font-size:0.875rem;">
                    <i class="fas fa-info-circle" style="margin-right:0.35rem;"></i>
                    Status updates will appear here as your inquiry progresses.
                </div>
            @else
                <div class="timeline">
                    <!-- Initial submission node -->
                    <div class="timeline-item">
                        <div class="timeline-dot" style="background:#6a7fd0;">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="timeline-card" style="border-color:#6a7fd0;">
                            <div class="timeline-top">
                                <span class="timeline-badge" style="background:#dbeafe;color:#1d4ed8;">Submitted</span>
                                <span class="timeline-actor">Submitted by you</span>
                                <span class="timeline-time">{{ $inquiry->InquirySendDate?->format('M j, Y g:i A') }}</span>
                            </div>
                            <div class="timeline-notes">Your inquiry was submitted successfully.</div>
                        </div>
                    </div>

                    @foreach($inquiry->statusLogs as $log)
                        @php
                            $dotColors = [
                                'Assigned'              => '#8b5cf6',
                                'In Progress'           => '#2563eb',
                                'Pending Clarification' => '#ea580c',
                                'Resolved'              => '#16a34a',
                                'Closed'                => '#0d9488',
                                'Rejected'              => '#dc2626',
                                'Under Review'          => '#7c3aed',
                            ];
                            $dc = $dotColors[$log->status] ?? '#6b7280';
                            $icons = [
                                'Assigned'              => 'paper-plane',
                                'In Progress'           => 'search',
                                'Pending Clarification' => 'question',
                                'Resolved'              => 'check',
                                'Closed'                => 'lock',
                                'Rejected'              => 'times',
                                'Under Review'          => 'eye',
                            ];
                            $ico = $icons[$log->status] ?? 'circle';
                            $bgColors = [
                                'Assigned'              => 'background:#ede9fe;color:#7c3aed;',
                                'In Progress'           => 'background:#dbeafe;color:#1d4ed8;',
                                'Pending Clarification' => 'background:#fff7ed;color:#c2410c;',
                                'Resolved'              => 'background:#dcfce7;color:#15803d;',
                                'Closed'                => 'background:#ccfbf1;color:#0d9488;',
                                'Rejected'              => 'background:#fee2e2;color:#b91c1c;',
                                'Under Review'          => 'background:#ede9fe;color:#7c3aed;',
                            ];
                            $bs = $bgColors[$log->status] ?? 'background:#f3f4f6;color:#374151;';
                            $actorLabel = $log->actor_type === 'agency' ? '🏛️ Agency' : ($log->actor_type === 'admin' ? '👤 Admin' : '⚙️ System');
                        @endphp
                        <div class="timeline-item">
                            <div class="timeline-dot" style="background:{{ $dc }};">
                                <i class="fas fa-{{ $ico }}"></i>
                            </div>
                            <div class="timeline-card" style="border-color:{{ $dc }};">
                                <div class="timeline-top">
                                    <span class="timeline-badge" style="{{ $bs }}">{{ $log->status }}</span>
                                    <span class="timeline-actor">
                                        {{ $actorLabel }}
                                        @if($log->actor_name) · {{ $log->actor_name }} @endif
                                    </span>
                                    <span class="timeline-time">{{ $log->created_at?->format('M j, Y g:i A') }}</span>
                                </div>
                                @if($log->notes)
                                    <div class="timeline-notes">{{ $log->notes }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</body>
</html>
