<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class RefreshCommand extends Command
{

    protected $signature = 'm:fresh';


    protected $description = 'fresh migrations';

    public function handle()
    {
        if (app()->isProduction()) {
            return self::FAILURE;
        }
        Storage::deleteDirectory('/images/products');
        Storage::deleteDirectory('/images/brands');

        $this->call('migrate:fresh', [
            '--seed' => true
        ]);

        return self::SUCCESS;
    }
}
