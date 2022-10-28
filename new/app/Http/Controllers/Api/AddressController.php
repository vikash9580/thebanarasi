<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AddressCollection;
use App\Address;
use App\Country;
use App\State;
use App\Citie;
use App\Pincode;
use Illuminate\Http\Request;
use App\User;

class AddressController extends Controller
{
    
     public $successStatus = 200;
    
    public function addresses($id)
    {
        return new AddressCollection(Address::where('user_id', $id)->get());
    }

    public function createShippingAddress(Request $request)
    {
        
        $user_data=User::find($request->user_id);

        if($user_data->name=='User'){
              
            $user_data->name=$request->name;

        }
        if($user_data->email==''){
            $user_data->email=$request->email;
        }

        $user_data->save(); 
        
        
        $address = new Address;
        $address->user_id = $request->user_id;
        $address->address = $request->address;
        $address->name = $request->name;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->email = $request->email;
        $address->land_mark = $request->land_mark;
        $address->postal_code = $request->postal_code;
        $address->phone = $request->phone;
        $address->address_type = $request->address_type;
        $address->save();
        
        return response()->json(['address_list'=>new AddressCollection(Address::where('user_id', $request->user_id)->get()),'message' => 'Shipping information has been added successfully']);
    }

    public function deleteShippingAddress($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();
        return response()->json(['address_list'=>new AddressCollection(Address::where('user_id', $address->user_id)->get()),
            'message' => 'Shipping information has been added deleted'
        ]);
    }
    
    public function country()
    {
        $data=Country::where('status',1)->get();
        return response()->json(['success' => 'Success','data'=>$data], $this-> successStatus);
        
    }
     public function state($name)
    {
        $data=State::where('countries_name',$name)->get();
        return response()->json(['success' => 'Success','data'=>$data], $this-> successStatus);
        
    }
     public function city($id)
    {
        $data=Citie::where('state_id',$id)->get();
        return response()->json(['success' => 'Success','data'=>$data], $this-> successStatus);
        
    }
     public function pincode($id)
    {
        $data=Pincode::where('city_id',$id)->get();
        return response()->json(['success' => 'Success','data'=>$data], $this-> successStatus);
        
    }
    
    
}
