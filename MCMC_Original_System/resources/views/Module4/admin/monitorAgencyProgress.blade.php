<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Monitor agency inquiry progress and system performance">
    <title>Monitor Agency Progress | AuthenticityHub Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; min-height: 100vh; }

        /* Top Bar */
        .top-bar {
            position: fixed; top: 0; left: 0; right: 0; height: 56px;
            background: #111; display: flex; align-items: center;
            padding: 0 1.5rem; z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        .top-bar .logo { font-weight: 800; font-size: 1.2rem; color: #fff; letter-spacing: -0.025em; }
        .top-bar .admin-badge {
            margin-left: 1rem; background: #ef4444; color: white;
            font-size: 0.7rem; font-weight: 700; padding: 2px 8px; border-radius: 20px; letter-spacing: 0.05em;
        }
        .top-bar .user-info { margin-left: auto; color: #ccc; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem; }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 56px; left: 0; width: 14rem; height: calc(100vh - 56px);
            background: #e2e2e2; border-top-right-radius: 1.5rem; border-bottom-right-radius: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08); display: flex; flex-direction: column;
            padding: 1.5rem 0; z-index: 99;
        }
        .sidebar-nav { display: flex; flex-direction: column; gap: 0.35rem; padding: 0 1rem; }
        .sidebar-link {
            display: flex; align-items: center; gap: 0.65rem; padding: 0.65rem 1rem;
            color: #333; text-decoration: none; font-weight: 500; border-radius: 0.75rem;
            transition: all 0.2s ease; font-size: 0.9rem;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.6); color: #ef4444; transform: translateX(3px); }
        .sidebar-link.active { background: rgba(255,255,255,0.85); color: #ef4444; font-weight: 600; }
        .sidebar-link i { width: 1.1rem; text-align: center; }

        /* Main */
        .main-content { margin-left: 14rem; margin-top: 56px; padding: 2rem; min-height: calc(100vh - 56px); }

        /* Stat Cards */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card {
            background: white; border-radius: 16px; padding: 1.25rem 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06); display: flex; flex-direction: column; gap: 0.25rem;
            border-left: 4px solid transparent; transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card .num { font-size: 2rem; font-weight: 800; line-height: 1; }
        .stat-card .label { font-size: 0.78rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.06em; }
        .stat-total   { border-color: #6366f1; } .stat-total   .num { color: #6366f1; }
        .stat-new     { border-color: #f59e0b; } .stat-new     .num { color: #f59e0b; }
        .stat-review  { border-color: #8b5cf6; } .stat-review  .num { color: #8b5cf6; }
        .stat-active  { border-color: #3b82f6; } .stat-active  .num { color: #3b82f6; }
        .stat-clarify { border-color: #f97316; } .stat-clarify .num { color: #f97316; }
        .stat-done    { border-color: #10b981; } .stat-done    .num { color: #10b981; }
        .stat-closed  { border-color: #14b8a6; } .stat-closed  .num { color: #14b8a6; }
        .stat-reject  { border-color: #ef4444; } .stat-reject  .num { color: #ef4444; }

        /* Section headings */
        .section-title {
            font-size: 1.1rem; font-weight: 700; color: #111; margin-bottom: 1rem;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .section-title .icon {
            width: 2rem; height: 2rem; border-radius: 8px; display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem; color: white;
        }

        /* Agency Cards Grid */
        .agency-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .agency-card {
            background: white; border-radius: 16px; padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06); transition: all 0.2s;
        }
        .agency-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
        .agency-header { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; }
        .agency-avatar {
            width: 2.5rem; height: 2.5rem; border-radius: 10px; background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem; flex-shrink: 0;
        }
        .agency-name { font-weight: 700; color: #111; font-size: 0.95rem; }
        .agency-type { font-size: 0.75rem; color: #6b7280; }
        .mini-bar { display: flex; flex-direction: column; gap: 0.4rem; }
        .mini-row { display: flex; align-items: center; justify-content: space-between; font-size: 0.8rem; }
        .mini-row .lbl { color: #6b7280; display: flex; align-items: center; gap: 0.35rem; }
        .mini-row .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .mini-row .val { font-weight: 700; color: #111; }
        .progress-bar-wrap { background: #f3f4f6; border-radius: 100px; height: 5px; margin-top: 0.75rem; overflow: hidden; }
        .progress-bar { height: 100%; border-radius: 100px; background: linear-gradient(90deg, #10b981, #059669); transition: width 0.5s; }

        /* Stalled Table */
        .table-wrap { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); margin-bottom: 2rem; }
        .table-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid #f3f4f6; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background: #fafafa; padding: 0.75rem 1.25rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.06em; }
        tbody tr { border-bottom: 1px solid #f9fafb; transition: background 0.15s; }
        tbody tr:hover { background: #f9fafb; }
        tbody td { padding: 0.9rem 1.25rem; font-size: 0.875rem; color: #374151; }
        tbody tr:last-child { border-bottom: none; }

        /* Status Badges */
        .badge {
            display: inline-flex; align-items: center; gap: 0.3rem;
            padding: 0.2rem 0.75rem; border-radius: 100px; font-size: 0.72rem; font-weight: 700; white-space: nowrap;
        }
        .badge-assigned      { background: #ede9fe; color: #7c3aed; }
        .badge-in-progress   { background: #dbeafe; color: #1d4ed8; }
        .badge-clarification { background: #fff7ed; color: #c2410c; }
        .badge-resolved      { background: #dcfce7; color: #15803d; }
        .badge-closed        { background: #ccfbf1; color: #0d9488; }
        .badge-submitted     { background: #fef9c3; color: #92400e; }
        .badge-rejected      { background: #fee2e2; color: #b91c1c; }

        /* Activity Feed */
        .activity-feed { background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
        .activity-item { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6; }
        .activity-item:last-child { border-bottom: none; }
        .activity-dot { width: 2rem; height: 2rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.7rem; flex-shrink: 0; margin-top: 2px; }
        .activity-text { flex: 1; }
        .activity-title { font-size: 0.875rem; font-weight: 600; color: #111; line-height: 1.4; }
        .activity-sub   { font-size: 0.75rem; color: #9ca3af; margin-top: 2px; }
        .stalled-badge { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; border-radius: 8px; padding: 0.2rem 0.6rem; font-size: 0.7rem; font-weight: 700; }
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        @media (max-width: 900px) { .two-col { grid-template-columns: 1fr; } .agency-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>
        <span class="admin-badge">ADMIN</span>
        <div class="user-info">
            <i class="fas fa-user-shield"></i>
            <span>{{ session('admin_name', 'Administrator') }}</span>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('admin.home') }}" class="sidebar-link">
                <i class="fas fa-home"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.users') }}" class="sidebar-link">
                <i class="fas fa-users"></i><span>Users</span>
            </a>
            <a href="{{ route('admin.inquiries') }}" class="sidebar-link">
                <i class="fas fa-clipboard-list"></i><span>Inquiries</span>
            </a>
            <a href="{{ route('admin.assign.inquiry') }}" class="sidebar-link">
                <i class="fas fa-paper-plane"></i><span>Assign Inquiry</span>
            </a>
            <a href="{{ route('admin.monitor') }}" class="sidebar-link active">
                <i class="fas fa-chart-line"></i><span>Monitor Progress</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="sidebar-link">
                <i class="fas fa-file-alt"></i><span>Reports</span>
            </a>
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

        <!-- Page Header -->
        <div style="margin-bottom:1.5rem;">
            <h1 style="font-size:1.5rem;font-weight:800;color:#111;">Monitor Agency Progress</h1>
            <p style="color:#6b7280;font-size:0.875rem;margin-top:0.25rem;">
                Real-time view of inquiry lifecycle and agency performance. Stalled inquiries are flagged automatically.
            </p>
        </div>

        <!-- System Stats -->
        <div class="stat-grid">
            <div class="stat-card stat-total">
                <div class="num">{{ $stats['total'] }}</div>
                <div class="label">Total Inquiries</div>
            </div>
            <div class="stat-card stat-new">
                <div class="num">{{ $stats['submitted'] }}</div>
                <div class="label">Submitted</div>
            </div>
            <div class="stat-card stat-review">
                <div class="num">{{ $stats['under_review'] + $stats['assigned'] }}</div>
                <div class="label">Under Review / Assigned</div>
            </div>
            <div class="stat-card stat-active">
                <div class="num">{{ $stats['in_progress'] }}</div>
                <div class="label">In Progress</div>
            </div>
            <div class="stat-card stat-clarify">
                <div class="num">{{ $stats['clarification'] }}</div>
                <div class="label">Pending Clarification</div>
            </div>
            <div class="stat-card stat-done">
                <div class="num">{{ $stats['resolved'] }}</div>
                <div class="label">Resolved</div>
            </div>
            <div class="stat-card stat-closed">
                <div class="num">{{ $stats['closed'] }}</div>
                <div class="label">Closed</div>
            </div>
            <div class="stat-card stat-reject">
                <div class="num">{{ $stats['rejected'] }}</div>
                <div class="label">Rejected</div>
            </div>
        </div>

        <!-- Agency Performance Cards -->
        <div class="section-title">
            <div class="icon" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                <i class="fas fa-building"></i>
            </div>
            Agency Workload Overview
        </div>

        <div class="agency-grid">
            @forelse($agencies as $agency)
                @php
                    $total     = $agency->total_inquiries ?: 1;
                    $resolved  = $agency->resolved_count + $agency->closed_count;
                    $pct       = $total > 0 ? round(($resolved / $total) * 100) : 0;
                @endphp
                <div class="agency-card">
                    <div class="agency-header">
                        <div class="agency-avatar">{{ substr($agency->AgencyName, 0, 1) }}</div>
                        <div>
                            <div class="agency-name">{{ $agency->AgencyName }}</div>
                            <div class="agency-type">{{ $agency->AgencyType ?? 'Government Agency' }}</div>
                        </div>
                    </div>
                    <div class="mini-bar">
                        <div class="mini-row">
                            <span class="lbl"><span class="dot" style="background:#7c3aed;"></span>Assigned</span>
                            <span class="val">{{ $agency->assigned_count }}</span>
                        </div>
                        <div class="mini-row">
                            <span class="lbl"><span class="dot" style="background:#1d4ed8;"></span>In Progress</span>
                            <span class="val">{{ $agency->in_progress_count }}</span>
                        </div>
                        <div class="mini-row">
                            <span class="lbl"><span class="dot" style="background:#c2410c;"></span>Awaiting Clarification</span>
                            <span class="val">{{ $agency->clarification_count }}</span>
                        </div>
                        <div class="mini-row">
                            <span class="lbl"><span class="dot" style="background:#10b981;"></span>Resolved</span>
                            <span class="val">{{ $agency->resolved_count }}</span>
                        </div>
                        <div class="mini-row">
                            <span class="lbl"><span class="dot" style="background:#14b8a6;"></span>Closed</span>
                            <span class="val">{{ $agency->closed_count }}</span>
                        </div>
                        <div class="mini-row">
                            <span class="lbl"><span class="dot" style="background:#ef4444;"></span>Rejected</span>
                            <span class="val">{{ $agency->rejected_count }}</span>
                        </div>
                    </div>
                    <div class="progress-bar-wrap" style="margin-top:1rem;">
                        <div class="progress-bar" style="width:{{ $pct }}%;"></div>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:0.72rem;color:#6b7280;margin-top:0.35rem;">
                        <span>Resolution rate</span>
                        <span style="font-weight:700;color:{{ $pct >= 50 ? '#10b981' : '#ef4444' }};">{{ $pct }}%</span>
                    </div>
                </div>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:3rem;color:#9ca3af;">
                    <i class="fas fa-building" style="font-size:2rem;margin-bottom:0.75rem;display:block;"></i>
                    No agencies found.
                </div>
            @endforelse
        </div>

        <!-- Two-column: Stalled + Recent Activity -->
        <div class="two-col">
            <!-- Stalled Inquiries -->
            <div>
                <div class="section-title">
                    <div class="icon" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    Stalled Inquiries
                    <span style="background:#fef3c7;color:#92400e;border-radius:100px;padding:2px 10px;font-size:0.75rem;font-weight:700;">
                        7+ days inactive
                    </span>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Agency</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stalledInquiries as $inq)
                                <tr>
                                    <td style="font-weight:700;color:#6366f1;">#{{ $inq->InquiryID }}</td>
                                    <td>
                                        <a href="{{ route('admin.inquiry.details', $inq->InquiryID) }}"
                                           style="color:#111;font-weight:600;text-decoration:none;">
                                            {{ Str::limit($inq->InquiryTitle, 30) }}
                                        </a>
                                    </td>
                                    <td style="color:#6b7280;">{{ $inq->agency?->AgencyName ?? 'Unassigned' }}</td>
                                    <td>
                                        @php
                                            $sc = [
                                                'Assigned'             => 'badge-assigned',
                                                'In Progress'          => 'badge-in-progress',
                                                'Pending Clarification'=> 'badge-clarification',
                                            ][$inq->InquiryStatus] ?? 'badge-submitted';
                                        @endphp
                                        <span class="badge {{ $sc }}">{{ $inq->InquiryStatus }}</span>
                                    </td>
                                    <td>
                                        <span class="stalled-badge">
                                            <i class="fas fa-clock"></i>
                                            {{ $inq->updated_at?->diffForHumans() ?? 'Unknown' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center;padding:2rem;color:#10b981;">
                                        <i class="fas fa-check-circle" style="font-size:1.5rem;margin-bottom:0.5rem;display:block;"></i>
                                        No stalled inquiries! All agencies are up to date.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Activity -->
            <div>
                <div class="section-title">
                    <div class="icon" style="background:linear-gradient(135deg,#10b981,#059669);">
                        <i class="fas fa-history"></i>
                    </div>
                    Recent Status Activity
                </div>
                <div class="activity-feed">
                    @forelse($recentActivity as $log)
                        @php
                            $dotColor = match($log->status) {
                                'Resolved'              => '#10b981',
                                'Closed'                => '#14b8a6',
                                'In Progress'           => '#3b82f6',
                                'Pending Clarification' => '#f97316',
                                'Rejected'              => '#ef4444',
                                'Assigned'              => '#8b5cf6',
                                default                 => '#6b7280',
                            };
                            $icon = match($log->status) {
                                'Resolved'              => 'check',
                                'Closed'                => 'lock',
                                'In Progress'           => 'spinner',
                                'Pending Clarification' => 'question',
                                'Rejected'              => 'times',
                                'Assigned'              => 'paper-plane',
                                default                 => 'circle',
                            };
                        @endphp
                        <div class="activity-item">
                            <div class="activity-dot" style="background:{{ $dotColor }};">
                                <i class="fas fa-{{ $icon }}"></i>
                            </div>
                            <div class="activity-text">
                                <div class="activity-title">
                                    Inquiry #{{ $log->InquiryID }}
                                    @if($log->previous_status)
                                        <span style="color:#9ca3af;font-weight:400;">
                                            {{ $log->previous_status }} → </span>
                                    @endif
                                    <span style="color:{{ $dotColor }};">{{ $log->status }}</span>
                                </div>
                                <div class="activity-sub">
                                    {{ $log->actor_name ?? 'System' }} · {{ $log->created_at?->diffForHumans() ?? 'Unknown' }}
                                    @if($log->notes)
                                        <span style="margin-left:0.5rem;color:#6b7280;">— {{ Str::limit($log->notes, 50) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center;padding:2rem;color:#9ca3af;">
                            <i class="fas fa-history" style="font-size:1.5rem;display:block;margin-bottom:0.5rem;"></i>
                            No recent activity yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</body>
</html>
