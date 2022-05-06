<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\JobHandlerService;
use App\Traits\FirebaseAuthTrait;
use App\Traits\OrderTrait;

class TaxiOrderObserver
{

    use FirebaseAuthTrait, OrderTrait;

    public function updated(Order $model)
    {

        $driver = $model->driver;
        //update driver node on firebase 
        if (!empty($driver)) {
            (new JobHandlerService())->driverDetailsJob($driver);
        }

        //
        $this->clearFirestore($model);
    }
}
