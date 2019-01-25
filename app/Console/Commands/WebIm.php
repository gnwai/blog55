<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\WebIm as WebImCtl;

class WebIm extends Command
{
    protected $signature = 'WebIm:http {action : start|stop|restart} {--d}';

    protected $description = 'webIm run';

    protected $action;

    public function handle()
    {
        $this->initAction();

//        \Log::info("您输入的是: {$this->action} ");

        global $argv;

        $action = $this->argument('action');

        $argv[0] = 'WebIm';
        $argv[1] = $action;
        $argv[2] = $this->option('d') ? '-d' : '';

        $webIm = new WebImCtl();
        $webIm->start();
    }



    /**
     * Initialize command action.
     */
    protected function initAction()
    {
        $this->action = $this->argument('action');

        if (! in_array($this->action, ['start', 'stop', 'restart'])) {
            $this->error("Invalid argument '{$this->action}'. Expected 'start', 'stop', 'restart', 'reload' or 'infos'.");
            exit(1);
        }
    }

}