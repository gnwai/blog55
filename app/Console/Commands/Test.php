<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Test extends Command
{
    protected $signature = 'test:http {action : start|stop|restart}';

    protected $description = 'test';

    protected $action;

    public function handle()
    {
        \Log::info('cmd test ok');
        $this->initAction();

        \Log::info("您输入的是: {$this->action} ");
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