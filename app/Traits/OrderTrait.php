<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Services\FirestoreRestService;
use App\Services\JobHandlerService;

trait OrderTrait
{
    use GoogleMapApiTrait;
    use FirebaseAuthTrait;

    public function getNewOrderStatus(Request $request)
    {

        $orderDate = Carbon::parse("" . $request->pickup_date . " " . $request->pickup_time . "");
        $hoursDiff = Carbon::now()->diffInHours($orderDate);

        if (!empty($request->pickup_date) && $hoursDiff > setting('minScheduledTime', 2)) {
            return "scheduled";
        } else {
            return "pending";
        }
    }



    // DATA
    public function clearFirestore(Order $order)
    {
        //clear firebase data
        (new JobHandlerService())->clearFCMJob($order);
    }

    public function clearDriverNewOrderFirestore()
    {

        //
        try {
            $firestoreRestService = new FirestoreRestService();
            $expiredDriverNewOrders = $firestoreRestService->exipredDriverNewOrders();
            foreach ($expiredDriverNewOrders as $expiredDriverNewOrder) {
                try {
                    (new JobHandlerService())->clearDriverFCMJob($expiredDriverNewOrder);
                } catch (\Exception $ex) {
                    logger("Error deleting driver new order alert firestore document", [$ex->getMessage() ?? $ex]);
                }
            }
        } catch (\Exception $ex) {
            logger("Error deleting firebase firestore document", [$ex->getMessage() ?? $ex]);
        }
    }
}
