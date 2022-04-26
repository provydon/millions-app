<?php

namespace App\Console\Commands;

use App\Services\General;
use Illuminate\Console\Command;

class AutoDeletePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autodelete:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically delete posts 15 days old.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            General::autoDeleteOldPost();
        } catch (\Throwable $th) {
            throw $th;
        }
        return "done";
    }
}
