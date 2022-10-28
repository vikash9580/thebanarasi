<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\Country;
use Artisan;


class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        $state = State::orderBy('state_name', 'ASC');
        $states = $state->paginate(10);
        return view('backend.setup_configurations.states.index',compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
         $countries = Country::where('status','1')->get();
         return view('backend.setup_configurations.states.create',['country'=>$countries]);
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
        State::create($input);
        flash(translate('State has been inserted successfully'))->success();
        return redirect('admin/state');
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
         $edit_data=State::find($id);
         $countries = Country::where('status','1')->get();
         return view('backend.setup_configurations.states.create',['country'=>$countries,'edit_data'=>$edit_data]);
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
        State::find($id)->update($input);
        flash(translate('State has been updated successfully'))->success();
        return redirect('admin/state');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
      
        State::find($id)->delete();
        flash(translate('State has been deleted successfully'))->success();
        return redirect('admin/state');
    }

     public function state_list(Request $request){
         $list= State::where('countries_name',$request->id)->get();
         return response()->json(array('list'=>$list), 200);
        
    }
}
