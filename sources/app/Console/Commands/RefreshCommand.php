<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Help to refresh data for project on !!! dev !!!';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (!app()->isProduction()) {
            Storage::deleteDirectory('images/products');
            //Storage::createDirectory('images/products');
            $this->call('migrate:fresh', ['--seed' => true]);
        } else {
            $this->warn('Sorry, you in production! Not executed.');
        }
        return static::SUCCESS;
    }
}
