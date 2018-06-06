<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use DB;

class Address extends Model
{
    use CrudTrait;

    /*
    |-----------------------------------------------------------------
    | GLOBAL VARIABLES
    |------------------------------------T----------------------------
    */

    protected $table = 'addresses';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'postcode',
        'notes',
    ];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    // Model Api Get Address
    public function getAddressModel($id)
    {
        DB::beginTransaction();
        try{
            $address = Address::where('user_id',$id)
                ->select('name','postcode','notes')
                ->get();
            if ($address->count()==0)
                return response()->json([
                    'success'  => false,
                    'message'  =>'No data'
                ],401);
            DB::commit();
            return response()->json([
                'success'  => true,
                'address' => $address,
                'message'  =>'Get data success'
            ],200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json('Internal Server Error', 500);
        }
    }

    // Model Api Put Address
    public function putAddressModel($id,$request)
    {
        DB::beginTransaction();
        try{
            $req = Input::all();
            for ($i=0; $i< count($req); $i++)
            {
                if (isset($request[$i]['id']) and !empty($request[$i]['id'])) {
                    Address::where('user_id', $id)
                        ->where('id', $request[$i]['id'])
                        ->update([
                            'name'     => $request[$i]['name'],
                            'postcode' => $request[$i]['postcode'],
                            'notes'    => $request[$i]['notes'],
                        ]);
                }else {
                    $addpress=new Address();
                    $addpress->user_id  =   $id;
                    $addpress->name     =   $request[$i]['name'];
                    $addpress->postcode =   $request[$i]['postcode'];
                    $addpress->notes    =   $request[$i]['notes'];
                    $addpress->save();
                }
            }
            DB::commit();
            return response()->json([
                'success'  => true,
                'message'  =>'Update information success'
            ],200);
        } catch (\Exception $e) {
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
    public function order_detail()
    {
        return $this->hasMany('App\Models\OrderDetail');
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
