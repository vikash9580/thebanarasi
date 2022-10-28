<div class="content">
    <!-- Start Content-->
     <div class="container-fluid">                    
                                        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Quotation</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">MOB</a></li>
                            <li class="breadcrumb-item active">Quotation</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row"> 
       
                          <div class="card-body">
                              <a href="{{route('crm_quotation')}}?type=quotation" class="btn btn-primary btn-bordered rounded-pill waves-effect waves-light route_action" style="float: right;">+ Add</a>
                                       
                                        
                                            <div>
                                                <form id="quotation">
                                                    <input type="hidden" name="quotation" value="yes">
                                                 <div class="row">
                                                   
                   
                     
                      <!--<div class="col-md-2">-->
                      <!--  <label>Serach</label>-->
                      <!--  <div class="input-group input-group-sm">-->
                      <!--    <input type="text" class="form-control filter" onchange="filter()" id="search_index" name="search" placeholder="{{ translate('Type & Enter') }}" style="width:100%">-->
                      <!--  </div>-->
                      <!--</div>-->
                     
                                                  </div>
                                                   </form>
                                                       <br>
                                                <div id="index_all_leads">
                                                 @include('frontend.user.seller.crm.quotation.table')
                                                 </div>
                                            </div>
                                            
                                        
                                    </div>
            
        </div>
        <!-- end row -->
   
    </div>
    <!-- container -->
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


 $(document).on('click', '.quotation_index a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });

  function fetch_data(page) {
        $.ajax({
            beforeSend: function() {
                $('#preloader').css("display", "block");
            },
            url:"{{route('crm_seller.quotation')}}?&page=" + page,
            data:$('#quotation').serialize(),
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
                            
    <script src="{{asset('public/crm/libs/parsleyjs/parsley.min.js')}}"></script>
    <script>
  
  $(document).ready(function() {
    $('.parsley-examples').parsley();
  });
  
      
  </script> 
