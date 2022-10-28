<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="" rel="icon" />
@if($quotation[0]->business_name=="mz_group_textiles")
<title>Quotation | MZ GROUP TEXTILES</title>
@else
<title>Quotation | THE BANARASI SAREE</title>
@endif
<meta name="author" content="harnishdesign.net">

<!-- Web Fonts
======================= -->
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>

<!-- Stylesheet
======================= -->

<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/invoice/vendor/bootstrap/css/bootstrap.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/assets/invoice/vendor/font-awesome/css/all.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/assets/invoice/css/stylesheet.css')}}"/>
</head>
<body>
<!-- Container -->
<div class="container-fluid invoice-container">
  <!-- Header -->
  <header>
  <div class="row align-items-center">
    <!-- <div class="col-sm-4 text-center text-sm-left">
      <address class="text-1">
     <b> GSTIN :</b> 0GAFQPA0760C128<br />
      <b> State :</b> Uttar Pradesh, XYZ<br />
    
      </address>
    </div> -->
    <div class="col-sm-12 p-2 text-center">
      <h4 class="text-5 mb-0">Quotation </h4>
    </div>
    <!--  <div class="col-sm-4 text-center text-sm-right">
     <address class="text-1">
     <b> Mob:-</b> +91-9224536000 ,9044545565 <br />
   
    
      </address>
    </div> -->
  </div>
  <div class="col-lg-12 text-center">
    @if($quotation[0]->business_name=="mz_group_textiles")
        <h2><b>MZ GROUP TEXTILES</b></h2>
    @else
        <h2><b>THE BANARASI SAREE</b></h2>
    @endif
    
  </div>
  <hr>
  </header>
  @php
      $seller_details = App\Followup::where('quotation_number', $quotation[0]->quotation_number)->first();
      $address = App\Address::where('id', $quotation[0]->address)->first();
  @endphp
  <!-- Main Content -->
  <main>
  <div class="row">
    <div class="col-sm-6 text-sm-right order-sm-1"> <strong>To:</strong>
    
      <address>
        @if($quotation[0]->for_other == 1)
            {{$quotation[0]->other_name}}</br>
            {{$quotation[0]->other_phone}}</br>
        @else
            {{ $quotation[0]->reseller->name }}<br />
            {{ $quotation[0]->reseller->phone }}<br />
            @if($address != null )
              {{$address->address}}, {{$address->city}},<br/> 
              {{$address->state}}, {{$address->country}} - {{$address->postal_code}}<br />
            @else
                ---
            @endif
        @endif
      </address>
      
    </div>
    <div class="col-sm-6 order-sm-0"> <strong>From:</strong>
      <address>
            @if($quotation[0]->business_name=="mz_group_textiles")
                MZ GROUP TEXTILES<br />
                J 14/178, QAZI SADULLAH PURA, </br>(near Chhavi Mahal Cinema),<br />
                VARANASI-221001 U.P. INDIA<br />
                +91-9389539835
            @else
                THE BANARASI SAREE<br/>
                S 20/53 4 BUDDHA BIHAR COLONY,<br />
                VARANASI-221002 U.P. INDIA<br />
                +91-7985669200
            @endif
      </address>
    </div>
  </div>
  <hr> 
   <div class="row">
    <div class="col-sm-6">
        @if($quotation[0]->business_name=="mz_group_textiles")
            <strong> GSTIN :</strong> 09AFQPA0760C1ZS<br />
            <strong> Email :</strong> info@mzgrouptextiles.com<br />
        @else
            <strong> GSTIN :</strong> 09CIDPA5385B1ZJ<br />
            <strong> Email :</strong> info@thebanarasisaree.com<br />
        @endif
    </div>
    <div class="col-sm-6 text-sm-right">
    
    <strong>Quotation No. :</strong> {{ $quotation[0]->quotation_number }}
    <br/>
    <strong>Quotation Date :</strong> {{ $quotation[0]->date }}
    <br/>
    </div>
    
  </div>
  <hr> 

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0">
		<thead class="card-header">

          <tr>
             <td class="col-1 border text-center" rowspan="2"><strong>S.NO.</strong></td>
             <td class="col-2 border text-center" rowspan="2"><strong>Images</strong></td>
            <td class="col-3 border text-center" rowspan="2"><strong>Description of Goods</strong></td>
			      <td class="col-1 border text-center" rowspan="2"><strong>HSN</strong></td>
			      <td class="col-2 text-center border" rowspan="2"><strong>QTY</strong></td>
            <td class="col-2 text-center border" rowspan="2"><strong>Rate</strong></td>
            <td class="col-1 text-center border" rowspan="2"><strong>Discount</strong></td>
            <td class="col-2 text-center border" colspan="2"><strong>Amount</strong></td>
          
          </tr>
          

        </thead>
        @php
            $i=0;
            $products= \App\Product::where('id', $quotation[0]->product_id)->first();
        @endphp
          <tbody>
            @foreach ($quotation as $quotation_data)
            @php
		        $variant = \App\ProductStock::where('id', $quotation_data->variant_id)->first();	
	        @endphp
            <tr>
              <td class="border text-center">{{++$i}}</td>
              <td><img height="100" width="100" src={{ uploaded_asset($products->thumbnail_img) }}/></td>
              <td class="col-3 text-center border"><strong>{{ $products->name}}</strong> <small>{{ $variant->variant}}</small></td>
              <td class="col-1 text-center border">2</td>
			        <td class="col-2 text-center border">{{$quotation_data->wholesale_quintity}} {{$quotation_data->type}}</td>
			        <td class="col-2 text-center border">Rs. {{$quotation_data->base_price}}</td>
			       @php
			            $discount=" ";
			            if($quotation_data->wholesale_discount == '$'){
			                 $discount = $quotation_data->base_price - $quotation_data->wholesale_discount;
			            }else{
			                $discount = $quotation_data->base_price/100 * $quotation_data->wholesale_discount;
			            }
			       @endphp 
			        
			        <td class="col-1 text-center border">Rs. {{$quotation_data->wholesale_discount}}</td>
              <td class="col-3 text-center border" colspan="2">Rs. {{$quotation_data->wholesale_discount_price}}</td> 
            </tr>
            
            @endforeach

         
          </tbody>
          <div class="row">
		  <tfoot class="card-footer">
              <tr>
                <td colspan="6" class="text-right"><strong>Total Amt:</strong></td>
                <td colspan="2" class="text-right">Rs. {{$quotation_data->total}}</td>
              </tr>
                @php
                
                    $amount1 = $quotation_data->total * 5 / 100 ; // gst
                    $amount = $quotation_data->total+$amount1; 
                    $amount2 = $amount1/2;
                @endphp
                
               {{-- 
    		      	<tr>
                      <td colspan="7" class="text-right"><strong>IGST:</strong></td>
                      <td class="text-right">Rs. {{number_format((float)$amount1, 2, '.', '') }}</td>
                    </tr>
                --}}
                    <tr>
                      <td colspan="6" class="text-right"><strong>CGST:</strong></td>
                      <td colspan="2" class="text-right">Rs. {{number_format((float)$amount2, 2, '.', '') }}</td>
                    </tr>
        		    <tr>
                      <td colspan="6" class="text-right"><strong>SGST:</strong></td>
                      <td colspan="2" class="text-right">Rs. {{number_format((float)$amount2, 2, '.', '') }}</td>
        
                    </tr>
                    <tr>
                      <td colspan="6" class="text-right"><strong>Courier Charge</strong></td>
                      <td colspan="2" class="text-right">Rs. {{$quotation_data->courier_charge}}</td>
        
                    </tr>
                <tr>
                    <td colspan="6" class="text-right"><strong>Final Amt:</strong></td>
                    @php
                        $final_Amount = $quotation_data->courier_charge+$amount;
                    @endphp
                    <td colspan="2" class="text-right">Rs. {{number_format((float)$final_Amount, 2, '.', '') }}</td>
                </tr>
            
            
            
            <tr>
              <td colspan="5" class="#"><strong>Bank Details</strong> </td>
                @if($quotation[0]->business_name=="mz_group_textiles")
                    <td colspan="4" class="text-center"><strong>MZ GROUP TEXTILES</strong> </td>
                @else
                    <td colspan="4" class="text-center"><strong>THE BANARASI SAREE</strong> </td>
                @endif
            </tr>
            @if($quotation[0]->business_name=="mz_group_textiles")
                <tr>
                  <td class="bg-white"><strong>Bank Name</strong> </td>
                  
                  <td colspan="5" class="bg-white">Bank of Baroda</td>
                  <td colspan="3" class="bg-white text-center text-2"><strong>Signature</strong></td>
                </tr>
                <tr>
                  <td class="bg-white"><strong>A/C No</strong> </td>
                  <td colspan="2" class="bg-white">59030200000190</td>
             
                </tr>
                <tr>
                   <td class="bg-white"><strong>Bank Branch IFSC</strong> </td>
                  <td colspan="2" class="bg-white">BARBONATILM</td>
                  
                </tr>
            @else
                <tr>
                  <td class="bg-white"><strong>Bank Name</strong> </td>
                  
                  <td colspan="5" class="bg-white">HDFC</td>
                  <td colspan="3" class="bg-white text-center text-2"><strong>Signature</strong></td>
                </tr>
                <tr>
                  <td class="bg-white"><strong>A/C No</strong> </td>
                  <td colspan="2" class="bg-white">50200058649895</td>
             
                </tr>
                <tr>
                   <td class="bg-white"><strong>Bank Branch IFSC</strong> </td>
                  <td colspan="2" class="bg-white">HDFC0009381</td>
                  
                </tr>
            @endif
		  </tfoot>
      </div>
        </table>
      </div>
    </div>
  </div>
  
  </main>
  <!-- Footer -->
  <footer class="text-center mt-4">
  <p class="text-1"><strong>Terms and Conditions :</strong></br> Goods once sold will not be taken back </br> After Cheque Bounce Penalty 250/- </br> All Subjects to Varanasi Juridiction only </br> E.&.O.E</p>
  <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a></div>
  </footer>
</div>
</body>
</html>