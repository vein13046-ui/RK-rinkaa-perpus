<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteOldBorrowHistories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'borrow:history-cleanup';

    protected $description = 'Delete borrow histories that are older than 18 hours';

    public function handle()
    {
        $deleted = \App\Models\BorrowRequest::where('status', 'returned')
            ->where('returned_at', '<', now()->subHours(18))
            ->delete();

        $this->info("Deleted {$deleted} old borrow histories.");
    }
}
