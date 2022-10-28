@extends('backend.layouts.app')

@section('content')

    <div class="card">
      <div class="card-header">
        <h1 class="h2">{{ translate('Follow-up Details') }}</h1>
      </div>
        <div class="card-header row gutters-6">
			<div class="col text-center text-md-left">
              <address>
                  <strong class="text-main">Candidate Name:{{$followup->reseller->name}} </strong><br>
                   Candidate Email:{{$followup->reseller->email}} <br>
                   Candidate Phone Number:{{$followup->reseller->phone}} <br>
                   Enquiry Date:{{$followup->created_at}} <br>
                </address>
                
			</div>
			<div class="col-md-6" style="text-align: right;">
    			<label class="aiz-switch aiz-switch-success mb-0">
                              <input onchange="update_follow_complete(this)" id="follow_up_close" value="{{ $followup->id }}" type="checkbox" <?php if($followup->active == 0) echo "checked"; ?>  >
                              <span class="slider round"></span>
							</label>
    		</div>
		</div>

    	<div class="card-body">
    		
    		<hr class="new-section-sm bord-no">
    		<div class="row">
    		<div class="col-md-6">
        <h1 class="h6">{{ translate('Follow-Up Calls') }}</h6>
      </div>
     @if($followup->active != 0)
      <div class="col-md-6" style="text-align: right;">
    			<a class="btn btn-circle btn-info mybtn1" id="mybtn1">
    				<span>+</span>
    			</a>
    		</div>
    		@endif
    
    		</div>
    			 @php $followup_calls = \App\FollowupCall::where('followup_id',$followup->id)->orderBy('id','desc')->paginate(3); @endphp
    		<div class="row" id="followup_call_table_data">
    	          @include('backend.crm.contact_form.followup_calls.followup_call_table')
    		</div>
    	</div>
    	<div class="card-body">
    		
    		<hr class="new-section-sm bord-no">
    		<div class="row">
    		<div class="col-md-6">
        <h1 class="h6">{{ translate('Shortlistd Product') }}</h6>
      </div>
     @if($followup->active != 0)
      <div class="col-md-6" style="text-align: right;">
    			<a class="btn btn-circle btn-info mybtn2" id="mybtn2" href="{{route('contact.edit',$followup->id)}}" target="_blank">
    				<span>+</span>
    			</a>
    		</div>
    		@endif
    
    		</div>
    			 @php $shortlisted_product = \App\Quotation::where('quotation_number', $followup->quotation_number)->paginate(3); @endphp
    		<div class="row" id="followup_call_table_data">
    	          @include('backend.crm.contact_form.followup_calls.quotation_followup_table')
    		</div>
    	</div>
    </div>
<div id="myModal1" class="modal fade" role="dialog" style="z-index:99999999;">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
               <h5>Followup Status</h5>
               <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form id="followup_form" >
					@csrf
					<div class="row">
					    <div class="col-sm-2" style="display:none">
                            <div class="form-group">
                                <label for="" class="col-from-label">Last Date Contact</label>
                                <input type="hidden" class="form-control" id="last_date_of_contact" name="last_date_of_contact" value='<?php echo date('Y-m-d');?>' readonly>                                
                               
                                <input type="hidden" name="id" value="{{$followup->id}}" > 

                            </div>
                        </div>
			        	<div class="col-sm-2">
                            <div class="form-group">
                                <label for="" class="col-from-label">Next Date Contact </label>
                                <input type="date" placeholder="{{translate('Date')}}" name="next_date_of_contact" id="next_date_of_contact" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="" class="col-from-label">Next Time Contact</label>
                                <input type="time" placeholder="{{translate('Date')}}" name="next_time_of_contact" id="next_time_of_contact" class="form-control" value="{{ old('next_time_of_contact') }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="col-from-label" for="lead_status">{{translate('Status Of Lead')}}</label>
                                <select class="form-control aiz-selectpicker" name="lead_status" data-live-search="true">
                                    <!--<option selected disabled value="">-- Select --</option>-->
                                    <option value="Attempted to contact"  @if ('lead_status' == "Attempted to contact") {{ 'selected' }} @endif>Attempted to contact</option>
                                    <option value="Contact in future"  @if ('lead_status' == "Contact in future") {{ 'selected' }} @endif>Contact in future</option>
                                    <option value="Contacted"  @if ('lead_status' == "Contacted") {{ 'selected' }} @endif>Contacted</option>
                                    <option value="Junk lead"  @if ('lead_status' == "Junk lead") {{ 'selected' }} @endif>Junk lead</option>
                                    <option value="Lost lead"  @if ('lead_status' == "Lost lead") {{ 'selected' }} @endif>Lost lead</option>
                                    <option value="Not contacted"  @if ('lead_status' == "Not contacted") {{ 'selected' }} @endif>Not contacted</option>  
                                    <option value="Pre-qualified"  @if ('lead_status' == "Pre-qualified") {{ 'selected' }} @endif>Pre-qualified</option>
                                    <option value="Not qualified"  @if ('lead_status' == "Not qualified") {{ 'selected' }} @endif>Not qualified</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3" style="display:none;">
                            <div class="form-group">
                                <label class="col-from-label" for="lead_source">{{translate('Source Of Lead')}}</label>
                                <select class="form-control aiz-selectpicker" name="lead_source" data-live-search="true" >
                                    <option selected disabled value="">-- Select --</option>
                                    <option value="Sales Team" @if ($followup->source_of_lead == "Sales Team") {{ 'selected' }} @endif>Sales Team</option>
                                    <option value="Social Media" @if ($followup->source_of_lead == "Social Media") {{ 'selected' }} @endif>Social Media</option>
                                    <option value="Telecalling" @if ($followup->source_of_lead == "Telecalling") {{ 'selected' }} @endif>Telecalling</option>
                                    <option value="Whatsapp" @if ($followup->source_of_lead == "Whatsapp") {{ 'selected' }} @endif>Whatsapp</option>
                                    <option value="Referral" @if ($followup->source_of_lead == "Referral") {{ 'selected' }} @endif>Referral</option>
                                    <option value="Facebook Ads" @if ($followup->source_of_lead == "Facebook Ads") {{ 'selected' }} @endif>Facebook Ads</option>
                                    <option value="Google Ads" @if ($followup->source_of_lead == "Google Ads") {{ 'selected' }} @endif>Google Ads</option>  
                                    <option value="Website" @if ($followup->source_of_lead == "Website") {{ 'selected' }} @endif>Website</option>
                                    <option value="App" @if ($followup->source_of_lead == "App") {{ 'selected' }} @endif>App</option>
                                    <option value="Self Visit" @if ($followup->source_of_lead == "Self Visit") {{ 'selected' }} @endif>Self Visit</option>
                                    <option value="Indiamart" @if ($followup->source_of_lead == "App") {{ 'selected' }} @endif>Indiamart</option>
                                    <option value="Database" @if ($followup->source_of_lead == "Self Visit") {{ 'selected' }} @endif>Database</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-from-label" for="remark"> {{translate('Remark')}}</label>
                                <textarea class="form-control" name="remark" required> {{ old('remark') }} </textarea>
                            </div>
                        </div> 
                        </div>
					    <div class="form-group mb-3 text-right">
					         <button  id="followup_call_button" >{{translate('Save')}}</button>
						 
					   </div>
				</form>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>
<div id="myModal2" class="modal fade" role="dialog" style="z-index:999999;">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
               <h5>Visit Status</h5>
               <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form id="visit_form" >
					@csrf
					<div class="row">
					    
			        	<div class="col-sm-4">
                            <div class="form-group">
                                <label for="" class="col-from-label">Date </label>
                                <input type="date" placeholder="{{translate('Date')}}" name="visit_date" id="visit_date" class="form-control">
                            </div>
                        </div>
                         <input type="hidden"  name="shortlisted_id" id="shortlisted_id" value="">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="" class="col-from-label">Purpose </label>
                                <input type="text" placeholder="{{translate('purspose')}}" name="purpose" id="purpose" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-from-label" for="remark"> {{translate('Remark')}}</label>
                                <textarea class="form-control" name="remark" required> {{ old('remark') }} </textarea>
                            </div>
                        </div> 
                        </div>
					    <div class="form-group mb-3 text-right">
					         <button  id="visit_button" >{{translate('Save')}}</button>
						 
					   </div>
				</form>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- delete Modal -->
<div id="delete-modal" class="modal fade">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{translate('Followup Closed Confirmation')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1">{{translate('Are you sure to closed this followup?')}}</p>
               
                <button type="button" class="btn btn-link mt-2" data-dismiss="modal">{{translate('No')}}</button>
                <a href="" id="delete-link" class="btn btn-primary mt-2">{{translate('Yes')}}</a>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

   

@endsection
@section('script')
<script>
    $(document).ready(function(){
    $(".mybtn1").click(function(){
        $("#myModal1").modal('show');
    });
    
});
</script>

<script>
    $("#followup_call_button").click(function(){
     event.preventDefault(); 
        $.ajax({
                   type:"POST",
                   url: '{{ route('followup_call.save') }}',
                   data: $('#followup_form').serializeArray(),
                   success: function(data){
                          if(data==1){
                               $("#myModal1").modal('hide');
                               var page=1;
                               fetch_data_followup_call(page);
                                $('#followup_form')[0].reset();
                          }
                   }
               });
 
 });
 
 $("#delete-link").click(function(){
     event.preventDefault(); 
     var id=$('#follow_up_close').val();
       $.post('{{ route('followup.complete') }}', {_token:'{{ csrf_token() }}', id:id, status:'0'}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Followup Closed') }}');
                    $('#delete-modal').modal('hide');
                    $('#mybtn1').hide();
                    $('#mybtn2').hide();
                    
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
 
 });
  
  
 $(document).on('click', '.followup_call a', function(event){
  event.preventDefault(); 
  var page = $(this).attr('href').split('page=')[1];
  fetch_data_followup_call(page);
 
 });

 function fetch_data_followup_call(page)
 {
     var enquiry_id="{{$followup->id}}";
  $.ajax({
   url:"/admin/followup_call_ajax_pagination?id="+enquiry_id+"&page="+page,
   success:function(data)
   {
    $('#followup_call_table_data').html(data);

   }
  });
 }
  function update_follow_complete(el){
            if(el.checked){
                var status = 0;
                $('#delete-modal').modal('show');
            }
            else{
                var status = 1;
            }
            
            
            
        }
</script>


@endsection