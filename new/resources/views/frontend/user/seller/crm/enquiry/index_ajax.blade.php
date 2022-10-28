<div class="content">
    <!-- Start Content-->
     <div class="container-fluid">                    
                                        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Enquiry</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">MOB</a></li>
                            <li class="breadcrumb-item active">Leads</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row"> 
       
                          <div class="card-body">
                              <a href="{{route('crm.enquiry_form')}}" class="btn btn-primary btn-bordered rounded-pill waves-effect waves-light route_action" style="float: right;">+ Add</a>
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a href="#all_leads" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                                    <span class="d-inline-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                                    <span class="d-none d-sm-inline-block">All Lead's</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#today_follow" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                                    <span class="d-inline-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                                    <span class="d-none d-sm-inline-block">Lead's To Follow Today</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="all_leads">
                                                <form id="enquiry">
                                                    <input type="hidden" name="enquiry" value="yes">
                                                 <div class="row">
                                                   
                      <div class="col-md-3">
                        <label>Status of Lead</label>
                        <select class="form-control js-example-basic-single" onchange="filter()"  name="lead_status" id="lead_status" multiple>
                          <option value="">Status of Lead</option>
                         <option value="Attempted to contact" >Attempted to contact</option>
                       <option value="Contact in future">Contact in future</option>
                       <option value="Contacted" >Contacted</option>
                       <option value="Junk lead" >Junk lead</option>
                       <option value="Lost lead" >Lost lead</option>
                       <option value="Not contacted" >Not contacted</option>
                       <option value="Pre-qualified" >Pre-qualified</option>
                       <option value="Not qualified" >Not qualified</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label>Source of Lead</label>
                        <select class="form-control js-example-basic-single" onchange="filter()" name="lead_source" id="lead_source" multiple>
                          <option value="">Source of Lead</option>
                          <option value="Sales Team">Sales Team</option>
                          <option value="Social Media">Social Media</option>
                          <option value="Telecalling">Telecalling</option>
                          <option value="Whatsapp">Whatsapp</option>
                          <option value="Referral">Referral</option>
                          <option value="Facebook Ads">Facebook Ads</option>
                          <option value="Google Ads">Google Ads</option>
                          <option value="Website">Website</option>
                          <option value="App">App</option>
                          <option value="Self Visit">Self Visit</option>
                        </select>
                      </div>
                      <!--<div class="col-md-2">-->
                      <!--  <label>Last Date Contact</label>-->
                      <!--  <div class="input-group input-group-sm">-->
                      <!--   <input class="form-control input-daterange-datepicker" type="text" name="daterange" value="01/01/2020 - 01/31/2020"/>-->
                      <!--  </div>-->
                      <!--</div>-->
                      <!--<div class="col-md-2">-->
                      <!--  <label>Next Date Contact</label>-->
                      <!--  <div class="input-group input-group-sm">-->
                      <!--    <input type="date" class="form-control reportdatetime" onchange="filter()" name="next_date_of_contact" id="reportdatetime1" placeholder="Next Date Contact"  style="width:100%">-->
                      <!--  </div>-->
                      <!--</div>-->
                      <div class="col-md-2">
                        <label>Serach</label>
                        <div class="input-group input-group-sm">
                          <input type="text" class="form-control filter" onchange="filter()" id="search_index" name="search" placeholder="{{ translate('Type & Enter') }}" style="width:100%">
                        </div>
                      </div>
                     
                                                  </div>
                                                   </form>
                                                       <br>
                                                <div id="index_all_leads">
                                                 @include('frontend.user.seller.crm.enquiry.table')
                                                 </div>
                                            </div>
                                            <div class="tab-pane show" id="today_follow">
                                                @include('frontend.user.seller.crm.enquiry.table_today')
                                            </div>
                                        </div>
                                       
                                    </div>
            
        </div>
        <!-- end row -->
   
    </div>
    <!-- container -->
</div>
 <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog"  data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Followup Status Business</h4>
                                                    </div>
                                                    <form  id="followup_form" class="needs-validation" novalidate>
                                                        @csrf
                                                    <div class="modal-body p-4">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="field-1" class="form-label">Last Date Contact</label>
                                                                    <input type="text" class="form-control" id="last_date_of_contact" name="last_date_of_contact" value='<?php echo date('m/d/Y');?>' required readonly >
                                                                     <div class="valid-feedback">
                                                                      Looks good!
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                         Please choose a date.
                                                                        </div>
                                                                    <input type="hidden" name="contact_enquiry_id" id="contact_enquiry_id" value="" >
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
                                                        <button class="btn btn-primary"  type="submit">Submit form</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>   
<script src="{{asset('public/crm/libs/select2/js/select2.min.js')}}"></script>
  <script src="{{asset('public/crm/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
   <script src="{{asset('public/crm/libs/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
 <script>
     $(document).ready(function(){
         $('.js-example-basic-single').select2();
     });
     </script>
    
<script>


 $(document).on('click', '.enquiry_index a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });

  function fetch_data(page) {
        $.ajax({
            beforeSend: function() {
                $('#preloader').css("display", "block");
            },
            url:"{{route('crm.enquiry')}}?&page=" + page,
            data:$('#enquiry').serialize(),
            success: function(data) {
                $('#index_all_leads').html(data);    
            },
            complete: function() {
               $('#preloader').css("display", "none");
            }
        });
    }

  function filter(){
      var page=$('#current_page_number').val();
       fetch_data(page);
   }
</script>
<script>
    $(document).on('click', '.call_action', function(event) {
        event.preventDefault();
        var page_url = $(this).attr('href');
        var id =  $(this).attr('id');
        fetch_page_action_call(page_url,id);
     });

  function fetch_page_action_call(page_url,id) {
      
        $.ajax({
            beforeSend: function() {
                $('#preloader').css("display", "block");
            },
            url: page_url,
            success: function(data) {
                $('#contact_enquiry_id').val(id);
                $('#con-close-modal').modal('show');
            },
            complete: function() {
                $('#preloader').css("display", "none");
            }
        });
    }
         </script>                               
    <script src="{{asset('public/crm/libs/parsleyjs/parsley.min.js')}}"></script>
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
                 $('#con-close-modal').modal('hide');
                 $('#followup_form')[0].reset();
            },
            complete: function() {
               $('#preloader').css("display", "none");
            }
        });
            }
            
        });
  </script> 
