<?php

namespace App\Console;

use App\Console\Commands\GenerateSitemap;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        GenerateSitemap::class,
    ];
  
    protected function schedule(Schedule $schedule): void
    {
         $schedule->command('backup:database')->everySixHours();
         $schedule->command('delete-old-trash-items')->dailyAt('01:00');
         $schedule->command('sitemap:generate')->daily();
    }
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
