<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Password;

class AuthenticationApiController extends Controller
{
    // Function Api Post Login
    public function postlogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(
                    [   'success' => false,
                        'message' => 'Account or password is incorrect'], 401);
            }
            $user = Auth::user();
            return response()->json([
                'success'  => true,
                'token'    => $token,
                'data'     => $user,
                'message'  => 'Login success',
            ]);
        } catch (JWTException $e) {
            return response()->json(['Error' => 'Internal Server Error'], 500);
        }
    }

    // Function APi Post Register
    public function postRegister(Request $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->only(
                'first_name',
                'last_name',
                'email',
                'password',
                'remember_token',
                'estimated_consumption',
                'referral_number',
                'identification_type',
                'identification_image',
                'identification_number'
            );
            $validator = Validator::make($input, [
                'first_name'            => 'required',
                'last_name'             => 'required',
                'email'                 => 'required|email|unique:users',
                'password'              => 'required',
                'estimated_consumption' => 'required|numeric',
                'referral_number'       => 'required|numeric',
                'identification_type'   => 'required|numeric',
                'identification_image'  => 'required',
                'identification_number' => 'required|numeric',
            ]);
            if($validator->fails()){
                return response([
                    'success'  => false,
                    'message'  => $validator->errors(),
                ], 401);

            }
            $user = new User();
            $user->role_id                = 2;
            $user->first_name             = $request->first_name;
            $user->last_name              = $request->last_name;
            $user->email                  = $request->email;
            $user->password               = bcrypt($request->password);
            $user->estimated_consumption  = $request->estimated_consumption;
            $user->referral_number        = $request->referral_number;
            $user->identification_type    = $request->identification_type;
            $user->identification_image   = $request->identification_image;
            $user->identification_number  = $request->identification_number;
            $user->save();
            DB::commit();
            return response([
                'success'  => true,
                'user'     => $user,
                'message'  => 'Account register success',
            ], 200);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json('Internal Server Error', 500);
        }
    }
    // Function Api Forgot Password
    public function sendResetEmail(Request $request)
    {
        $user = User::where('email', '=', $request->get('email'))->first();
        if(!$user) {
            return response()->json(
                [   'success' => false,
                    'message' => 'The Email Is Incorrect'], 401);
        }
        $broker = $this->getPasswordBroker();
        $sendingResponse = $broker->sendResetLink($request->only('email'));
        if($sendingResponse !== Password::RESET_LINK_SENT) {
            throw new HttpException(500,'Internal Server Error');
        }
        return response()->json([
            'success'  => true,
            'message'  => 'Password Reset Email Sent'
        ], 200);
    }

    private function getPasswordBroker()
    {
        return Password::broker();
    }

    // Function Api Get Detail User
    public function getDetailUser($id)
    {
        $detail=new User();
        $detail=$detail->getDetailUserModel($id);
        if ($detail==false)
            return response()->json([
                'success'  => false,
                'message'  =>'No data'
            ], 401);
        return response()->json([
            'success'  => true,
            'detail'   => $detail,
            'message'  =>'Get data success'
        ], 200);
    }

    // Function Api Put Detail User
    public function putDetailUser($id,Request $request)
    {
        $detail=new User();
        $detail=$detail->putDetailUserModel($id,$request);
        return $detail;
    }
}
