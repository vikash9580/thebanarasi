<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Auth;
use App\MessageTemplate;

class MessageController extends Controller
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
        $message = new Message;
        $message->conversation_id = $request->conversation_id;
        $message->user_id = Auth::user()->id;
        $message->message = $request->message;
        $message->save();
        $conversation = $message->conversation;
        if ($conversation->sender_id == Auth::user()->id) {
            $conversation->receiver_viewed ="1";
        }
        elseif($conversation->receiver_id == Auth::user()->id) {
            $conversation->sender_viewed ="1";
        }
        $conversation->save();
        
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function message_template(Request $request){
        $list=MessageTemplate::orderBy('id','desc')->paginate(5);
        return view('backend.message.message_template',compact('list'));
    }
    
     public function flow_info(Request $request){
        $id=$request->flow_id;
        $data=flowinfo($id);
        return $data;
     }
     
      public function all_flows(Request $request){
        $data=all_flows();
        return $data;
     }
     
     public function message_template_create(Request $request){
        
        $list=new MessageTemplate;
        $list->flow_id=$request->flow_id;
        $list->title=$request->title;
        $list->variable=$request->variable;
        $list->body=$request->body;
        $list->save();
        
      return redirect()->route('message.template');
        
    }
    
    public function message_template_delete($id){
        $list=MessageTemplate::find($id)->delete();
        
      return redirect()->route('message.template');
        
    }
}
