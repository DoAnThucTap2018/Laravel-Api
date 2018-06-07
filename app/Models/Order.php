<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\OrderDetail;

class Order extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |------------------------------------T----------------------------
    */

    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'user_id',
        'order_status_id',
        'order_address_id',
        'order_contact_id',
        'payment_type_id',
    ];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
    ];
    public function edit($crud = false)
    {
        return '<a class="btn btn-xs btn-default" href="'.route('showorder',$this->id).'"><i class="fa fa-edit"></i> Edit</a>';
    }
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getUserId(){
        $fullname= OrderContact::find($this->order_contact_id);
        $fullname=$fullname->first_name ." ".$fullname->last_name;
        return $fullname;
    }
    public function getTotalPrice() {
        $total = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('total_price')
            ->where('orders.id',$this->id)
            ->get();
        $total_price=0;
        foreach ($total as $tl) {
            $total_price=$total_price+$tl->total_price;
        }
        return $total_price;
    }
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS  API
    |--------------------------------------------------------------------------
    */
    // Model Api Get Order
    public function getOrderModel($id)
    {
        DB::beginTransaction();
        try {
            $list_order=Order::join('order_statuses','orders.order_status_id','=','order_statuses.id')
                ->select('orders.id as order_id','orders.user_id as user_id','orders.order_status_id as order_status_id','orders.created_at as date','order_statuses.name as order_status_name')
                ->where('user_id',$id)
                ->get();
            if ($list_order->count()!=0) {
                foreach ($list_order as $lo) {
                        $datas['order_id']   = $lo->order_id;
                        $datas['order_date'] = $lo->date;
                        $datas['order_name'] = $lo->order_status_name;
                        $orders = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
                            ->join('items','order_details.item_id','=','items.id')
                            ->join('products','items.id','=','products.item_id')
                            ->select(
                                'items.title',
                                'order_details.quantity',
                                'order_details.total_price',
                                'orders.created_at',
                                'products.image as product_image'
                            )
                            ->where('orders.user_id','=',$lo->user_id )
                            ->where('orders.order_status_id','=',$lo->order_status_id)
                            ->get();
                        DB::commit();
                        $datas['orders'] = $orders;
                        $results[] = $datas;
                    }
                return response()->json([
                    'success'  => true,
                    'data'     => $results,
                    'message'  => 'Get data success'],200);
            }
            return response()->json([
                'success'  => false,
                'message'  => 'Invalid ID supplied'],200);
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json('Internal Server Error', 500);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function order_status()
    {
        return $this->belongsTo('App\Models\OrderStatus');
    }
    public function order_detail()
    {
        return $this->hasMany('App\Models\OrderDetail');
    }
    public function order_address()
    {
        return $this->belongsTo('App\Models\OrderAddress');
    }
    public function payment_type()
    {
        return $this->belongsTo('App\Models\PaymentType');
    }
    public function order_contact()
    {
        return $this->belongsTo('App\Models\OrderContact');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
