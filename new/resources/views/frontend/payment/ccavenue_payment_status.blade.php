@extends('frontend.layouts.app')

@section('content')
<style>
    .table thead th {
    vertical-align: bottom;
    border-bottom: 0px solid #dee2e6;
}
</style>
<?php
if(isset($data)){
error_reporting(0);
$working_key = '842F72308DFE6FC100F92AE8AE75A455'; //Shared by CCAVENUES
$access_code = 'AVGJ10IF34BN83JGNB';

$merchant_json_data =
    array(
    'order_no' => $data,
	'reference_no' =>''
);

$merchant_data = json_encode($merchant_json_data);
$encrypted_data = encrypts($merchant_data, $working_key);
$final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderStatusTracker&request_type=JSON&response_type=JSON';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://apitest.ccavenue.com/apis/servlet/DoWebTrans");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER,'Content-Type: application/json') ;
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);
// Get server response ...
$result = curl_exec($ch);
curl_close($ch);
$status = '';
$information = explode('&', $result);

$dataSize = sizeof($information);
for ($i = 0; $i < $dataSize; $i++) {
    $info_value = explode('=', $information[$i]);
    if ($info_value[0] == 'enc_response') {
	$status = decrypts(trim($info_value[1]), $working_key);
	
    }
}


 $bank_response = json_decode($status);
 
}
?>

<?php
//ADD NEW ENCRYPT Function


error_reporting(0);

	function encrypts($plainText,$key)
	{
		$key = hextobins(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
		$encryptedText = bin2hex($openMode);
		return $encryptedText;
	}

	function decrypts($encryptedText,$key)
	{
		$key = hextobins(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$encryptedText = hextobins($encryptedText);
		$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
		return $decryptedText;
	}
	//*********** Padding Function *********************

	 function pkcs5_pads ($plainText, $blockSize)
	{
	    $pad = $blockSize - (strlen($plainText) % $blockSize);
	    return $plainText . str_repeat(chr($pad), $pad);
	}

	//********** Hexadecimal to Binary function for php 4.0 version ********

	function hextobins($hexString) 
   	 { 
        	$length = strlen($hexString); 
        	$binString="";   
        	$count=0; 
        	while($count<$length) 
        	{       
        	    $subString =substr($hexString,$count,2);           
        	    $packedString = pack("H*",$subString); 
        	    if ($count==0)
		    {
				$binString=$packedString;
		    } 
        	    
		    else 
		    {
				$binString.=$packedString;
		    } 
        	    
		    $count+=2; 
        	} 
  	        return $binString; 
    	  } error_reporting(0);


?>

<section class="tract-order">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 text-lg-left">
                <h1 class="fw-600 h4">{{ translate('Payment Status') }}</h1>
            </div>
            <div class="col-lg-6">
                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset" href="{{ route('home') }}">{{ translate('Home') }}</a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                       <a class="text-reset" href="{{ route('ccavenue.payment_status') }}">"{{ translate('Payment Status') }}"</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="mb-5">
    <div class="container text-left">
        <div class="row">
            <div class="col-xxl-5 col-xl-6 mx-auto">
                <form class="" action="{{ route('ccavenue.payment_status') }}" method="GET" enctype="multipart/form-data">
                    <div class="bg-white">
                        <div class="form-box-content p-3">
                            <div class="form-group">
                                <input type="text" class="form-control mb-3" placeholder="{{ translate('Order Code')}}" name="order_code" value="@if(isset($data)){{$data}}@endif" required>
                            </div>
                            
                            <div class="text-center">
                                
                                 <button type="submit" class="cell btn btn-primary">{{ translate('Track Payment Status')}}</button>
                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div><br/>

        @isset($bank_response)
         @if($bank_response->Order_Status_Result->status==0)
          @php flash(translate('Payment Details Get Successfully!'))->success(); @endphp
         
           <div class="col-xxl-5 col-xl-7 col-lg-8 mx-auto">
                    <div class="bg-white rounded shadow-sm">
                        <div class="fs-15 fw-600 p-3 border-bottom text-center">
                          Payment Status
                        </div>
                       <div class="card-body">
                            <table class="table mb-0 footable">
                                <thead>
                                  <tr>
                                  <th class="footable-first-visible">Order Id</th>
                                  <td>{{$bank_response->Order_Status_Result->order_no}}</td>
                                  </tr>
                                  
                                   <tr>
                                  <th class="footable-first-visible">Billing Email</th>
                                  <td>{{$bank_response->Order_Status_Result->order_bill_email}}</td>
                                  </tr>
                                  
                                   <tr>
                                  <th class="footable-first-visible">Order Amt</th>
                                  <td>{{$bank_response->Order_Status_Result->order_capt_amt}}</td>
                                  </tr>
                                 
                                  
                                   <tr>
                                  <th class="footable-first-visible">Billing Country</th>
                                  <td>{{$bank_response->Order_Status_Result->order_bill_country}}</td>
                                  </tr>
                                   <tr>
                                  <th class="footable-first-visible">Card Name</th>
                                  <td>{{$bank_response->Order_Status_Result->order_card_name}}</td>
                                  </tr>
                                  
                                   <tr>
                                  <th class="footable-first-visible">Order Status</th>
                                  <td>{{$bank_response->Order_Status_Result->order_status}}</td>
                                  </tr>
                                  
                                   <tr>
                                  <th class="footable-first-visible">Billing State</th>
                                  <td>{{$bank_response->Order_Status_Result->order_bill_state}}</td>
                                  </tr>
                                  
                                   <tr>
                                  <th class="footable-first-visible">tax</th>
                                  <td>{{$bank_response->Order_Status_Result->order_tax}}</td>
                                  </tr>
                                        <tr>
                                  <th class="footable-first-visible">Billing City</th>
                                  <td>{{$bank_response->Order_Status_Result->order_bill_city}}</td>
                                  </tr>
                                  
                                  <tr>
                                  <th class="footable-first-visible">Order Date Time</th>
                                  <td>{{$bank_response->Order_Status_Result->order_date_time}}</td>
                                  </tr>
                                 
                                  <tr>
                                  <th class="footable-first-visible">Order Bill Address</th>
                                  <td>{{$bank_response->Order_Status_Result->order_bill_address}}</td>
                                  </tr>
                                  
                                  <tr>
                                  <th class="footable-first-visible">Order Option Type</th>
                                  <td>{{$bank_response->Order_Status_Result->order_option_type}}</td>
                                  </tr>
                                  
                                  <tr>
                                  <th class="footable-first-visible">Order Bank Ref No.</th>
                                  <td>{{$bank_response->Order_Status_Result->order_bank_ref_no}}</td>
                                  </tr>
                                  <tr>
                                  <th class="footable-first-visible">Order Currncy</th>
                                  <td>{{$bank_response->Order_Status_Result->order_currncy}}</td>
                                  </tr>
                                  
                                  <tr>
                                  <th class="footable-first-visible">Order Bill Contact</th>
                                  <td>{{$bank_response->Order_Status_Result->order_bill_tel}}</td>
                                  </tr>
                                  
                                   <tr>
                                  <th class="footable-first-visible">Device Type</th>
                                  <td>{{$bank_response->Order_Status_Result->order_device_type}}</td>
                                  </tr>
                                   <tr>
                                  <th class="footable-first-visible">Order Amt</th>
                                  <td>{{$bank_response->Order_Status_Result->order_amt}}</td>
                                  </tr>
                                   <tr>
                                  <th class="footable-first-visible">Order Bill Zip</th>
                                  <td>{{$bank_response->Order_Status_Result->order_bill_zip}}</td>
                                  </tr>
                                   <tr>
                                  <th class="footable-first-visible">Order Bill Name</th>
                                  <td>{{$bank_response->Order_Status_Result->order_bill_name}}</td>
                                  </tr> <tr>
                                  <th class="footable-first-visible">Order Bank Response</th>
                                  <td>{{$bank_response->Order_Status_Result->order_bank_response}}</td>
                                  </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
            </div>
         
        @endif
        
        @if($bank_response->Order_Status_Result->status==1)
          @php flash(translate('Sorry! '.$bank_response->Order_Status_Result->error_desc))->error(); @endphp
        @endif
        @endisset
    </div>
</section>

@endsection
