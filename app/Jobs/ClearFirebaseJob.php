<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Traits\FirebaseAuthTrait;

class ClearFirebaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use FirebaseAuthTrait;

    public $order;
    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order, $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $canClearFirestore = (bool) setting('clearFirestore', 1);
        // logger("can clear firestore data", [$canClearFirestore]);
        //
        if (in_array($this->order->status, ['failed', 'cancelled', 'delivered', 'completed']) && $canClearFirestore) {
            // logger("clearing firestore data");
            try {
                $firestoreClient = $this->getFirebaseStoreClient();
                $firestoreClient->deleteDocument("orders/" . $this->order->code . "");
            } catch (\Exception $ex) {
                logger("Error deleting firebase firestore document", [$ex->getMessage() ?? $ex]);
            }
        }

        //clear driver new laert node on firebase
        //
        if (!in_array($this->order->status, ['pending']) && !empty($user) && $this->user->hasRole('driver')) {
            try {
                $firestoreClient = $this->getFirebaseStoreClient();
                $driverNewOrderAlertRef = "driver_new_order/" . $this->user->id . "";
                $firestoreClient->deleteDocument($driverNewOrderAlertRef);
            } catch (\Exception $ex) {
                logger("Error deleting driver new order alert firestore document", [$ex->getMessage() ?? $ex]);
            }
        }
    }
}
