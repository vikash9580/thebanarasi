<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Citie;
use App\State;
use App\Country;
use Artisan;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $cities=Citie::select('cities.*','states.state_name as state_name')->leftJoin('states', 'states.id', '=', 'cities.state_id')->orderby('city_name')->paginate(10);
   
        return view('backend.setup_configurations.cities.index',compact('cities'));
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
         return view('backend.setup_configurations.cities.create',['country'=>$countries,'state'=>$states]);
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
        Citie::create($input);
        flash(translate('City has been inserted successfully'))->success();
        return redirect('admin/city');
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
         $edit_data=Citie::find($id);
         $countries = Country::where('status','1')->get();
         $states=State::where('countries_name',$edit_data->countries_name)->get();
         return view('backend.setup_configurations.cities.create',['country'=>$countries,'edit_data'=>$edit_data,'state'=>$states]);
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
        Citie::find($id)->update($input);
        flash(translate('City has been updated successfully'))->success();
        return redirect('admin/city');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
      
        Citie::find($id)->delete();
        flash(translate('City has been deleted successfully'))->success();
        return redirect('admin/city');
    }


     public function city_list(Request $request){
         $list= Citie::where('state_id',$request->id)->get();
         return response()->json(array('list'=>$list), 200);
        
    }
}
