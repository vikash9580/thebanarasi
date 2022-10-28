@extends('frontend.layouts.app')

@section('content')
<div id="order_confirmed">

</div>
<div id="re_payment" style="display:none;">
    
<div class="text-center">
    <br>
    <br>
    <br>
    <button class="btn btn-outline-primary mb-3 mb-sm-0" id="re_payment_button">Re Payment</button>

     <section class="py-4">
        <div class="container text-left">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="card shadow-sm border-0 rounded">
                        <div class="card-body">
                            <div class="text-center py-4 mb-4">
                                <i class="la la-times-circle la-3x text-danger  mb-3"></i>
                                <h1 class="h3 mb-3 fw-600">{{ translate('You Cancel the payment!')}}</h1>
                                <h2 class="h5">{{ translate('Order Code:')}} <span class="fw-700 text-primary">{{ $order_id }}</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
</div>
@endsection
@section('script')
 <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
   <script>

       $(document).ready(function(){

            var options = {
                "key": "{{ env('RAZOR_KEY') }}", // Enter the Key ID generated from the Dashboard
                "amount": "{{round($grand_total) * 100}}", // Amount is in currency subunits. Default currency is INR. Hence, 10 refers to 1000 paise
                "currency": "INR",
                "name": "{{ env('APP_NAME') }}",
                "description": "Cart Payment",
                "image": "{{ uploaded_asset(get_setting('header_logo')) }}",
                "order_id": "", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                "handler": function (response){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type:'POST',
                        url:"{{ route('payment.rozer') }}",
                        data:{razorpay_payment_id:response.razorpay_payment_id},
                        success:function(data){
                            $('#re_payment').hide();
                            $('#order_confirmed').html(data);
                        }
                    });
                },
                "modal": {
                        "ondismiss": function(){
                             $('#re_payment').show();
                        }
                   },
                "prefill": {
                    "name": "{{ Session::get('shipping_info')['name'] }}",
                    "email": "{{ Session::get('shipping_info')['email'] }}",
                    "contact": "{{ Session::get('shipping_info')['phone'] }}"
                },
                "theme": {
                    "color": "#ff7529"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        });

   
    $('body').on('click','#re_payment_button',function(e){
                $('#re_payment').hide();
            var options = {
                "key": "{{ env('RAZOR_KEY') }}", // Enter the Key ID generated from the Dashboard
                "amount": "{{round($grand_total) * 100}}", // Amount is in currency subunits. Default currency is INR. Hence, 10 refers to 1000 paise
                "currency": "INR",
                "name": "{{ env('APP_NAME') }}",
                "description": "Cart Payment",
                "image": "{{ uploaded_asset(get_setting('header_logo')) }}",
                "order_id": "", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                "handler": function (response){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type:'POST',
                        url:"{{ route('payment.rozer') }}",
                        data:{razorpay_payment_id:response.razorpay_payment_id},
                        success:function(data){
                            $('#re_payment').hide();
                            $('#order_confirmed').html(data);
                            AIZ.plugins.notify('success', 'Payment Completed');
                        }
                    });
                },
                "modal": {
                        "ondismiss": function(){
                             $('#re_payment').show();
                        }
                   },
                "prefill": {
                    "name": "{{ Session::get('shipping_info')['name'] }}",
                    "email": "{{ Session::get('shipping_info')['email'] }}",
                    "contact": "{{ Session::get('shipping_info')['phone'] }}"
                },
                "theme": {
                    "color": "#ff7529"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        });



    </script>
@endsection

