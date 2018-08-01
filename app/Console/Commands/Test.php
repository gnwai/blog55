<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;


class Test extends Command
{

    protected $signature = 'make:system';

    protected $description = '';

    public function handle()
    {

        file_put_contents(
            app_path('Http/Controllers/Admin/System.php'),
            $this->compileControllerStub()
        );

        file_put_contents(
            base_path('routes/admin.php'),
            file_get_contents(__DIR__.'/stubs/make/routes.stub'),
            FILE_APPEND
        );

    }

    protected function compileControllerStub()
    {
        return str_replace(
            '{{namespace}}',
            $this->getAppNamespace(),
            file_get_contents(__DIR__.'/stubs/make/controllers/HomeController.stub')
        );
    }


}
