<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class TestReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:reports {type=summary} {format=pdf}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the report generation functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing report generation...');

        try {
            // Create a mock request
            $request = new Request([
                'report_type' => $this->argument('type'),
                'date_from' => '2020-01-01',
                'date_to' => '2030-12-31',
                'user_type' => null,
                'format' => $this->argument('format'),
                'report_category' => 'users'  // Default to users for testing
            ]);

            $adminController = new AdminController();

            $this->info('Generating ' . $this->argument('type') . ' report in ' . $this->argument('format') . ' format...');

            $response = $adminController->generateReports($request);

            if ($response) {
                $this->info('✅ Report generated successfully!');
                $this->info('Response type: ' . get_class($response));

                if (method_exists($response, 'headers')) {
                    $contentType = $response->headers->get('content-type');
                    $this->info('Content-Type: ' . $contentType);
                }
            } else {
                $this->error('❌ Report generation failed - no response');
            }

        } catch (\Exception $e) {
            $this->error('❌ Error generating report: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
        }
    }
}
