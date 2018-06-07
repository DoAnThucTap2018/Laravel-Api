<?php

namespace App\Http\Controllers\Api;

use App\Models\OrderAddress;
use App\Models\OrderContact;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PaymentApiController extends Controller
{
    public function payProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            $user=User::find($request['Order']['user_id']);
            // Value update table OrderAddress
            $order_address              = new OrderAddress();
            $order_address->name        = $request['Order_Address']['name'];
            $order_address->postcode    = $request['Order_Address']['postcode'];
            $order_address->notes       = $request['Order_Address']['notes'];
            $order_address->save();

            // Value update table OrderContact
            $order_contact              = new OrderContact();
            $order_contact->first_name  = $request['Order_Contact']['first_name'];
            $order_contact->last_name   = $request['Order_Contact']['last_name'];
            $order_contact->mobile      = $request['Order_Contact']['mobile'];
            $order_contact->email       = $user->email;
            $order_contact->save();

            // Value update table Order
            $order                      = new Order();
            $order->user_id             = $request['Order']['user_id'];
            $order->order_status_id     = 1;
            $order->order_address_id    = $order_address->id;
            $order->payment_type_id     = $request['Order']['payment_type_id'];
            $order->order_contact_id    = $order_contact->id;
            $order->save();

            foreach ($request->Order_Detail as $ord) {
                // Value update table OrderDetail
                $amount = ($ord['price'] * $ord['quantity']) * ((100 - $ord['discount']) / 100);
                $order_detail              = new  OrderDetail();
                $order_detail->item_id     = $ord['item_id'];
                $order_detail->order_id    = $order->id;
                $order_detail->quantity    = $ord['quantity'];
                $order_detail->price       = $ord['price'];
                $order_detail->discount    = $ord['discount'];
                $order_detail->total_price = $amount;
                $order_detail->save();
            }
            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
            return response()->json([
                'success'  => false,
                'status'   =>'Invalid ID supplied'],200);
        }
        if ($success)
            return response()->json([
                'success'  => true,
                'status'=>'Order success',
            ],200);
    }
}
