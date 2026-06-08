<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

class TestInquiryReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:inquiry {type=summary} {format=pdf}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the inquiry report generation functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing inquiry report generation...');

        try {
            // Create a mock request for inquiry reports
            $request = new Request([
                'report_type' => $this->argument('type'),
                'date_from' => '2020-01-01',
                'date_to' => '2030-12-31',
                'format' => $this->argument('format'),
                'report_category' => 'inquiries',
                'status' => null,
                'agency' => null
            ]);

            $adminController = new AdminController();

            $this->info('Generating ' . $this->argument('type') . ' inquiry report in ' . $this->argument('format') . ' format...');

            $response = $adminController->generateReports($request);

            if ($response) {
                $this->info('✅ Inquiry report generated successfully!');
                $this->info('Response type: ' . get_class($response));

                if (method_exists($response, 'headers')) {
                    $contentType = $response->headers->get('content-type');
                    $this->info('Content-Type: ' . $contentType);
                }
            } else {
                $this->error('❌ Inquiry report generation failed - no response');
            }

        } catch (\Exception $e) {
            $this->error('❌ Error generating inquiry report: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
        }
    }
}
