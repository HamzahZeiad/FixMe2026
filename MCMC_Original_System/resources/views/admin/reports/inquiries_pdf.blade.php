<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiries Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #4f46e5;
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: bold;
        }

        .header .subtitle {
            color: #6b7280;
            font-size: 14px;
        }

        .report-info {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #4f46e5;
        }

        .report-info h3 {
            color: #4f46e5;
            margin: 0 0 10px 0;
            font-size: 16px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .info-item {
            font-size: 14px;
        }

        .info-label {
            font-weight: 600;
            color: #374151;
        }

        .summary-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            color: #4f46e5;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .chart-section {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            text-align: center;
        }

        .chart-container {
            width: 100%;
            height: 300px;
            margin: 20px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background: #4f46e5;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
        }

        .table tr:nth-child(even) {
            background: #f8fafc;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending { background: #fef3c7; color: #92400e; }
        .status-investigation { background: #dbeafe; color: #1e40af; }
        .status-verified { background: #d1fae5; color: #065f46; }
        .status-fake { background: #fee2e2; color: #991b1b; }
        .status-rejected { background: #f3f4f6; color: #374151; }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }

        @media print {
            body { margin: 0; }
            .chart-container { height: 250px; }
            .summary-stats { grid-template-columns: repeat(4, 1fr); }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Submitted Inquiries Report</h1>
        <div class="subtitle">AuthenticityHub - Administrative Report</div>
    </div>

    <!-- Report Information -->
    <div class="report-info">
        <h3>Report Details</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Generated On:</span>
                {{ $generated_at->format('F j, Y g:i A') }}
            </div>
            <div class="info-item">
                <span class="info-label">Generated By:</span>
                {{ $generated_by }}
            </div>
            <div class="info-item">
                <span class="info-label">Date Range:</span>
                {{ $date_from }} to {{ $date_to }}
            </div>
            <div class="info-item">
                <span class="info-label">Report Type:</span>
                {{ ucfirst($report_type) }}
            </div>
            @if(isset($inquiry_status) && $inquiry_status)
            <div class="info-item">
                <span class="info-label">Status Filter:</span>
                {{ $inquiry_status }}
            </div>
            @endif
            <div class="info-item">
                <span class="info-label">Total Records:</span>
                {{ $total_inquiries }}
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="summary-stats">
        <div class="stat-card">
            <div class="stat-number">{{ $total_inquiries }}</div>
            <div class="stat-label">Total Inquiries</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">{{ $pending_inquiries }}</div>
            <div class="stat-label">Pending</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">{{ $under_investigation }}</div>
            <div class="stat-label">Under Investigation</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">{{ $verified_true }}</div>
            <div class="stat-label">Verified as True</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">{{ $identified_fake }}</div>
            <div class="stat-label">Identified as Fake</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">{{ $rejected_inquiries }}</div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="section">
        <h2>Inquiry Statistics Charts</h2>

        <!-- Status Distribution Chart -->
        <div class="chart-section">
            <h3>Inquiry Status Distribution</h3>
            <div class="chart-container">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Processing Status Chart -->
        <div class="chart-section">
            <h3>Processing Status Breakdown</h3>
            <div class="chart-container">
                <canvas id="processingChart"></canvas>
            </div>
        </div>
    </div>

    @if($report_type === 'detailed' && $inquiries->count() > 0)
    <!-- Detailed Inquiries Table -->
    <div class="section">
        <h2>Detailed Inquiry List</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Submit Date</th>
                    <th>Agency</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inquiries as $inquiry)
                <tr>
                    <td>#{{ $inquiry->InquiryID }}</td>
                    <td>{{ Str::limit($inquiry->InquiryTitle, 40) }}</td>
                    <td>{{ $inquiry->InquirySource ?? 'N/A' }}</td>
                    <td>
                        @php
                            $statusClass = match($inquiry->InquiryStatus) {
                                'Pending' => 'status-pending',
                                'Under Investigation' => 'status-investigation',
                                'Verified as True' => 'status-verified',
                                'Identified as Fake' => 'status-fake',
                                'Rejected' => 'status-rejected',
                                default => 'status-pending'
                            };
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ $inquiry->InquiryStatus ?? 'Pending' }}
                        </span>
                    </td>
                    <td>{{ $inquiry->InquirySendDate ? \Carbon\Carbon::parse($inquiry->InquirySendDate)->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $inquiry->agency->AgencyName ?? 'Unassigned' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>This report was automatically generated by AuthenticityHub Admin Panel</p>
        <p>© {{ date('Y') }} AuthenticityHub. All rights reserved.</p>
    </div>

    <script>
        // Status Distribution Doughnut Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Under Investigation', 'Verified as True', 'Identified as Fake', 'Rejected'],
                datasets: [{
                    data: [
                        {{ $pending_inquiries }},
                        {{ $under_investigation }},
                        {{ $verified_true }},
                        {{ $identified_fake }},
                        {{ $rejected_inquiries }}
                    ],
                    backgroundColor: [
                        '#fbbf24',
                        '#3b82f6',
                        '#10b981',
                        '#ef4444',
                        '#6b7280'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Processing Status Bar Chart
        const processingCtx = document.getElementById('processingChart').getContext('2d');
        new Chart(processingCtx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Under Investigation', 'Verified', 'Fake', 'Rejected'],
                datasets: [{
                    label: 'Number of Inquiries',
                    data: [
                        {{ $pending_inquiries }},
                        {{ $under_investigation }},
                        {{ $verified_true }},
                        {{ $identified_fake }},
                        {{ $rejected_inquiries }}
                    ],
                    backgroundColor: [
                        '#fbbf24',
                        '#3b82f6',
                        '#10b981',
                        '#ef4444',
                        '#6b7280'
                    ],
                    borderRadius: 4,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
