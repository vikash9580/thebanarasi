<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Controllers\Api;

use App\Models\BusinessSetting;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Notifications\EmailVerificationNotification;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $list=User::where('phone',$request->phone)->first(['id','phone']);
        if(!empty($list))
        {
            $list->device_key=$request->fcm_token;
            $list->save();
            return response()->json([
            'message' => 'Sending OTP...','data'=>$list
        ], 200);
        }
        else
        {
        $user = new User([
            'phone' => $request->phone,
            'email_verified_at' => date("Y/m/d h:i:s"),
            'device_key'=>$equest->fcm_token,
            //'email' => $request->email,
            'password' => bcrypt($request->phone)
        ]);

        if(BusinessSetting::where('type', 'email_verification')->first()->value != 1){
            $user->email_verified_at = date('Y-m-d H:m:s');
        }
        else {
            $user->notify(new EmailVerificationNotification());
        }
        $user->save();

        $customer = new Customer;
        $customer->user_id = $user->id;
        $customer->save();
        
        $recipients=User::where('id', $user->id)->pluck('device_key')->toArray();
        fcm()->to($recipients)->priority('high')->timeToLive(0)->notification([
            'title'=>"Customer Registration",
            'body'=>"Thank You,Your Are Successfully Register With Us",
             //'image'=>$news_img_url,
            ])->send();
        
        return response()->json([
            'message' => 'Sending OTP...','data'=>$user->makeHidden(['email_verified_at','verification_code','updated_at','created_at'])
        ], 201);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json(['message' => 'Unauthorized'], 401);
        $user = $request->user();
        if($user->email_verified_at == null){
            return response()->json(['message' => 'Please verify your account'], 401);
        }
        $tokenResult = $user->createToken('Personal Access Token');
        return $this->loginSuccess($tokenResult, $user);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function socialLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email'
        ]);
        if (User::where('email', $request->email)->first() != null) {
            $user = User::where('email', $request->email)->first();
        } else {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'provider_id' => $request->provider,
                'email_verified_at' => Carbon::now()
            ]);
            $user->save();
            $customer = new Customer;
            $customer->user_id = $user->id;
            $customer->save();
        }
        $tokenResult = $user->createToken('Personal Access Token');
        return $this->loginSuccess($tokenResult, $user);
    }

    protected function loginSuccess($tokenResult, $user)
    {
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(100);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => [
                'id' => $user->id,
                'type' => $user->user_type,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'avatar_original' => $user->avatar_original,
                'address' => $user->address,
                'country'  => $user->country,
                'city' => $user->city,
                'postal_code' => $user->postal_code,
                'phone' => $user->phone
            ]
        ]);
    }
}
