@extends('backend.layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type= "text/javascript" src = "{{asset('public/assets/js/countries.js')}}"></script>

 
@section('content')
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Create Lead')}}</h5>
            </div>

            <form class="form-horizontal" action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="card-body">
                    <h6 class="text-center">{{ translate('Contact Details')}}</h6>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Company Name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('company name')}}" id="company_name" name="company_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Contact Name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Contact Name')}}" id="contact_name" name="contact_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="email">{{translate('Email Address')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Email Address')}}" id="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="phone">{{translate('Phone')}}</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="{{translate('Phone')}}" id="phone" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="phone2">{{translate('Phone 2')}}</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="{{translate('Phone 2')}}" id="phone2" name="phone2" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="whatsapp_number">{{translate('Whatsapp Number')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Whatsapp Number')}}" id="whatsapp_number" name="whatsapp_number" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="country">{{translate('Country')}}</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="country" id="country"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="state">{{translate('State')}}</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="state" id="state"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="city">{{translate('City')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('City')}}" id="city" name="city" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="pincode">{{translate('Pincode / Zip Code')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Pincode / Zip Code')}}" id="pincode" name="pincode" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="address">{{translate('Address')}}</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="address"> </textarea>
                        </div>
                    </div>
                    <h6 class="text-center">{{ translate('Service Details')}}</h6>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="profession">{{translate('Profession')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Profession')}}" id="profession" name="profession" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="contact_position">{{translate('Contact Position')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Contact Position')}}" id="contact_position" name="contact_position" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="website">{{translate('Website')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Website')}}" id="website" name="website" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="other_important_link">{{translate('Other Important Link')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Other Important Link')}}" id="other_important_link" name="other_important_link" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="remark">{{translate('Remarks / Comments')}}</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="remark"> </textarea>
                        </div>
                    </div>
                    <h6 class="text-center">{{translate('Social Media Links')}}</h6>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="facebook_link">{{translate('Facebook Link')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Facebook')}}" id="facebook_link" name="facebook_link" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="instagram_link">{{translate('Instagram Link')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Instagram')}}" id="instagram_link" name="instagram_link" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="twitter_link">{{translate('Twitter Link')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Twitter')}}" id="twitter_link" name="twitter_link" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="youtube_link">{{translate('YouTube Link')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('YouTube Link')}}" id="youtube_link" name="youtube_link" class="form-control">
                        </div>
                    </div>
                    <h6 class="text-center">{{translate('Funnel')}}</h6>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label">{{translate('Date Of Last Contact')}}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="start" name="last_date" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label">{{translate('Date Of Next Contact')}}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="end" name="next_date" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="status_of_lead">{{translate('Status Of Lead')}}</label>
                        <div class="col-sm-9">
                            <select class="form-control aiz-selectpicker" name="status_of_lead">
                                <option selected disabled value="">-- Select --</option>
                                <option value="Attempted to contact" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Attempted to contact'){{ 'selected' }}@endif>Attempted to contact</option>
                                <option value="Contact in future" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Contact in future'){{ 'selected' }}@endif>Contact in future</option>
                                <option value="Contacted" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Contacted'){{ 'selected' }}@endif>Contacted</option>
                                <option value="Junk lead" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Junk lead'){{ 'selected' }}@endif>Junk lead</option>
                                <option value="Lost lead" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Lost lead'){{ 'selected' }}@endif>Lost lead</option>
                                <option value="Not contacted" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Not contacted'){{ 'selected' }}@endif>Not contacted</option>  
                                <option value="Pre-qualified" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Pre-qualified'){{ 'selected' }}@endif>Pre-qualified</option>
                                <option value="Not qualified" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Not qualified'){{ 'selected' }}@endif>Not qualified</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="source_of_lead">{{translate('Source Of Lead')}}</label>
                        <div class="col-sm-9">
                            <select class="form-control aiz-selectpicker" name="source_of_lead">
                                <option selected disabled value="">-- Select --</option>
                                <option value="Sales Team" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Sales Team'){{ 'selected' }}@endif>Sales Team</option>
                                <option value="Social Media" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Social Media'){{ 'selected' }}@endif>Social Media</option>
                                <option value="Telecalling" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Telecalling'){{ 'selected' }}@endif>Telecalling</option>
                                <option value="Whatsapp" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Whatsapp'){{ 'selected' }}@endif>Whatsapp</option>
                                <option value="Referral" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Referral'){{ 'selected' }}@endif>Referral</option>
                                <option value="Facebook Ads" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Facebook Ads'){{ 'selected' }}@endif>Facebook Ads</option>
                                <option value="Google Ads" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Google Ads'){{ 'selected' }}@endif>Google Ads</option>  
                                <option value="Website" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Website'){{ 'selected' }}@endif>Website</option>
                                <option value="App" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'App'){{ 'selected' }}@endif>App</option>
                                <option value="Self Visit" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Self Visit'){{ 'selected' }}@endif>Self Visit</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="next_action_to_take">{{translate('Next Action to Take')}}</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="next_action_to_take"> </textarea>
                        </div>
                    </div>
                    <h6 class="text-center">{{ translate('Payment')}}</h6>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="quote_amount">{{translate('Quote Amount')}}</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="{{translate('Quote Amount')}}" id="quote_amount" name="quote_amount" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="quote_amount">{{translate('Approved Payment Amount')}}</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="{{translate('Approved Payment Amount')}}" id="approved_payment_amount" name="approved_payment_amount" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="">{{translate('No. Of Installment')}}</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="number_of_installment" name="number_of_installment">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>  
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group field_wrapper">
                        <div class="input-group">
                          <div class="col-md-4">
                            <label for="" class="form-label">Installment Date</label>
                            <input type="date" class="form-control" name="installment_date[]"> 
                            
                          </div>
                          <div class="col-md-3">
                          <label for="" class="form-label">Amount Paid</label>
                            <input type="number" class="form-control amount_paid" name="amount_paid[]" id="amount_paid1" >
                          </div>
                          <div class="col-md-4">
                          <label for="" class="form-label">Payment Date</label>
                            <input type="date" class="form-control" name="payment_date[]">
                          </div>
                          <div class="col-md-1">
                              <label for="" class="form-label">&nbsp</label>
                              <br>
                              <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus-circle"></i></a>
                          </div>
                        </div>
                      </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" integrity="sha512-YdYyWQf8AS4WSB0WWdc3FbQ3Ypdm0QCWD2k4hgfqbQbRCJBEgX0iAegkl2S1Evma5ImaVXLBeUkIlP6hQ1eYKQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
<script type="text/javascript">
    $('#start').datepicker({
        onSelect: function(dateText, inst){
            $('#end').datepicker('option', 'minDate', new Date(dateText));
        },
    });

    $('#end').datepicker({
        onSelect: function(dateText, inst){
            $('#start').datepicker('option', 'maxDate', new Date(dateText));
        }
    });

</script>


<script type="text/javascript">
    $('.amount_paid').change(function(){
      
          var amount = parseFloat($('#approved_payment_amount').val()) || 0;
           var sum=0;
          var inputs = $(".amount_paid");
         for(var i = 0; i < inputs.length; i++){
              
              sum=sum+parseFloat($(inputs[i]).val());
            
         }
         
         if(sum>amount){
           alert('You have reached the maximum approved payment amount !!!');
         }

    });

    $(document).ready(function(){
     $('#number_of_installment').change(function() {
        $(".field_wrapper_copy").remove();
          var maxGroup = $(this).val();
      var y = 1;  
      //var dev_amount = $('#amount_paid1').val();  
      var maxField = maxGroup; //Input fields increment limitation
      var addButton = $('.add_button'); //Add button selector
      var wrapper = $('.field_wrapper'); //Input field wrapper
      //var fieldHTML = '<div class="field_wrapper_copy"><div class="input-group"><div class="col-md-3"><label class="form-label">Installment Date</label><input type="date" class="form-control" name="installment_date[]" value=""/></div><div class="col-md-3"><label class="form-label">Amount Paid</label><input type="text" class="form-control" id="amount_paid'+ ++y +'" name="amount_paid[]" value="'+dev_amount+'"/></div><div class="col-md-3"><label class="form-label">Payment Date</label><input type="date" class="form-control" name="payment_date[]" value=""/></div><label for="" class="form-label">&nbsp</label><br><a href="javascript:void(0);" class="remove_button"><i class="fa fa-times-circle"></i></div></div>'; //New input field html 
      var x = 1; //Initial field counter is 1
      //Once add button is clicked
      $(addButton).click(function(){
          //Check maximum number of input fields
          if(x < maxField){ 
              x++; //Increment field counter
              //$(wrapper).append(fieldHTML); //Add field html
              $(wrapper).append('<div class="field_wrapper_copy"><div class="input-group"><div class="col-md-4"><label class="form-label">Installment Date</label><input type="date" class="form-control" name="installment_date[]" value=""/></div><div class="col-md-3"><label class="form-label">Amount Paid</label><input type="number" class="form-control amount_paid" id="amount_paid'+ ++y +'" name="amount_paid[]"/></div><div class="col-md-4"><label class="form-label">Payment Date</label><input type="date" class="form-control" name="payment_date[]" value=""/></div><label for="" class="form-label">&nbsp</label><br><a href="javascript:void(0);" class="remove_button"><i class="fa fa-times-circle"></i></div></div>');
              
              // if((--y).val() - (y).val())
              //   if(ab>1)
          }
          $('.amount_paid').change(function(){
      
      var amount = parseFloat($('#approved_payment_amount').val()) || 0;
       var sum=0;
      var inputs = $(".amount_paid");
      for(var i = 0; i < inputs.length; i++){
            
            sum=sum+parseFloat($(inputs[i]).val());
          
      }
     
      if(sum>amount){
        alert('You have reached the maximum approved payment amount !!');
      }

      });

      });
      //Once remove button is clicked
      $(wrapper).on('click', '.remove_button', function(e){
          e.preventDefault();
          $(this).parent('div').remove(); //Remove field html
          x--; //Decrement field counter
      });

    //   $('#number_of_installment').change(function() {
        
    //   $(".field_wrapper_copy").remove();
    //  

    //  });

     });
  });
  </script>

<script language="javascript">
    populateCountries("country", "state");
</script>


@endsection