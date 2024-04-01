<?php

namespace App\Console\Commands;

use App\Models\Story;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DeleteOldTrashItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-old-trash-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete 30days old story items from the trash';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $thresholdDate = Carbon::now()->subDays(30);
        $deletedCount  = Story::where('deleted_at', '<=', $thresholdDate)->forceDelete();
        if ($deletedCount > 0) {
            $this->info("$deletedCount old items from the trash have been deleted successfully.");
        } else {
            $this->info('No old items found in the trash to delete.');
        }
    }
}
