
 @extends('frontend.user.seller.crm.layout.app')
 @section('content')

 <div class="content">
    <!-- Start Content-->
     <div class="container-fluid">
    
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Table</h4>
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
    
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" id="table">
                      @include('frontend.user.seller.crm.enquiry.table')
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    
    </div>
    <!-- container -->
</div>

 @endsection

@endif

