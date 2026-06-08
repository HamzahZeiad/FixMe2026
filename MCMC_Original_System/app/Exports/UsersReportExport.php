<?php

namespace App\Exports;

class UsersReportExport
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function export()
    {
        // Create CSV content
        $csv = "Users Report\n";
        $csv .= "Generated on: " . $this->data['generated_at']->format('F j, Y g:i A') . "\n";
        $csv .= "Date Range: " . $this->data['date_from'] . " to " . $this->data['date_to'] . "\n";
        $csv .= "Report Type: " . ucfirst($this->data['report_type']) . "\n";
        $csv .= "\n";

        // Add summary
        $csv .= "SUMMARY\n";
        $csv .= "Total Public Users," . $this->data['total_public_users'] . "\n";
        $csv .= "Total Agencies," . $this->data['total_agencies'] . "\n";
        $csv .= "Total Users," . $this->data['total_users'] . "\n";
        $csv .= "\n";

        if ($this->data['report_type'] === 'detailed') {
            // Public Users section
            if ($this->data['public_users']->count() > 0) {
                $csv .= "PUBLIC USERS\n";
                $csv .= "ID,Username,Email,Phone,Created Date\n";

                foreach ($this->data['public_users'] as $user) {
                    $csv .= $user->UserID . ",";
                    $csv .= '"' . $user->UserName . '",';
                    $csv .= '"' . $user->UserEmail . '",';
                    $csv .= '"' . ($user->UserPhoneNum ?? 'N/A') . '",';
                    $csv .= '"' . ($user->created_at ? $user->created_at->format('Y-m-d') : 'N/A') . '"' . "\n";
                }
                $csv .= "\n";
            }

            // Agencies section
            if ($this->data['agencies']->count() > 0) {
                $csv .= "AGENCIES\n";
                $csv .= "ID,Agency Name,Username,Email,Phone,Type,Created Date\n";

                foreach ($this->data['agencies'] as $agency) {
                    $csv .= $agency->AgencyID . ",";
                    $csv .= '"' . $agency->AgencyName . '",';
                    $csv .= '"' . $agency->AgencyUserName . '",';
                    $csv .= '"' . $agency->AgencyEmail . '",';
                    $csv .= '"' . ($agency->AgencyPhoneNum ?? 'N/A') . '",';
                    $csv .= '"' . $agency->AgencyType . '",';
                    $csv .= '"' . ($agency->created_at ? $agency->created_at->format('Y-m-d') : 'N/A') . '"' . "\n";
                }
            }
        }

        return $csv;
    }
}
