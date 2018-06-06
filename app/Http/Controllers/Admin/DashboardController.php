<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function Dashboard()
    {
        $order_detail=Order::join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('items','order_details.item_id','=','items.id')
            ->join('products','items.id','=','products.item_id')
            ->select('orders.id',
                'orders.order_status_id',
                'order_statuses.name',
                'order_details.total_price',
                'items.title')
            ->get();
        View::share('order_detail',$order_detail);

        $total = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('total_price')
            ->where('orders.id')
            ->get();
        $total_price=0;
        foreach ($total as $tl) {
            $total_price=$total_price+$tl->total_price;
        }
        $total_pr= $total_price;
        View::share('total',$total_pr);

        return view('vendor.backpack.base.dashboard',['a'=>$order_detail]);
    }
}
