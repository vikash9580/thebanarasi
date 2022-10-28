@extends('backend.layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('content')
<div class="aiz-main-content">
   <div class="aiz-titlebar text-left mt-2 mb-3">
      <div class="row align-items-center">
         <div class="col-md-6">
            <h1 class="h3">Follow Up</h1>
         </div>
        
         <div class="col-md-6 text-md-right">
            <a href="{{ route('contact.create') }}" class="btn btn-circle btn-info" style="float:right"><i
               class="fa fa-plus" aria-hidden="true"></i> Add New </a>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <ul class="nav nav-tabs">
            <li><a data-toggle="tab" href="#home" class="active">All Lead's</a></li>
            <li><a data-toggle="tab" href="#menu1" id="today_click">Lead's To Follow Today</a></li>
            {{-- <a href="{{route('crm.import')}}" class="btn btn-warning"
               style="float:right; margin-right: 10px;"><i class="fa fa-upload" aria-hidden="true"></i> Upload
            Excel </a>
            <a href="{{route('crm.export')}}" class="btn btn-success" style="float:right; margin-right: 10px;"><i
               class="fa fa-download" aria-hidden="true"></i> Download Excel</a> --}}
         </ul>
      </div>
      
   </div>
</div>
<div class="aiz-main-content">
   <div class="card">
      <div class="card-body">
         <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
               <br />
               <div class="row">
                    <div class="col-md-4 input-daterange">
                     <label for="" class="form-label">Date Of Last Contact</label><br>
                     <div class="row">
                        <div class="col-md-6">
                           <input type="date" name="last_from_date" onchange="set_date_last()" id="last_from_date" 
                              class="form-control" placeholder="from" />
                        </div>
                        <div class="col-md-6">
                           <!--<div class="input-group-addon">to</div>-->
                           <input type="date" name="last_to_date" id="last_to_date" 
                              class="form-control fillter" placeholder="to" />
                        </div>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label class="form-label">Status Of Lead</label>
                        <select class="form-control aiz-selectpicker fillter" name="status_of_lead" id="status_of_lead" multiple>
                           <option value="Attempted to contact">Attempted to contact</option>
                           <option value="Contact in future">Contact in future</option>
                           <option value="Contacted">Contacted</option>
                           <option value="Junk lead">Junk lead</option>
                           <option value="Lost lead">Lost lead</option>
                           <option value="Not contacted">Not contacted</option>
                           <option value="Pre-qualified">Pre-qualified</option>
                           <option value="Not qualified">Not qualified</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label for="" class="form-label">Source Of Lead</label>
                        <select class="form-control aiz-selectpicker fillter" name="source_of_lead" id="source_of_lead" multiple>
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
                           <option value="Indiamart">Indiamart</option>
                           <option value="Database">Database</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4 input-daterange">
                     <label for="" class="form-label">Date Of Next Contact</label><br>
                     <div class="row">
                        <div class="col-md-6" style="padding: 0px 3px;">
                           <input type="date" name="next_from_date" onchange="set_date_next()"  id="next_from_date" 
                              class="form-control" placeholder="from" />
                        </div>
                        <div class="col-md-6" style="padding: 0px 3px;">
                           <!--<div class="input-group-addon">to</div>-->
                           <input type="date" name="next_to_date" id="next_to_date" 
                              class="form-control fillter" placeholder="to" />
                        </div>
                     </div>
                  </div>
                      <div class="col-md-6">
                          <div class="input-group input-group-sm">
                            <input type="text" class="form-control fillter" id="search" name="search" placeholder="{{ translate('Type & Enter') }}">
                         </div>
                   </div>
                    <div class="col-md-6">
                     <div class="form-group" style="float: right;">
                        <button type="button" class="btn btn-info"
                           id="reset">Reset</button>
                     </div>
                  </div>
               </div>
               <br />
               <div id="table_all_leads" class="table aiz-table mb-0 footable footable-1 breakpoint-lg">
                  @include('backend.crm.contact_form.table_all_leads')
               </div>
            </div>
            <div id="menu1" class="tab-pane fade">
               <br />
               
               <div class="row">
                     <div class="col-md-6">
                          <div class="input-group input-group-sm">
                            <input type="text" class="form-control fillter_today_leads" id="search_leads_today" name="search_leads_today" placeholder="{{ translate('Type & Enter') }}">
                         </div>
                   </div>
                    <div class="col-md-6">
                     <div class="form-group" style="float: right;">
                        <button type="button" class="btn btn-info"
                           id="reset">Reset</button>
                     </div>
                  </div>
                  </div>
               
               
               <div class="table aiz-table mb-0 footable footable-1 breakpoint-lg" id="table_today_leads">
                   
                  @include('backend.crm.contact_form.table_today_leads')
               </div>
            </div>
         </div>
      </div>
   </div>
    <div class="row">
            <div class="col-md-12 color">
                 <span style="background:#166b01">Color</span><label>Attempted to Contact</label>
                 <span style="background:#044b82">Color</span><label>Contact in Future</label>
                 <span style="background:#082900">Color</span><label>Contacted</label>
                 <span style="background:#ff0000">Color</span><label>Junk Lead </label>
                 <span style="background:#c45b0a">Color</span><label>Not Contacted</label>
            </div>
        </div>
</div>
@endsection
@section('script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
<script>
   $(document).ready(function() {
       
       
       
       
        $('.aiz-selectpicker').selectpicker();
       
       
         $(".fillter").change(function(){
            var status_of_lead = $('#status_of_lead').val();
            var source_of_lead = $('#source_of_lead').val();
            var last_from_date = $('#last_from_date').val();
            var last_to_date = $('#last_to_date').val();
            var next_from_date = $('#next_from_date').val();
            var next_to_date = $('#next_to_date').val();
            var search = $('#search').val();
            $.ajax({
      	   url:"contact?page_type=all_leads&status_of_lead="+status_of_lead+"&source_of_lead="+source_of_lead+"&last_from_date="+last_from_date+"&last_to_date="+last_to_date+"&next_from_date="+next_from_date+"&next_to_date="+next_to_date+"&search="+search,
              success:function(data) {
                      console.log(data);
                      $('#table_all_leads').html(data);
                  }
      });
         });
         
         
           $(".fillter_today_leads").change(function(){
          
            var search_leads_today = $('#search_leads_today').val();
            $.ajax({
      	   url:"contact?page_type=today_leads&search_leads_today="+search_leads_today,
              success:function(data) {
                      console.log(data);
                      $('#table_today_leads').html(data);
                  }
      });
         });
         
      });
      
      
      
   function set_date_last(){
      $('#last_to_date').val('');
            $('#last_to_date').attr('min' , $('#last_from_date').val());
       }
       
       function set_date_next(){
      $('#next_to_date').val('');
            $('#next_to_date').attr('min' , $('#next_from_date').val());
       }
   
   
   $(document).ready(function(){
    
   
   $(document).on('click', '.non-modal a', function(event){
    event.preventDefault(); 
    var page = $(this).attr('href').split('page=')[1];
    fetch_data(page);
   
   });
   
   function fetch_data(page)
   {
           var status_of_lead = $('#status_of_lead').val();
            var source_of_lead = $('#source_of_lead').val();
            var last_from_date = $('#last_from_date').val();
            var last_to_date = $('#last_to_date').val();
            var next_from_date = $('#next_from_date').val();
            var next_to_date = $('#next_to_date').val();
            var search = $('#search').val();
          
       
    $.ajax({
     url:"contact?page_type=all_leads&status_of_lead="+status_of_lead+"&source_of_lead="+source_of_lead+"&last_from_date="+last_from_date+"&last_to_date="+last_to_date+"&next_from_date="+next_from_date+"&next_to_date="+next_to_date+"&search="+search+"&page="+page,
     success:function(data)
     {
      $('#table_all_leads').html(data);
   
     }
    });
   }
    
   });
   
    $(document).ready(function(){
    
   
   $(document).on('click', '.non-modal2 a', function(event){
    event.preventDefault(); 
    var page = $(this).attr('href').split('page=')[1];
    fetch_data_leads(page);
   
   });
   
   function fetch_data_leads(page)
   {
           
            var search_leads_today = $('#search_leads_today').val();
          
       
    $.ajax({
     url:"contact?page_type=today_leads&page="+page+"&search_leads_today="+search_leads_today,
     success:function(data)
     {
         
         $("#today_click").trigger("click");
      $('#table_today_leads').html(data);
   
     }
    });
   }
    
   });
   
   
   $('#reset').click(function(){
           $('#last_from_date').val('');
           $('#last_to_date').val('');
           $('#next_from_date').val('');
           $('#next_to_date').val('');
        });
   
</script>
@endsection
@section('modal')
@include('modals.delete_modal')
@endsection