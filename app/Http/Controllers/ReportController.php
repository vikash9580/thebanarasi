<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Seller;
use App\User;
use App\Search;
use App\Order;
use App\Quotation;
use App\Followup;

class ReportController extends Controller
{
    public function stock_report(Request $request)
    {
        $sort_by =null;
        $products = Product::orderBy('created_at', 'desc');
        if ($request->has('category_id')){
            $sort_by = $request->category_id;
            $products = $products->where('category_id', $sort_by);
        }
        $products = $products->paginate(15);
        return view('backend.reports.stock_report', compact('products','sort_by'));
    }

    public function in_house_sale_report(Request $request)
    {
        $sort_by =null;
        $products = Product::orderBy('num_of_sale', 'desc')->where('added_by', 'admin');
        if ($request->has('category_id')){
            $sort_by = $request->category_id;
            $products = $products->where('category_id', $sort_by);
        }
        $products = $products->paginate(15);
        return view('backend.reports.in_house_sale_report', compact('products','sort_by'));
    }

    public function seller_sale_report(Request $request)
    {
        $sort_by =null;
        $sellers = Seller::orderBy('created_at', 'desc');
        if ($request->has('verification_status')){
            $sort_by = $request->verification_status;
            $sellers = $sellers->where('verification_status', $sort_by);
        }
        $sellers = $sellers->paginate(10);
        return view('backend.reports.seller_sale_report', compact('sellers','sort_by'));
    }

    public function wish_report(Request $request)
    {
        $sort_by =null;
        $products = Product::orderBy('created_at', 'desc');
        if ($request->has('category_id')){
            $sort_by = $request->category_id;
            $products = $products->where('category_id', $sort_by);
        }
        $products = $products->paginate(10);
        return view('backend.reports.wish_report', compact('products','sort_by'));
    }

    public function user_search_report(Request $request){
        $searches = Search::orderBy('count', 'desc')->paginate(10);
        return view('backend.reports.user_search_report', compact('searches'));
    }
    
    
     public function agent_report(Request $request)
    {
        // $sort_by =null;
        // $products = Product::orderBy('created_at', 'desc');
        // if ($request->has('category_id')){
        //     $sort_by = $request->category_id;
        //     $products = $products->where('category_id', $sort_by);
        // }
        // $products = $products->paginate(10);
        // return view('backend.reports.agent_report', compact('products','sort_by'));
        
       
        $sort_search = null;
        $date_range=null;
        $user_id=null;
            $orders = Order::orderBy('code', 'desc');
            $quotations = Quotation::where('follow_up_status', 0)->groupBy('quotation_number')->orderBy('id', 'DESC');
            $follow_ups = Followup:: where('follow_up_status', 1)->orderBy('id', 'DESC');
          
         if($request->user_id){
             $user_id=$request->user_id;
            $orders =$orders->where('staff_id',$request->user_id)->orderBy('code', 'desc');
             $quotations =$quotations->where('user_id',$request->user_id)->orderBy('id', 'DESC');
                $follow_ups =$follow_ups->where('user_id',$request->user_id)->orderBy('id', 'DESC');
         }
         if($request->date_range){
             $date_range=$request->date_range;
               $date_var                 = explode(" / ", $request->date_range);
             
                $start_date       = strtotime($date_var[0]);
                $end_date         = strtotime( $date_var[1]);
                
              $orders = $orders->whereBetween('date', [$start_date, $end_date])->orderBy('code', 'desc');
               $quotations = $quotations->whereBetween('date', [$date_var[0], $date_var[1]])->orderBy('id', 'DESC');
                $follow_ups = $follow_ups->whereBetween('last_date', [$date_var[0], $date_var[1]])->orderBy('id', 'DESC');
                
         }
        //  if ($request->has('search')){
        //      $sort_search = $request->search;
        //      $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
        //  }
           
         $orders = $orders->paginate(15);
         $quotations=$quotations->paginate(15);
         $follow_ups=$follow_ups->paginate(15);
         return view('backend.reports.agent_report', compact('orders', 'sort_search','date_range','user_id','quotations','follow_ups'));
      
        
        
        
    }
}
