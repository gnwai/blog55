<?php

namespace App\Console\Commands\Finance;

use App\Service\SyncCommand\Amazon\Finance\Finance as Service;
use Illuminate\Console\Command;

# 轮询的demo
class Download extends Command
{
    protected $signature = Service::SYNC_TYPE;


    protected $description = '亚马逊账期更新';


    public function handle(Service $service)
    {

        if (!$service->handle('US')) {
            \Log::info(json_encode($service->debug()));
        }

//	    if (!$service->handle('UK')) {
//		    \Log::info(json_encode($service->debug()));
//	    }

    }





}