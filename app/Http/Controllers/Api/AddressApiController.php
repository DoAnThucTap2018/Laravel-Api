<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Input;
use DB;

class AddressApiController extends Controller
{
    // Api Put Address
    public function update($id,Request $request)
    {
        $address=new Address();
        $address=$address->putAddress($id,$request);
        return $address;
    }

    // Api Get Address
    public function index($id)
    {
        $address=new Address();
        $address=$address->getAddress($id);
        return $address;
    }
}
