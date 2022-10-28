
 <div class="content">
    <!-- Start Content-->
     <div class="container-fluid">
    
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Enquiry Detail</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">MOB</a></li>
                            <li class="breadcrumb-item active">Enquiry Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="card-body">
 

<div class="card ribbon-box">
    <div class="card-body">
         @if($list[0]->contact_form->status != 'closed')
       <div class="ribbon ribbon-success float-end ribbon-shape">{{$list[0]->contact_form->status}}</div>
       @else
         <div class="ribbon ribbon-danger float-end ribbon-shape">{{$list[0]->contact_form->status}}</div>
       @endif
                                        <div class="d-flex align-items-start">
                                            <div class="avatar-md me-3">
                                                <div class="avatar-title bg-light rounded-circle">
                                                    <img src="{{asset('public/crm/images/companies/airbnb.png')}}" alt="logo" class="avatar-sm rounded-circle">
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="my-1"><a href="javascript:void(0);" class="text-dark">{{$list[0]->contact_form->contact_name}}</a></h4>
                                                <p class="text-muted text-truncate mb-0">
                                                    <i class="ri-map-pin-line align-bottom me-1"></i> {{$list[0]->contact_form->address}}
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="text-muted">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div>
                                                        <p class="text-truncate mb-0">Phone</p>
                                                        <h5 class="mb-sm-0">{{$list[0]->contact_form->phone}}</h5>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div>
                                                        <p class="text-truncate mb-0">Email</p>
                                                        <h5 class="mb-sm-0">{{$list[0]->contact_form->email}}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
</div>

<div class="card">
        <div class="card-body">
           <div class="row">
               <div class="col-md-6">
            <h4 class="my-1"><a href="javascript:void(0);" class="text-dark">Follow Up</a></h4>
            </div>
             <div class="col-md-6">
            @if($list[0]->contact_form->status != 'closed')
             <div class="float-sm-end">
               <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#con-close-modal">+</button>
             </div>
            @endif
            </div>
            </div>
            <br>
            <div class="col-md-12">
                <div id="followup_business_table">
                   @include('frontend.user.seller.crm.enquiry.enquiry_detail_table')
                </div>
            </div>
        </div>
    </div>


<div class="card">
        <div class="card-body">
           <div class="row">
               <div class="col-md-6">
            <h4 class="my-1"><a href="javascript:void(0);" class="text-dark">Quotation</a></h4>
            </div>
             <div class="col-md-6">
            
            </div>
            </div>
            <br>
            <div class="col-md-12">
                <div id="followup_business_order_table">
                   @include('frontend.user.seller.crm.enquiry.enquiry_detail_quotation_table')
                </div>
            </div>
        </div>
    </div>
    
<div class="card">
        <div class="card-body">
           <div class="row">
               <div class="col-md-6">
            <h4 class="my-1"><a href="javascript:void(0);" class="text-dark">PI</a></h4>
            </div>
             <div class="col-md-6">
            
            </div>
            </div>
            <br>
            <div class="col-md-12">
                <div id="followup_business_pi_table">
                   @include('frontend.user.seller.crm.enquiry.enquiry_detail_pi_table')
                </div>
            </div>
        </div>
    </div>   
    
<div class="card">
        <div class="card-body">
           <div class="row">
               <div class="col-md-6">
            <h4 class="my-1"><a href="javascript:void(0);" class="text-dark">Orders</a></h4>
            </div>
             <div class="col-md-6">
            
            </div>
            </div>
            <br>
            <div class="col-md-12">
                <div id="followup_business_order_table">
                   @include('frontend.user.seller.crm.enquiry.enquiry_detail_order_table')
                </div>
            </div>
        </div>
    </div> 

 <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Followup Status Business</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form  id="followup_form" class="needs-validation" novalidate>
                                                        @csrf
                                                    <div class="modal-body p-4">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="field-1" class="form-label">Last Date Contact</label>
                                                                    <input type="text" class="form-control" id="last_date_of_contact" name="last_date_of_contact" value='<?php echo date('Y-m-d');?>' required readonly >
                                                                     <div class="valid-feedback">
                                                                      Looks good!
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                         Please choose a date.
                                                                        </div>
                                                                    <input type="hidden" name="contact_enquiry_id" value="{{$list[0]->contact_enquiry_id}}" readonly>
                                                                    <input type="hidden" name="added_by" id="added_by" value="{{ Auth::user()->id }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="field-2" class="form-label">Next Date Contact</label>
                                                                  <input type="date" placeholder="{{translate('Date')}}" name="next_date_of_contact" min="{{date('Y-m-d')}}" id="next_date_of_contact" class="form-control" required>
                                                                  <div class="valid-feedback">
                                                                      Looks good!
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                         Please choose a date.
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="field-3" class="form-label">Status Of Lead</label>
                                                                    <select class="form-control" name="lead_status" required>
                                                                        <option value="">Select</option>
                                    <option value="Call not picked">Call not picked</option>
                                    <option value="not interested">not interested</option>
                                    <option value="Not Required Now, Call Later">Not Required Now, Call Later</option>
                                    <option value="Already Working Somewhere">Already Working Somewhere</option>
                                    <option value="Resume Received">Resume Received</option>
                                    <option value="Sortlisted">Sortlisted</option>  
                                    <option value="Hired">Hired</option>
                                </select>
                                <div class="valid-feedback">
                                                                      Looks good!
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                         Please Select Status Of Lead.
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="field-4" class="form-label">Followup Status</label>
                                                                    <select class="form-control" name="status" required >
                                                                        <option value=""  >Select</option>
                                    <option value="open"  >Open</option>
                                    <option value="closed" >Closed</option>
                                </select>
                                <div class="valid-feedback">
                                                                      Looks good!
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                         Please Select Status.
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                      
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3 no-margin">
                                                                    <label for="field-7" class="form-label">Remark</label>
                                                                    <textarea class="form-control"  name="remark"  placeholder="Remark"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary waves-effect close" data-bs-dismiss="modal">Close</button>
                                                        <button class="btn btn-primary"  type="submit">Submit form</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
 </div>
        </div>
        
        </div>
 </div>
         <script src="{{asset('public/crm/libs/parsleyjs/parsley.min.js')}}"></script>

       
      
    
    <!-- App js -->
  <script>
  
  $(document).ready(function() {
    $('.parsley-examples').parsley();
  });
  
       $(".needs-validation").on('submit', function (event) {
            $(this).addClass('was-validated');
            if ($(this)[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                return false;
            }else{
                
                event.preventDefault(); 
         $.ajax({
            beforeSend: function() {
                $('#preloader').css("display", "block");
            },
            type: "POST",
            url: "{{ route('saveFollowupData.save') }}",
            data:$('#followup_form').serialize(),
            success: function(data) {
                $('#followup_business_table').html(data);
                $("#con-close-modal .close").click();
                 $('#followup_form')[0].reset();
            },
            complete: function() {
               $('#preloader').css("display", "none");
            }
        });
            }
            
        });
  </script>

