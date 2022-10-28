<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
use Auth;
use App\Citie;
use App\State;
use App\Country;
use App\Pincode;
use Validator;
use App\User;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [ 
           	"phone"=>"required|numeric|digits:10|starts_with:6,7,8,9" 
        ]);
        if ($validator->fails()) { 
            flash(translate('Phone have 10 digits and start with 6,7,8,9'))->success();  
              return back();
        }
    	 
        
        
        $address = new Address;
        if($request->has('customer_id')){
            $address->user_id = $request->customer_id;
        }
        else{
            $address->user_id = Auth::user()->id;
        }
        
          $user_data=User::find(Auth::user()->id);

        if(Auth::user()->name=='User'){
              
            $user_data->name=$request->name;

        }
        if(Auth::user()->email==''){
         
         
         $validator = Validator::make($request->all(), [ 
            "email"=>"unique:users" 
        ]);
        if ($validator->fails()) { 
            flash(translate('Email Already exits'))->success();  
              return back();
        }else{
         
            $user_data->email=$request->email;
        }
            
        }

        $user_data->save(); 
        
        $address->address = $request->address;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->postal_code = $request->pincode;
        $address->phone = $request->phone;
        $address->address_type = $request->address_type;
        $address->land_mark = $request->land_mark;
        $address->name = $request->name;
        $address->email = $request->email;
        $address->save();
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request)
    {
         $validator = Validator::make($request->all(), [ 
            "phone"=>"required|numeric|digits:10|starts_with:6,7,8,9" 
        ]);
        if ($validator->fails()) { 
            flash(translate('Phone have 10 digits and start with 6,7,8,9'))->success();  
              return back();
        }
         
         $user_data=User::find(Auth::user()->id);

        if(Auth::user()->name=='User'){
              
            $user_data->name=$request->name;

        }
        if(Auth::user()->email==''){
         
         
         $validator = Validator::make($request->all(), [ 
            "email"=>"unique:users" 
        ]);
        if ($validator->fails()) { 
            flash(translate('Email Already exits'))->success();  
              return back();
        }else{
         
            $user_data->email=$request->email;
        }
            
        }

        $user_data->save(); 
        
        $address = Address::find($request->address_id);
        $address->address = $request->address;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->postal_code = $request->postal_code_name_update;
        $address->phone = $request->phone;
        $address->address_type = $request->address_type;
        $address->land_mark = $request->land_mark;
        $address->name = $request->name;
        $address->email = $request->email;
        $address->save();
        
           flash(translate('Addresss updated successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        if(!$address->set_default){
            $address->delete();
            return back();
        }
        flash(translate('Default address can not be deleted'))->warning();
        return back();
    }

    public function set_default($id){
        foreach (Auth::user()->addresses as $key => $address) {
            $address->set_default = 0;
            $address->save();
        }
        $address = Address::findOrFail($id);
        $address->set_default = 1;
        $address->save();

        return back();
    }
    
   public function state_list(Request $request){
         $list= State::where('countries_name',$request->id)->orderby('state_name')->get();
         return response()->json(array('list'=>$list), 200);
        
    }

    public function city_list(Request $request){
        $list= State::select('cities.city_name as city_name','states.state_name as state_name')->leftJoin('cities', 'cities.state_id', '=', 'states.id')->where('states.state_name',$request->id)->orderby('city_name')->get();
      if(count($list)<1){
        
      }
      else{
          
             return response()->json(array('list'=>$list), 200);
      }
    }
    
     public function pincode_list(Request $request){
        $list= Citie::select('pincodes.pincode as pincode','cities.city_name as city_name')->leftJoin('pincodes', 'pincodes.city_id', '=', 'cities.id')->where('cities.city_name',$request->id)->get();
        
         if(count($list)<1){
        
      }
      else{
          
         return response()->json(array('list'=>$list), 200);
         
      }
        
    }
    
     public function pincode_list_new(Request $request){
        
        $list=Pincode::select('pincodes.pincode','pincodes.countries_name','pincodes.state_id','pincodes.city_id','states.state_name','cities.city_name')->leftjoin('states','pincodes.state_id','states.id')->leftjoin('cities','pincodes.city_id','cities.id')->where('pincodes.pincode',$request->id)->first();
        return $list;
        
    }
    
}
