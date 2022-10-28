<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BannerCollection;
use App\Banner;
use App\BusinessSetting;

class BannerController extends Controller
{

    public function index()
    {
        
       //return new BannerCollection(Banner::orderBy('id', 'asc')->limit(4)->get());
      //$banner= BusinessSetting::where('type','home_banner1_images')->first();
      
      //return json_decode($banner->value, true);
      //$total=json_decode($banner->value, true);
     // return $total[0];
      //$one=
      //$two= Banner::where('position', 2)->first();
      //$three= Banner::where('position', 3)->first();
      //$four= Banner::where('position', 4)->first();
      //$five= Banner::where('position', 5)->first();
    //   return [
    //       'data'=>array(
    //           'one'=>$total != null ? array(
    //                  'photo' => api_asset($total[0]),
    //                  'url' => "",
    //                  'status' => 1,
    //               ):null,
    //           'two'=>$total != null ? array(
    //                  'photo' => api_asset($total[1]),
    //                  'url' => "",
    //                  'status' => 1,
    //               ):null,
    //           'three'=>$total != null ? array(
    //                  'photo' =>api_asset($total[2]),
    //                  'url' => "",
    //                  'status' => 1,
    //               ):null,   
    //           )
    //       ];
    
        return new BannerCollection(json_decode(get_setting('home_banner1_images'), true));
    }
}
