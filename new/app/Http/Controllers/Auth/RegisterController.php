<?php



namespace App\Http\Controllers\Auth;



use App\User;

use App\Customer;

use App\BusinessSetting;

use App\OtpConfiguration;

use App\Http\Controllers\Controller;

use App\Http\Controllers\OTPVerificationController;

use Illuminate\Auth\Events\Registered;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

use Illuminate\Foundation\Auth\RegistersUsers;

use Cookie;

use Nexmo;

use Twilio\Rest\Client;

use Craftsys\Msg91\Facade\Msg91;



class RegisterController extends Controller

{

    /*

    |--------------------------------------------------------------------------

    | Register Controller

    |--------------------------------------------------------------------------

    |

    | This controller handles the registration of new users as well as their

    | validation and creation. By default this controller uses a trait to

    | provide this functionality without requiring any additional code.

    |

    */



    use RegistersUsers;



    /**

     * Where to redirect users after registration.

     *

     * @var string

     */

    protected $redirectTo = '/';



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('guest');

    }



    /**

     * Get a validator for an incoming registration request.

     *

     * @param  array  $data

     * @return \Illuminate\Contracts\Validation\Validator

     */

    protected function validator(array $data)

    {

        return Validator::make($data, [

            'phone'=> 'numeric|digits:10|starts_with:6,7,8,9',

        ]);

    }



    /**

     * Create a new user instance after a valid registration.

     *

     * @param  array  $data

     * @return \App\User

     */

        protected function create(array $data)

    {

        if(!empty($data['is_wholesale_customer'])){

        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

            $user = User::create([

                'name' => $data['name'],

                'email' => $data['email'],

                'password' => Hash::make($data['password']),

                'shop_name' => $data['shop_name'],

                'gst_number' => $data['gst_number'],

                'is_wholesale_customer' => $data['is_wholesale_customer'],

            ]);



            $customer = new Customer;

            $customer->user_id = $user->id;

            $customer->save();

        }

        else {

            if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated){

                $user = User::create([

                    'name' => $data['name'],

                    // 'phone' => '+'.$data['country_code'].$data['phone'],

                    'phone' =>$data['phone'],

                    'password' => Hash::make($data['password']),

                    'verification_code' => rand(100000, 999999),

                    'shop_name' => $data['shop_name'],

                    'gst_number' => $data['gst_number'],

                    'is_wholesale_customer' => $data['is_wholesale_customer'],

                ]);



                $customer = new Customer;

                $customer->user_id = $user->id;

                $customer->save();



                $otpController = new OTPVerificationController;

                $otpController->send_code($user);

            }

        }

        }else{

            

           if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

            $user = User::create([

                'name' => $data['name'],

                'email' => $data['email'],

                'password' => Hash::make($data['password']),

            ]);



            $customer = new Customer;

            $customer->user_id = $user->id;

            $customer->save();

        }

         else {

            if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated){

             

                if (User::where('phone', $data['phone'])->first() != null) {

                  

                    $otp=rand(100000, 999999);

                     $users = User::where('phone',$data['phone'])->update([

                    'verification_code' =>$otp ,

                ]);

                $user = User::where('phone', $data['phone'])->first();
                   $user_name=$user->name;
                  if(empty($user_name)){
                    $user_name='Customer';
                  }
                 Msg91::sms()->to('91'.$user->phone)->flow('6325bc8eaef8eb730a0851f3')->variable('user', $user_name)->variable('otp', $otp)->send();

                }else{

                     $otp=rand(100000, 999999);

                $user = User::create([

                    'name' => '',

                    // 'phone' => '+'.$data['country_code'].$data['phone'],

                    'phone' =>$data['phone'],

                    'password' => Hash::make('123456'),

                    'verification_code' => $otp,

                ]);



                $customer = new Customer;

                $customer->user_id = $user->id;

                $customer->save();

              $user_name=$user->name;
                  if(empty($user_name)){
                    $user_name='Customer';
                  }

                Msg91::sms()->to('91'.$user->phone)->flow('6325bc8eaef8eb730a0851f3')->variable('user', $user_name)->variable('otp', $otp)->send();

                }

            }

        }  

            

        }



        if(Cookie::has('referral_code')){

            $referral_code = Cookie::get('referral_code');

            $referred_by_user = User::where('referral_code', $referral_code)->first();

            if($referred_by_user != null){

                $user->referred_by = $referred_by_user->id;

                $user->save();

            }

        }



        return $user;

    }



  //  public function register(Request $request)

  //  {

  //      if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {

 //           if(User::where('email', $request->email)->first() != null){

 //               flash(translate('Email or Phone already exists.'));

 //               return back();

 //           }

 //       }

        



 //      $this->validator($request->all())->validate();



 //       $user = $this->create($request->all());



      //  $this->guard()->login($user);



   //     if($user->email != null){

  //          if(BusinessSetting::where('type', 'email_verification')->first()->value != 1){

  //              $user->email_verified_at = date('Y-m-d H:m:s');

 //               $user->save();

  //              flash(translate('Registration successfull.'))->success();

  //          }

 //           else {

  //              event(new Registered($user));

  //              flash(translate('Registration successfull. Please verify your email.'))->success();

  //          }

  //      }



   //     return $this->registered($request, $user)

  //          ?: redirect($this->redirectPath());

 //   }

  

   public function register(Request $request)

    {

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {

            if(User::where('email', $request->email)->first() != null){

                flash(translate('Email or Phone already exists.'));

                return back();

            }

        }



        $user = $this->create($request->all());

     

        return $this->registered($request, $user)

            ?: redirect($this->redirectPath());

    }

  



    protected function registered(Request $request, $user)

    {

       

            $request->session()->put('phone',$user->phone);

            return redirect()->route('verification');

       

    }

}

