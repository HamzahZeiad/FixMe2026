<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Report</title>
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
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .summary-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }

        .summary-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .summary-grid {
            display: table;
            width: 100%;
        }

        .summary-row {
            display: table-row;
        }

        .summary-cell {
            display: table-cell;
            padding: 5px 10px;
            border-bottom: 1px solid #ddd;
        }

        .summary-cell:first-child {
            font-weight: bold;
            width: 30%;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            padding: 8px 0;
            border-bottom: 1px solid #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }

        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }

        .status-badge {
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-new {
            background-color: #3498db;
            color: white;
        }

        .status-assigned {
            background-color: #f39c12;
            color: white;
        }

        .status-in-progress {
            background-color: #9b59b6;
            color: white;
        }

        .status-completed {
            background-color: #27ae60;
            color: white;
        }

        .status-rejected {
            background-color: #e74c3c;
            color: white;
        }

        /* Chart Styles */
        .charts-section {
            margin: 30px 0;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }

        .chart-container {
            margin-bottom: 30px;
            break-inside: avoid;
        }

        .chart-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }

        .bar-chart {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .bar-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .bar-label {
            width: 120px;
            font-size: 11px;
            color: #333;
            text-align: right;
            padding-right: 10px;
        }

        .bar-visual {
            flex: 1;
            height: 20px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .bar-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .bar-value {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 10px;
            color: #333;
            font-weight: bold;
        }

        .pie-chart {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 500px;
            margin: 0 auto;
        }

        .pie-visual {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            position: relative;
            margin-right: 30px;
        }

        .pie-legend {
            flex: 1;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            margin-right: 8px;
            border-radius: 2px;
        }

        .legend-text {
            flex: 1;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin: 20px 0;
        }

        .stats-row {
            display: table-row;
        }

        .stats-cell {
            display: table-cell;
            padding: 8px 15px;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
        }

        .stats-cell:first-child {
            font-weight: bold;
            color: #555;
            width: 40%;
        }

        .highlight-stat {
            background: #e8f4f8;
            font-weight: bold;
            color: #0066cc;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ ucfirst($report_type) }} Inquiry Report</h1>
        <p>AuthenticityHub - Admin Report System</p>
        <p>Generated on: {{ $generated_at->format('F j, Y \a\t g:i A') }}</p>
    </div>

    <div class="summary-section">
        <div class="summary-title">Report Summary</div>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">Report Type:</div>
                <div class="summary-cell">{{ ucfirst($report_type) }} Report</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell">Date Range:</div>
                <div class="summary-cell">{{ $date_from }} to {{ $date_to }}</div>
            </div>
            @if ($status_filter)
                <div class="summary-row">
                    <div class="summary-cell">Status Filter:</div>
                    <div class="summary-cell">{{ ucfirst($status_filter) }}</div>
                </div>
            @endif
            @if (isset($review_status_filter) && $review_status_filter)
                <div class="summary-row">
                    <div class="summary-cell">Review Status Filter:</div>
                    <div class="summary-cell">{{ ucfirst(str_replace('_', ' ', $review_status_filter)) }}</div>
                </div>
            @endif
            <div class="summary-row">
                <div class="summary-cell">Total Inquiries:</div>
                <div class="summary-cell">{{ $total_inquiries }}</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell">Pending:</div>
                <div class="summary-cell">{{ $status_counts['Pending'] ?? 0 }}</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell">Under Investigation:</div>
                <div class="summary-cell">{{ $status_counts['Under Investigation'] ?? 0 }}</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell">Verified as True:</div>
                <div class="summary-cell">{{ $status_counts['Verified as True'] ?? 0 }}</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell">Identified as Fake:</div>
                <div class="summary-cell">{{ $status_counts['Identified as Fake'] ?? 0 }}</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell">Rejected:</div>
                <div class="summary-cell">{{ $status_counts['Rejected'] ?? 0 }}</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell">Generated By:</div>
                <div class="summary-cell">{{ $generated_by }}</div>
            </div>
        </div>
    </div>

    @if (isset($include_charts) && $include_charts === 'yes')
        <div class="charts-section">
            <h2 style="text-align: center; color: #333; margin-bottom: 25px;">Graphical Analysis</h2>

            <!-- Submission Statistics -->
            @if (isset($review_stats))
                <div class="chart-container">
                    <div class="chart-title">Inquiry Submission & Review Statistics</div>
                    <div class="stats-grid">
                        <div class="stats-row">
                            <div class="stats-cell">Total Submitted Inquiries:</div>
                            <div class="stats-cell highlight-stat">{{ $review_stats['total_submitted'] }}</div>
                        </div>
                        <div class="stats-row">
                            <div class="stats-cell">Reviewed Inquiries:</div>
                            <div class="stats-cell">{{ $review_stats['reviewed'] }}</div>
                        </div>
                        <div class="stats-row">
                            <div class="stats-cell">Not Reviewed:</div>
                            <div class="stats-cell">{{ $review_stats['not_reviewed'] }}</div>
                        </div>
                        <div class="stats-row">
                            <div class="stats-cell">Pending Review:</div>
                            <div class="stats-cell">{{ $review_stats['pending_review'] }}</div>
                        </div>
                        <div class="stats-row">
                            <div class="stats-cell">Review Completion Rate:</div>
                            <div class="stats-cell highlight-stat">{{ $review_stats['review_percentage'] }}%</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Processing Status Bar Chart -->
            <div class="chart-container">
                <div class="chart-title">Processing Status Distribution</div>
                <div class="bar-chart">
                    @php
                        $maxCount = max(array_values($status_counts));
                        $statusColors = [
                            'Pending' => '#3498db',
                            'Under Investigation' => '#9b59b6',
                            'Verified as True' => '#27ae60',
                            'Identified as Fake' => '#e74c3c',
                            'Rejected' => '#95a5a6'
                        ];
                    @endphp
                    @foreach ($status_counts as $status => $count)
                        <div class="bar-item">
                            <div class="bar-label">{{ $status }}:</div>
                            <div class="bar-visual">
                                <div class="bar-fill" style="width: {{ $maxCount > 0 ? ($count / $maxCount) * 100 : 0 }}%; background-color: {{ $statusColors[$status] ?? '#6c757d' }};"></div>
                                <div class="bar-value">{{ $count }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Review Status Pie Chart Representation -->
            @if (isset($review_stats))
                <div class="chart-container">
                    <div class="chart-title">Processing Status Overview</div>
                    @php
                        $total = $status_counts['Pending'] + $status_counts['Under Investigation'] + $status_counts['Verified as True'] + $status_counts['Identified as Fake'] + $status_counts['Rejected'];
                        $pendingAngle = $total > 0 ? ($status_counts['Pending'] / $total) * 360 : 0;
                        $underInvestigationAngle = $total > 0 ? ($status_counts['Under Investigation'] / $total) * 360 : 0;
                        $verifiedAngle = $total > 0 ? ($status_counts['Verified as True'] / $total) * 360 : 0;
                        $fakeAngle = $total > 0 ? ($status_counts['Identified as Fake'] / $total) * 360 : 0;
                        $rejectedAngle = $total > 0 ? ($status_counts['Rejected'] / $total) * 360 : 0;
                    @endphp
                    <div class="pie-chart">
                        <div class="pie-visual" style="background: conic-gradient(
                            #3498db 0deg {{ $pendingAngle }}deg,
                            #9b59b6 {{ $pendingAngle }}deg {{ $pendingAngle + $underInvestigationAngle }}deg,
                            #27ae60 {{ $pendingAngle + $underInvestigationAngle }}deg {{ $pendingAngle + $underInvestigationAngle + $verifiedAngle }}deg,
                            #e74c3c {{ $pendingAngle + $underInvestigationAngle + $verifiedAngle }}deg {{ $pendingAngle + $underInvestigationAngle + $verifiedAngle + $fakeAngle }}deg,
                            #95a5a6 {{ $pendingAngle + $underInvestigationAngle + $verifiedAngle + $fakeAngle }}deg 360deg
                        );">
                        </div>
                        <div class="pie-legend">
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #3498db;"></div>
                                <div class="legend-text">Pending ({{ $status_counts['Pending'] ?? 0 }})</div>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #9b59b6;"></div>
                                <div class="legend-text">Under Investigation ({{ $status_counts['Under Investigation'] ?? 0 }})</div>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #27ae60;"></div>
                                <div class="legend-text">Verified as True ({{ $status_counts['Verified as True'] ?? 0 }})</div>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #e74c3c;"></div>
                                <div class="legend-text">Identified as Fake ({{ $status_counts['Identified as Fake'] ?? 0 }})</div>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #95a5a6;"></div>
                                <div class="legend-text">Rejected ({{ $status_counts['Rejected'] ?? 0 }})</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    @if ($report_type === 'detailed')
        @if ($inquiries->count() > 0)
            <div class="section">
                <div class="section-title">Detailed Inquiries ({{ $inquiries->count() }})</div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Source</th>
                            <th>Submitter</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Review Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inquiries as $inquiry)
                            @php
                                $reviewStatus = 'Not Reviewed';
                                if (in_array($inquiry->InquiryStatus, ['Verified as True', 'Identified as Fake'])) {
                                    $reviewStatus = 'Reviewed';
                                } elseif ($inquiry->InquiryStatus === 'Under Investigation') {
                                    $reviewStatus = 'Pending Review';
                                } elseif ($inquiry->InquiryStatus === 'Rejected') {
                                    $reviewStatus = 'Rejected';
                                }
                            @endphp
                            <tr>
                                <td>#{{ $inquiry->InquiryID }}</td>
                                <td>{{ $inquiry->InquiryTitle }}</td>
                                <td>{{ $inquiry->InquirySource ?? 'N/A' }}</td>
                                <td>{{ $inquiry->user ? $inquiry->user->UserName : 'N/A' }}</td>
                                <td>{{ $inquiry->created_at ? $inquiry->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                                <td>
                                    <span class="status-badge status-{{ str_replace(' ', '', strtolower($inquiry->InquiryStatus)) }}">
                                        {{ $inquiry->InquiryStatus ?? 'Pending' }}
                                    </span>
                                </td>
                                <td>{{ $reviewStatus }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if ($inquiries->count() === 0)
            <div class="no-data">
                No inquiries found for the specified criteria and date range.
            </div>
        @endif
    @endif

    <div class="footer">
        <p>This report was generated automatically by the AuthenticityHub Admin System.</p>
        <p>Report contains {{ $total_inquiries }} inquiry(ies) for the period {{ $date_from }} to
            {{ $date_to }}.</p>
    </div>
</body>

</html>
