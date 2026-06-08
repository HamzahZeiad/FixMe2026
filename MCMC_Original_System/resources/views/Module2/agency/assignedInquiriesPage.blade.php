<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Inquiries - AuthenticityHub Agency</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a7fd0, #6bc5f3);
            margin: 0;
            padding: 0;
        }

        .inquiry-list {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .inquiry-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .table-header {
            background: #283d63;
            color: white;
            padding: 1rem;
            font-weight: 600;
        }

        .table-row {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s;
        }

        .table-row:hover {
            background: #f8faff;
        }

        .table-cell {
            padding: 1rem;
            color: #4b5563;
        }

        .status-badge {
            padding: 0.25rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-block;
        }

        .status-assigned {
            background: #fef3c7;
            color: #92400e;
        }

        .status-in-progress {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .priority-high {
            color: #dc2626;
            font-weight: 600;
        }

        .priority-medium {
            color: #d97706;
            font-weight: 600;
        }

        .priority-low {
            color: #16a34a;
            font-weight: 600;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-block;
            text-align: center;
        }

        .btn-view {
            background: #3b82f6;
            color: white;
        }

        .btn-view:hover {
            background: #2563eb;
        }

        .btn-update {
            background: #10b981;
            color: white;
            margin-left: 0.5rem;
        }

        .btn-update:hover {
            background: #059669;
        }

        .filter-section {
            background: #f8faff;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-label {
            color: #283d63;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .filter-select {
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            background: white;
            color: #4b5563;
        }

        .filter-btn {
            background: #283d63;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .filter-btn:hover {
            background: #1e293b;
        }
    </style>
</head>

<body>
    <div class="min-h-screen p-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">Assigned Inquiries</h1>
                <p class="text-white opacity-90">Manage and review inquiries assigned to your agency</p>
            </div>

            <!-- Stats Dashboard -->
            <div class="stats-grid mb-8">
                <div class="stat-card">
                    <div class="stat-number">{{ $totalAssigned ?? '12' }}</div>
                    <div class="stat-label">Total Assigned</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $inProgress ?? '8' }}</div>
                    <div class="stat-label">In Progress</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $completed ?? '15' }}</div>
                    <div class="stat-label">Completed This Month</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $overdue ?? '3' }}</div>
                    <div class="stat-label">Overdue</div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Inquiries</h3>
                <form method="GET" action="{{ route('agency.assigned-inquiries') }}">
                    <div class="filter-grid">
                        <div class="filter-group">
                            <label class="filter-label">Status</label>
                            <select name="status" class="filter-select">
                                <option value="">All Status</option>
                                <option value="assigned">Assigned</option>
                                <option value="in-progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Priority</label>
                            <select name="priority" class="filter-select">
                                <option value="">All Priorities</option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Date Range</label>
                            <select name="date_range" class="filter-select">
                                <option value="">All Time</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">&nbsp;</label>
                            <button type="submit" class="filter-btn">Apply Filters</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Inquiries List -->
            <div class="inquiry-list">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Assigned Inquiries</h2>
                    <div class="text-sm text-gray-600">
                        Showing {{ count($inquiries ?? []) }} of {{ $total ?? '25' }} inquiries
                    </div>
                </div>

                <div class="inquiry-table">
                    <div class="table-header grid grid-cols-8 gap-4">
                        <div>ID</div>
                        <div>Subject</div>
                        <div>Requester</div>
                        <div>Priority</div>
                        <div>Status</div>
                        <div>Assigned Date</div>
                        <div>Due Date</div>
                        <div>Actions</div>
                    </div>

                    @forelse($inquiries ?? [] as $inquiry)
                        <div class="table-row grid grid-cols-8 gap-4 items-center">
                            <div class="table-cell font-mono text-sm">#{{ $inquiry->id ?? 'INQ001' }}</div>
                            <div class="table-cell">
                                <div class="font-medium">{{ $inquiry->subject ?? 'Product Authenticity Verification' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ Str::limit($inquiry->description ?? 'Request for authenticity verification of luxury item', 50) }}
                                </div>
                            </div>
                            <div class="table-cell">
                                <div class="font-medium">{{ $inquiry->user->name ?? 'John Doe' }}</div>
                                <div class="text-sm text-gray-500">{{ $inquiry->user->email ?? 'john@example.com' }}
                                </div>
                            </div>
                            <div class="table-cell">
                                <span class="priority-{{ $inquiry->priority ?? 'medium' }}">
                                    {{ ucfirst($inquiry->priority ?? 'Medium') }}
                                </span>
                            </div>
                            <div class="table-cell">
                                <span
                                    class="status-badge status-{{ str_replace(' ', '-', strtolower($inquiry->status ?? 'assigned')) }}">
                                    {{ $inquiry->status ?? 'Assigned' }}
                                </span>
                            </div>
                            <div class="table-cell text-sm">
                                {{ $inquiry->assigned_at ? $inquiry->assigned_at->format('M d, Y') : 'Jan 15, 2024' }}
                            </div>
                            <div class="table-cell text-sm">
                                <span
                                    class="{{ $inquiry->due_date && $inquiry->due_date->isPast() ? 'text-red-600 font-semibold' : '' }}">
                                    {{ $inquiry->due_date ? $inquiry->due_date->format('M d, Y') : 'Jan 22, 2024' }}
                                </span>
                            </div>
                            <div class="table-cell">
                                <a href="{{ route('agency.inquiry-details', $inquiry->id ?? '1') }}"
                                    class="action-btn btn-view">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <a href="{{ route('agency.update-inquiry', $inquiry->id ?? '1') }}"
                                    class="action-btn btn-update">
                                    <i class="fas fa-edit mr-1"></i>Update
                                </a>
                            </div>
                        </div>
                    @empty
                        <!-- Sample Data for Demo -->
                        <div class="table-row grid grid-cols-8 gap-4 items-center">
                            <div class="table-cell font-mono text-sm">#INQ001</div>
                            <div class="table-cell">
                                <div class="font-medium">Product Authenticity Verification</div>
                                <div class="text-sm text-gray-500">Request for authenticity verification of luxury
                                    handbag</div>
                            </div>
                            <div class="table-cell">
                                <div class="font-medium">John Doe</div>
                                <div class="text-sm text-gray-500">john@example.com</div>
                            </div>
                            <div class="table-cell">
                                <span class="priority-high">High</span>
                            </div>
                            <div class="table-cell">
                                <span class="status-badge status-in-progress">In Progress</span>
                            </div>
                            <div class="table-cell text-sm">Jan 15, 2024</div>
                            <div class="table-cell text-sm">Jan 22, 2024</div>
                            <div class="table-cell">
                                <a href="#" class="action-btn btn-view">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <a href="#" class="action-btn btn-update">
                                    <i class="fas fa-edit mr-1"></i>Update
                                </a>
                            </div>
                        </div>

                        <div class="table-row grid grid-cols-8 gap-4 items-center">
                            <div class="table-cell font-mono text-sm">#INQ002</div>
                            <div class="table-cell">
                                <div class="font-medium">Document Verification</div>
                                <div class="text-sm text-gray-500">Certificate of authenticity validation needed</div>
                            </div>
                            <div class="table-cell">
                                <div class="font-medium">Sarah Smith</div>
                                <div class="text-sm text-gray-500">sarah@example.com</div>
                            </div>
                            <div class="table-cell">
                                <span class="priority-medium">Medium</span>
                            </div>
                            <div class="table-cell">
                                <span class="status-badge status-assigned">Assigned</span>
                            </div>
                            <div class="table-cell text-sm">Jan 16, 2024</div>
                            <div class="table-cell text-sm">Jan 23, 2024</div>
                            <div class="table-cell">
                                <a href="#" class="action-btn btn-view">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <a href="#" class="action-btn btn-update">
                                    <i class="fas fa-edit mr-1"></i>Update
                                </a>
                            </div>
                        </div>

                        <div class="table-row grid grid-cols-8 gap-4 items-center">
                            <div class="table-cell font-mono text-sm">#INQ003</div>
                            <div class="table-cell">
                                <div class="font-medium">Jewelry Appraisal</div>
                                <div class="text-sm text-gray-500">Diamond ring authenticity and value assessment</div>
                            </div>
                            <div class="table-cell">
                                <div class="font-medium">Michael Johnson</div>
                                <div class="text-sm text-gray-500">michael@example.com</div>
                            </div>
                            <div class="table-cell">
                                <span class="priority-low">Low</span>
                            </div>
                            <div class="table-cell">
                                <span class="status-badge status-completed">Completed</span>
                            </div>
                            <div class="table-cell text-sm">Jan 14, 2024</div>
                            <div class="table-cell text-sm">Jan 21, 2024</div>
                            <div class="table-cell">
                                <a href="#" class="action-btn btn-view">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <a href="#" class="action-btn btn-update">
                                    <i class="fas fa-edit mr-1"></i>Update
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-600">
                        Showing 1-10 of {{ $total ?? '25' }} results
                    </div>
                    <div class="flex gap-2">
                        <button
                            class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50">Previous</button>
                        <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded">1</button>
                        <button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50">2</button>
                        <button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50">3</button>
                        <button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50">Next</button>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 text-center">
                <a href="{{ route('agency.dashboard') }}" class="action-btn btn-view mr-4">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
                <a href="{{ route('agency.reports') }}" class="action-btn btn-update">
                    <i class="fas fa-chart-bar mr-2"></i>View Reports
                </a>
            </div>
        </div>
    </div>
</body>

</html>
