<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Test extends Command
{
    protected $signature = 'cmd:Test';

    protected $description = 'test';

    public function handle()
    {
        \Log::info('cmd test ok');
    }

}