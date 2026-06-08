<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Assignment Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }

        .header h1 {
            color: #333;
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .section {
            margin-bottom: 25px;
        }

        .section h2 {
            background-color: #f0f0f0;
            padding: 8px;
            margin: 0 0 15px 0;
            font-size: 16px;
            border-left: 4px solid #007cba;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #007cba;
            display: block;
        }

        .stat-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
          .chart-container {
            width: 100%;
            margin: 15px 0;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
        }

        .bar-chart {
            margin: 10px 0;
        }

        .bar-item {
            margin-bottom: 8px;
        }

        .bar-label {
            display: inline-block;
            width: 150px;
            font-size: 11px;
            vertical-align: top;
        }

        .bar-visual {
            display: inline-block;
            height: 20px;
            background-color: #007cba;
            margin-right: 10px;
            vertical-align: top;
        }

        .bar-value {
            display: inline-block;
            font-size: 11px;
            font-weight: bold;
            vertical-align: top;
            line-height: 20px;
        }

        .pie-chart {
            text-align: center;
            margin: 15px 0;
        }

        .pie-item {
            display: inline-block;
            margin: 5px 10px;
            text-align: center;
        }

        .pie-slice {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            margin-bottom: 5px;
        }

        .pie-label {
            font-size: 10px;
            font-weight: bold;
        }

        .line-chart {
            margin: 15px 0;
        }

        .line-point {
            display: inline-block;
            width: 20px;
            text-align: center;
            font-size: 10px;
            margin: 0 2px;
        }

        .line-visual {
            height: 100px;
            border-left: 2px solid #333;
            border-bottom: 2px solid #333;
            position: relative;
            margin: 10px 0;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }

        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-investigation { background-color: #d1ecf1; color: #0c5460; }
        .status-verified { background-color: #d4edda; color: #155724; }
        .status-fake { background-color: #f8d7da; color: #721c24; }
        .status-rejected { background-color: #e2e3e5; color: #383d41; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Assigned Inquiry Reports</h1>
        <p><strong>Report Type:</strong> {{ ucfirst($report_type) }}</p>
        <p><strong>Generated:</strong> {{ $generated_at }}</p>
        @if($date_from && $date_to)
            <p><strong>Assignment Date Range:</strong> {{ $date_from }} to {{ $date_to }}</p>
        @endif
        @if($agency_filter)
            <p><strong>Agency Filter:</strong> {{ $agency_filter->AgencyName }}</p>
        @endif
        @if($status_filter)
            <p><strong>Status Filter:</strong> {{ $status_filter }}</p>
        @endif
    </div>    <!-- Summary Statistics -->
    <div class="section">
        <h2>Assignment Summary</h2>
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number">{{ $total_assignments }}</span>
                <div class="stat-label">Total Assignments</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $agency_stats->count() }}</span>
                <div class="stat-label">Agencies Involved</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $status_stats['pending'] + $status_stats['under_investigation'] }}</span>
                <div class="stat-label">Active Assignments</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $status_stats['verified_true'] + $status_stats['identified_fake'] }}</span>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $status_stats['rejected'] }}</span>
                <div class="stat-label">Rejected</div>
            </div>
        </div>

        @if($include_charts === 'yes')
            <div class="chart-container">
                <h3 style="margin: 0 0 10px 0; font-size: 14px;">Assignment Progress Overview</h3>
                @php
                    $completed = $status_stats['verified_true'] + $status_stats['identified_fake'];
                    $active = $status_stats['pending'] + $status_stats['under_investigation'];
                    $rejected = $status_stats['rejected'];

                    $completedPercent = $total_assignments > 0 ? ($completed / $total_assignments) * 100 : 0;
                    $activePercent = $total_assignments > 0 ? ($active / $total_assignments) * 100 : 0;
                    $rejectedPercent = $total_assignments > 0 ? ($rejected / $total_assignments) * 100 : 0;
                @endphp
                <div style="margin: 15px 0;">
                    <div style="margin-bottom: 10px;">
                        <span style="font-size: 12px; font-weight: bold;">Completed ({{ round($completedPercent, 1) }}%)</span>
                        <div style="background-color: #e5e5e5; height: 20px; border-radius: 10px; margin: 5px 0;">
                            <div style="background-color: #28a745; height: 20px; width: {{ $completedPercent }}%; border-radius: 10px; line-height: 20px; text-align: center; color: white; font-size: 11px;">
                                {{ $completed }}
                            </div>
                        </div>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <span style="font-size: 12px; font-weight: bold;">Active ({{ round($activePercent, 1) }}%)</span>
                        <div style="background-color: #e5e5e5; height: 20px; border-radius: 10px; margin: 5px 0;">
                            <div style="background-color: #007cba; height: 20px; width: {{ $activePercent }}%; border-radius: 10px; line-height: 20px; text-align: center; color: white; font-size: 11px;">
                                {{ $active }}
                            </div>
                        </div>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <span style="font-size: 12px; font-weight: bold;">Rejected ({{ round($rejectedPercent, 1) }}%)</span>
                        <div style="background-color: #e5e5e5; height: 20px; border-radius: 10px; margin: 5px 0;">
                            <div style="background-color: #dc3545; height: 20px; width: {{ $rejectedPercent }}%; border-radius: 10px; line-height: 20px; text-align: center; color: white; font-size: 11px;">
                                {{ $rejected }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div><!-- Status Distribution -->
    <div class="section">
        <h2>Status Distribution</h2>
        @if($include_charts === 'yes')
            <div class="chart-container">
                <h3 style="margin: 0 0 10px 0; font-size: 14px;">Status Distribution Chart</h3>
                <div class="bar-chart">
                    @php
                        $maxCount = max($status_stats);
                        $maxBarWidth = 300; // Maximum bar width in pixels
                    @endphp
                    @foreach($status_stats as $status => $count)
                        <div class="bar-item">
                            <span class="bar-label">{{ ucfirst(str_replace('_', ' ', $status)) }}:</span>
                            <span class="bar-visual" style="width: {{ $maxCount > 0 ? ($count / $maxCount) * $maxBarWidth : 0 }}px;"></span>
                            <span class="bar-value">{{ $count }} ({{ $total_assignments > 0 ? round(($count / $total_assignments) * 100, 1) : 0 }}%)</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($status_stats as $status => $count)
                    <tr>
                        <td>
                            <span class="status-badge status-{{ str_replace('_', '-', $status) }}">
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </span>
                        </td>
                        <td>{{ $count }}</td>
                        <td>{{ $total_assignments > 0 ? round(($count / $total_assignments) * 100, 1) : 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>    <!-- Agency Performance -->
    <div class="section">
        <h2>Agency Assignment Performance</h2>
        @if($include_charts === 'yes')
            <div class="chart-container">
                <h3 style="margin: 0 0 10px 0; font-size: 14px;">Assignments per Agency</h3>
                <div class="bar-chart">
                    @php
                        $maxAgencyCount = $agency_stats->max('count');
                        $maxBarWidth = 250;
                    @endphp
                    @foreach($agency_stats->take(10) as $agencyId => $stats)
                        <div class="bar-item">
                            <span class="bar-label">{{ \Illuminate\Support\Str::limit($stats['agency'] ? $stats['agency']->AgencyName : 'Unknown', 20) }}:</span>
                            <span class="bar-visual" style="width: {{ $maxAgencyCount > 0 ? ($stats['count'] / $maxAgencyCount) * $maxBarWidth : 0 }}px;"></span>
                            <span class="bar-value">{{ $stats['count'] }} assignments</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Agency Name</th>
                    <th>Total</th>
                    <th>Pending</th>
                    <th>Investigating</th>
                    <th>Verified True</th>
                    <th>Identified Fake</th>
                    <th>Rejected</th>
                </tr>
            </thead>
            <tbody>
                @foreach($agency_stats as $agencyId => $stats)
                    <tr>
                        <td>{{ $stats['agency'] ? $stats['agency']->AgencyName : 'Unknown Agency' }}</td>
                        <td><strong>{{ $stats['count'] }}</strong></td>
                        <td>{{ $stats['pending'] }}</td>
                        <td>{{ $stats['under_investigation'] }}</td>
                        <td>{{ $stats['verified_true'] }}</td>
                        <td>{{ $stats['identified_fake'] }}</td>
                        <td>{{ $stats['rejected'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>    @if($include_charts === 'yes')
        <!-- Assignment Trends -->
        <div class="section">
            <h2>Assignment Trends Over Time</h2>
            <div class="chart-container">
                <h3 style="margin: 0 0 10px 0; font-size: 14px;">Assignment Timeline</h3>
                @php
                    $trendData = $assignment_trends->take(15); // Show last 15 data points
                    $maxTrendCount = $trendData->max();
                @endphp
                @if($trendData->count() > 0)
                    <div class="line-chart">
                        <div style="margin-bottom: 10px;">
                            @foreach($trendData as $date => $count)
                                <div style="display: inline-block; margin: 0 3px; text-align: center; width: 60px;">
                                    <div style="height: {{ $maxTrendCount > 0 ? ($count / $maxTrendCount) * 80 + 10 : 10 }}px; background-color: #007cba; width: 15px; margin: 0 auto; margin-bottom: 5px;"></div>
                                    <div style="font-size: 9px; transform: rotate(-45deg); white-space: nowrap;">{{ $date != 'Unknown' ? date('m/d', strtotime($date)) : 'N/A' }}</div>
                                    <div style="font-size: 10px; font-weight: bold; margin-top: 5px;">{{ $count }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p style="text-align: center; color: #666; margin: 20px 0;">No assignment trend data available</p>
                @endif
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Assignments</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignment_trends->take(10) as $date => $count)
                        <tr>
                            <td>{{ $date }}</td>
                            <td>{{ $count }}</td>
                        </tr>
                    @endforeach
                    @if($assignment_trends->count() > 10)
                        <tr>
                            <td colspan="2"><em>... and {{ $assignment_trends->count() - 10 }} more dates</em></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    @endif

    @if($report_type === 'detailed')
        <!-- Detailed Assignment Data -->
        <div class="section">
            <h2>Detailed Assignment Data</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Agency</th>
                        <th>Assignment Date</th>
                        <th>User</th>
                        <th>Source</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assigned_inquiries->take(50) as $inquiry)
                        <tr>
                            <td>{{ $inquiry->InquiryID }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($inquiry->InquiryTitle, 30) }}</td>
                            <td>
                                <span class="status-badge status-{{ str_replace([' ', '_'], '-', strtolower($inquiry->InquiryStatus)) }}">
                                    {{ $inquiry->InquiryStatus }}
                                </span>
                            </td>
                            <td>{{ $inquiry->agency ? $inquiry->agency->AgencyName : 'N/A' }}</td>
                            <td>{{ $inquiry->assignment_date ? $inquiry->assignment_date->format('Y-m-d') : 'N/A' }}</td>
                            <td>{{ $inquiry->user ? $inquiry->user->UserName : 'N/A' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($inquiry->InquirySource, 20) }}</td>
                        </tr>
                    @endforeach
                    @if($assigned_inquiries->count() > 50)
                        <tr>
                            <td colspan="7"><em>... and {{ $assigned_inquiries->count() - 50 }} more assignments (download Excel for complete data)</em></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    @endif

    <div class="footer">
        <p>This report was generated automatically by the AuthenticityHub System</p>
        <p>Generated on {{ $generated_at }}</p>
    </div>
</body>
</html>
