<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserCollection;
use App\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function info($id)
    {
        return new UserCollection(User::where('id', $id)->get());
    }

    public function updateName(Request $request)
    {
        $valid=Validator::make($request->all(),[
         'user_id'=>'required',

        ]);
        if($valid->fails()){
        	return errorMsg($valid);
        }
        else{
        $user = User::findOrFail($request->user_id);
        $user->update([
            'name' => $request->name, 
            'email' => $request->email
        ]);
        return response()->json([
            'message' => 'Profile information has been updated successfully',
            'name'=>$request->name,
            'email' => $request->email
         ]);
        }
    }
    
     public function updateProfileImage(Request $request)
    {
        $user = User::findOrFail($request->user_id);
         if($request->file('image')){
         $file=$request->file('image');
         $fileName=$request->user_id.'_'.$file->getClientOriginalName();
         $fileName=str_replace("","_",$fileName);
         $file->move('public/uploads/user_image',$fileName);
         }
          $user->update([
            'avatar' => $fileName,
        ]);
        return response()->json([
           'message' => 'Profile information has been updated successfully',
           'avatar' => 'https://thebanarasisaree.com/public/uploads/user_image/'.$fileName,
         ]);
    }
    
}
