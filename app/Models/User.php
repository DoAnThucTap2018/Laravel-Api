<?php

namespace App\Models;

use Backpack\Base\app\Notifications\ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Validator;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use DB;
use App\Notifications\MailResetPasswordToken;


class User extends Authenticatable implements JWTSubject
{
    use CrudTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'password',
        'image',
        'role_id',
        'mobile',
        'estimated_consumption',
        'referral_number',
        'identification_type',
        'identification_image',
        'identification_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    // Function Model Api Get Detail User
    public function getUser($id)
    {
        try{
            $detail = User::select('email','mobile')->find($id);
            if ($detail==null) {
                return false;
            }
            if ( $detail->count()!=0) {
                return $detail;
            }
            return false;
        } catch (\Exception $e) {
            return response()->json('Internal Server Error', 500);
        }
    }

    // Function Model Api Put Detail User
    public function putUser($id, $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->only(
                'email',
                'password',
                'oldpass',
                'mobile'
            );
            $validator = Validator::make($input, [
                'oldpass'  => 'required',
                'password' => 'required',
                'email'    => 'required|email',
                'mobile'   => 'required|numeric|digits_between:3,15',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success'  => false,
                    'message'  =>$validator->errors()
                ],200);

            }
            if (!Auth::attempt(array('email' => $request->email, 'password' => $request->oldpass))) {
                return response()->json([
                    'success'  => false,
                    'message'  =>'Email or password is incorrect'
                ],200);
            }
            $user = User::find($id);
            $user->email    = $input['email'];
            $user->mobile   = $input['mobile'];
            $user->password = bcrypt($input['password']);
            $user->save();
            DB::commit();
            return response()->json([
                'success'  => true,
                'data'     => [
                    $user->email,
                    $user->mobile,
                    $user->password],
                'message' => 'Update information successfully',
            ], 200);
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

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
    public function address()
    {
        return $this->hasMany('App\Models\Address');
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "images";
        $destination_path = "default";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            // 3. Save the path to the database
            $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
        }
    }

}

