<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pincode;
use App\Citie;
use App\State;
use App\Country;
use Artisan;

class PincodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
         $pincodes=Pincode::select('pincodes.*','cities.city_name as city_name','states.state_name as state_name')->leftJoin('states', 'states.id', '=', 'pincodes.state_id')->leftJoin('cities', 'cities.id', '=', 'pincodes.city_id')->paginate(10);
       
        return view('backend.setup_configurations.pincodes.index',compact('pincodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
         $countries = Country::where('status','1')->get();
         $states=State::orderby('state_name')->get();
          $cities=Citie::orderby('city_name')->get();
         return view('backend.setup_configurations.pincodes.create',['country'=>$countries,'state'=>$states,'city'=>$cities]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=$request->all();
        Pincode::create($input);
        flash(translate('Pincode has been inserted successfully'))->success();
        return redirect('admin/pincode');
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
         $edit_data=Pincode::find($id);
         $countries = Country::where('status','1')->get();
         $states=State::where('countries_name',$edit_data->countries_name)->get();
         $cities=Citie::where('id',$edit_data->city_id)->get();
         return view('backend.setup_configurations.pincodes.create',['country'=>$countries,'edit_data'=>$edit_data,'state'=>$states,'city'=>$cities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input=$request->all();
        Pincode::find($id)->update($input);
        flash(translate('Pincode has been updated successfully'))->success();
        return redirect('admin/pincode');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
      
        Pincode::find($id)->delete();
        flash(translate('Pincode has been deleted successfully'))->success();
        return redirect('admin/pincode');
    }
}