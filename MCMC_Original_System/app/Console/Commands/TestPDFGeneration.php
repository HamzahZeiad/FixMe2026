<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PublicUser;
use App\Models\Agency;

class TestPDFGeneration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test PDF generation functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing PDF generation...');

        try {
            // Create test data
            $data = [
                'report_type' => 'summary',
                'date_from' => '2020-01-01',
                'date_to' => '2030-12-31',
                'user_type' => null,
                'public_users' => PublicUser::take(5)->get(),
                'agencies' => Agency::take(5)->get(),
                'total_public_users' => PublicUser::count(),
                'total_agencies' => Agency::count(),
                'total_users' => PublicUser::count() + Agency::count(),
                'generated_at' => now(),
                'generated_by' => 'Test'
            ];

            $this->info('Creating PDF...');
            $pdf = Pdf::loadView('admin.reports.pdf', $data);

            $this->info('✅ PDF generation successful!');
            $this->info('PDF library is working correctly.');

        } catch (\Exception $e) {
            $this->error('❌ PDF generation failed: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
        }
    }
}
