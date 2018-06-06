<?php

namespace App\Http\Controllers\Admin;

use App\Models\Address;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderContact;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ShowOrderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Facades\View;



class ShowOrderController extends Controller
{
    public function showOder($id)
    {
        $order=Order::join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
        ->join('order_addresses','orders.order_address_id','=','order_addresses.id')
        ->join('order_contacts','orders.order_contact_id','=','order_contacts.id')
        ->select('orders.id as id','orders.user_id as user_id','orders.*',
            'order_statuses.name as order_status_name',
            'order_addresses.name as order_address_name','order_addresses.postcode','order_addresses.notes',
            'order_contacts.first_name','order_contacts.last_name','order_contacts.mobile','order_contacts.email')
        ->where('orders.id',$id)
        ->get();
       View::share('order',$order);

        $order_detail=OrderDetail::join('orders','order_details.order_id','=','orders.id')
            ->join('items','order_details.item_id','=','items.id')
            ->join('products','items.id','=','products.item_id')
            ->select('order_details.id','order_details.order_id','order_details.*',
                'items.title',
                'products.image')
            ->where('order_details.order_id',$id)
            ->get();
        View::share('order_detail',$order_detail);

        $total = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('total_price')
            ->where('orders.id',$id)
            ->get();
        $total_price=0;
        foreach ($total as $tl) {
            $total_price=$total_price+$tl->total_price;
        }
        $total_pr= $total_price;
        View::share('total',$total_pr);
        return view('admins.order.showorder');
    }

    public function editOrder(ShowOrderRequest $request,$id)
    {

        DB::beginTransaction();
        try {
                // Value update table OrderContact
                $order=Order::find($id);
                $contact_id=$order->order_contact_id;
                $order_contact=OrderContact::find($contact_id);
                $order_contact->first_name = $request->firstname;
                $order_contact->last_name  = $request->lastname;
                $order_contact->mobile     = $request->mobile;
                $order_contact->email      = $request->email;
                $order_contact->save();

                // Value update table OrderAddress
                $order_address_id     = $order->order_address_id;
                $order_address =OrderAddress::find($order_address_id);
                $order_address->name  = $request->address;
                $order_address->notes = $request->note;
                $order_address->save();

                // Value update table Order
                $order = Order::find($id);
                $order->order_status_id = $request->status;
                $order->created_at      = $request->date;
                $order->save();
                 DB::commit();
        }catch (\Exception $e){
             DB::rollback();
            Alert::warning('Update Not failed')->flash();
            return redirect()->back();
        }
        Alert::success('Update successful')->flash();
        return redirect()->back();
    }
}
