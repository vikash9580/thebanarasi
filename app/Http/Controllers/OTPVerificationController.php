<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Auth\Events\PasswordReset;

use App\User;

use Auth;

use Nexmo;

use App\OtpConfiguration;

use Twilio\Rest\Client;

use Hash;

use Craftsys\Msg91\Facade\Msg91;

class OTPVerificationController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function verification(Request $request){

        // if (Auth::check() && Auth::user()->email_verified_at == null) {
            $user = User::where('phone', session()->get('phone'))->first();
            $is_name='no';
            if(empty($user->name)){
                $is_name='yes';
            }
            return view('otp_systems.frontend.user_verification',compact('is_name'));

        // }

        // else {

        //     flash('You have already verified your number')->warning();

        //     return redirect()->route('home');

        // }

    }





    /**

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */



    public function verify_phone(Request $request){

        // $user = Auth::user();

        $user = User::where('phone', session()->get('phone'))->first();

        if ($user->verification_code == $request->verification_code) {
                if(!empty($request->name)){
                    $user->name = $request->name ;
                }
            $user->email_verified_at = date('Y-m-d h:m:s');
            $user->save();

            auth()->login($user, true);
            flash('Your phone number has been verified successfully')->success();
            return redirect()->route('home');

        }

        else{

            flash('Invalid Code')->error();

            return back();

        }

    }



    /**

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */



    public function resend_verificcation_code(Request $request){
 
        $user = User::where('phone', session()->get('phone'))->first();

        $user->verification_code = rand(100000,999999);

        $user->save();

            $user_name=$user->name;
                  if(empty($user_name)){
                    $user_name='Customer';
                  }

       Msg91::sms()->to('91'.$user->phone)->flow('6325bc8eaef8eb730a0851f3')->variable('user', $user_name)->variable('otp', $user->verification_code)->send();



        return back();

    }



    /**

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */



    public function reset_password_with_code(Request $request){

        if (($user = User::where('phone', $request->phone)->where('verification_code', $request->code)->first()) != null) {

            if($request->password == $request->password_confirmation){

                $user->password = Hash::make($request->password);

                $user->email_verified_at = date('Y-m-d h:m:s');

                $user->save();

                event(new PasswordReset($user));

                auth()->login($user, true);



                if(auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff')

                {

                    return redirect()->route('admin.dashboard');

                }

                return redirect()->route('home');

            }

            else {

                flash("Password and confirm password didn't match")->warning();

                return back();

            }

        }

        else {

            flash("Verification code mismatch")->error();

            return back();

        }

    }



    /**

     * @param  User $user

     * @return void

     */



    public function send_code($user){

        sendSMS($user->phone, env('APP_NAME'), $user->verification_code.' is your verification code for '.env('APP_NAME'));

    }



    /**

     * @param  Order $order

     * @return void

     */

    public function send_order_code($order){

        if(json_decode($order->shipping_address)->phone != null){

            sendSMS(json_decode($order->shipping_address)->phone, env('APP_NAME'), 'You order has been placed and Order Code is : '.$order->code);

        }

    }



    /**

     * @param  Order $order

     * @return void

     */

    public function send_delivery_status($order){

        if(json_decode($order->shipping_address)->phone != null){

            sendSMS(json_decode($order->shipping_address)->phone, env('APP_NAME'), 'Your delivery status has been updated to '.$order->orderDetails->first()->delivery_status.' for Order code : '.$order->code);

        }

    }



    /**

     * @param  Order $order

     * @return void

     */

    public function send_payment_status($order){

        if(json_decode($order->shipping_address)->phone != null){

            sendSMS(json_decode($order->shipping_address)->phone, env('APP_NAME'), 'Your payment status has been updated to '.$order->payment_status.' for Order code : '.$order->code);

        }

    }

}

