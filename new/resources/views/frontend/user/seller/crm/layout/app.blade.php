    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>CRM | The Banarasi Saree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('public/crm/images/favicon.png')}}">

    <!-- plugin css -->
    <link href="{{asset('public/crm/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}"
        rel="stylesheet" type="text/css" />
    <link href="{{asset('public/crm/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{asset('public/crm/css/default/bootstrap.min.css')}}" rel="stylesheet" type="text/css"
        id="bs-default-stylesheet" />
    <link href="{{asset('public/crm/css/default/app.min.css')}}" rel="stylesheet" type="text/css"
        id="app-default-stylesheet" />

    <link href="{{asset('public/crm/css/default/bootstrap-dark.min.css')}}" rel="stylesheet" type="text/css"
        id="bs-dark-stylesheet" />
    <link href="{{asset('public/crm/css/default/app-dark.min.css')}}" rel="stylesheet" type="text/css"
        id="app-dark-stylesheet" />
   <link href="{{asset('public/crm/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('public/crm/libs/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css">
    <!-- icons -->
    <link href="https://kit-pro.fontawesome.com/releases/v5.15.1/css/pro.min.css" rel="stylesheet">

</head>

<body class="loading" data-layout='{"mode": "dark", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "dark", "size": "default", "showuser": true}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
 <div id="preloader" style="display: none;opacity: 0.7;">
            <div  style="display: block;width: 40px; height: 40px;position: absolute;left: 50%;top: 50%;margin: -20px 0 0 -20px;">
                 <div class="spinner-grow text-success" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
            </div>
        </div>  
    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-end mb-0">
                    <li class="dropdown d-inline-block d-lg-none">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light"
                            data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                            aria-expanded="false">
                            <i class="fe-search noti-icon noti-icon"></i>
                        </a>
                        <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                            <form class="p-3">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Search">
                            </form>
                        </div>
                    </li>
                    <li class="dropdown d-none d-lg-inline-block">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen"
                            href="#">
                            <i class="fas fa-expand noti-icon"></i>
                        </a>
                    </li>
                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="fas fa-bell noti-icon"></i>
                            <span class="badge bg-danger rounded-circle noti-icon-badge">5</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-lg">
                            <div class="dropdown-item noti-title">
                                <h5 class="m-0">
                                    <span class="float-end">
                                        <a href="#" class="text-dark">
                                            <small>Clear All</small>
                                        </a>
                                    </span>Notification
                                </h5>
                            </div>
                            <div class="noti-scroll" data-simplebar>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                    <div class="notify-icon bg-soft-primary text-primary">
                                        <i class="mdi mdi-comment-account-outline"></i>
                                    </div>
                                    <p class="notify-details">Doug Dukes commented on Admin Dashboard
                                        <small class="text-muted">1 min ago</small>
                                    </p>
                                </a>
                            </div>

                            <!-- All-->
                            <a href="javascript:void(0);"
                                class="dropdown-item text-center text-primary notify-item notify-all">
                                View all
                                <i class="fas fa-arrow-right"></i>
                            </a>

                        </div>
                    </li>

                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light"
                            data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                            aria-expanded="false">
                            <img src="{{asset('public/crm/images/user.png')}}" class="rounded-circle">
                            <span class="pro-user-name ms-1">
                                USER <i class="far fa-chevron-down"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end profile-dropdown ">

                            <!-- item-->
                            <a href="#" class="dropdown-item notify-item">
                                <i class="far fa-sign-in-alt"></i>
                                <span>Logout</span>
                            </a>

                        </div>
                    </li>
                     <li class="dropdown notification-list">
                            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                                <i class="far fa-cog noti-icon"></i>
                            </a>
                    </li>
                </ul>
                <div class="logo-box">
                    <a href="#" class="logo logo-light text-center">
                        <span class="logo-sm">
                            <img src="{{asset('public/crm/images/logo.png')}}" alt="" height="20">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset('public/crm/images/logo.png')}}" alt="" height="50">
                        </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect waves-light">
                            <i class="fas fa-bars"></i>
                        </button>
                    </li>

                    <li>
                        <!-- Mobile menu toggle (Horizontal Layout)-->
                        <a class="navbar-toggle nav-link" data-bs-toggle="collapse"
                            data-bs-target="#topnav-menu-content">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- end Topbar -->
        @include('frontend.user.seller.crm.sidebar')
        
        <div class="content-page" id="page_content">
            @yield('content')
        </div>

    </div>
    
    @include('frontend.user.seller.crm.footer')
    
      <script src="{{asset('public/crm/js/vendor.min.js')}}"></script>

    <!-- KNOB JS -->
    <script src="{{asset('public/crm/libs/jquery-knob/jquery.knob.min.js')}}"></script>
    <!-- Apex js-->
  
    <script src="{{asset('public/crm/libs/apexcharts/apexcharts.min.js')}}"></script>
  
    <script src="{{asset('public/crm/js/pages/ohlc.js')}}"></script>
  
    <script src="{{asset('public/crm/js/pages/apexcharts.init.js')}}"></script>
  
  
    <!-- Plugins js-->
    <!--<script src="{{asset('public/crm/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>-->
    <!--<script src="{{asset('public/crm/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js')}}"></script>-->

    <!-- Dashboard init-->
    <!--<script src="{{asset('public/crm/js/pages/dashboard-sales.init.js')}}"></script>-->

    <!-- App js -->
    <script src="{{asset('public/crm/js/app.min.js')}}"></script>
    
   
    <script>


 $(document).on('click', '.route', function(event) {
        event.preventDefault();
        var page_url = $(this).attr('href');
        fetch_page(page_url);
    });

  function fetch_page(page_url) {
      
        $.ajax({
            beforeSend: function() {
                $('#preloader').css("display", "block");
            },
            url: page_url,
            success: function(data) {
                window.history.pushState("", "", page_url);
                $('#page_content').html(data);    
            },
            complete: function() {
                  $('#preloader').css("display", "none");
            }
        });
    }
    
 $(document).on('click', '.route_action', function(event) {
        event.preventDefault();
        var page_url = $(this).attr('href');
        fetch_page_action(page_url);
    });

  function fetch_page_action(page_url) {
      
        $.ajax({
            beforeSend: function() {
                $('#preloader').css("display", "block");
            },
            url: page_url,
            success: function(data) {
                $('#page_content').html(data);    
            },
            complete: function() {
                $('#preloader').css("display", "none");
            }
        });
    }   
    
   
$(document).ready(function(){
  $("#side-menu li").on('click', function(){
    $(this).siblings().removeClass('menuitem-active');
    $(this).addClass('menuitem-active')
  })
})

var colors = ['#3bafda'];
var dataColors = $("#apex-column-1").data('colors');
if (dataColors) {
    colors = dataColors.split(",");
}
var options = {
    chart: {
        height: 380,
        type: 'bar',
        toolbar: {
            show: false
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            endingShape: 'rounded',
            columnWidth: '55%',
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    colors: colors,
    series: [{
        name: 'Orders',
        data: [
             @foreach ($orders as $key=>$value)
                '{{ $value }}',
                @endforeach
            ]
    }],
    xaxis: {
        categories: [
            @foreach ($orders as $key=>$value)
                '{{ $key }}',
                @endforeach
            ],
    },
    legend: {
        offsetY: 5,
    },
    yaxis: {
        title: {
            text: 'No Of Orders'
        }
    },
    fill: {
        opacity: 1

    },
    grid: {
        row: {
            colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.2
        },
        borderColor: '#f1f3fa',
        padding: {
            bottom: 10
        }
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "" + val + ""
            }
        }
    }
}

var chart = new ApexCharts(
    document.querySelector("#apex-column-1"),
    options
);

chart.render();


var colors = ['#3bafda'];
var dataColors = $("#apex-column-11").data('colors');
if (dataColors) {
    colors = dataColors.split(",");
}
var options = {
    chart: {
        height: 380,
        type: 'bar',
        toolbar: {
            show: false
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            endingShape: 'rounded',
            columnWidth: '55%',
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    colors: colors,
    series: [{
        name: 'Quotations',
        data: [
             @foreach ($quotations as $key=>$value)
                '{{ $value }}',
                @endforeach
            ]
    }],
    xaxis: {
        categories: [
            @foreach ($quotations as $key=>$value)
                '{{ $key }}',
                @endforeach
            ],
    },
    legend: {
        offsetY: 5,
    },
    yaxis: {
        title: {
            text: 'No Of Quotations'
        }
    },
    fill: {
        opacity: 1

    },
    grid: {
        row: {
            colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.2
        },
        borderColor: '#f1f3fa',
        padding: {
            bottom: 10
        }
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "" + val + ""
            }
        }
    }
}

var chart = new ApexCharts(
    document.querySelector("#apex-column-11"),
    options
);

chart.render();


var colors = ['#3bafda'];
var dataColors = $("#apex-column-12").data('colors');
if (dataColors) {
    colors = dataColors.split(",");
}
var options = {
    chart: {
        height: 380,
        type: 'bar',
        toolbar: {
            show: false
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            endingShape: 'rounded',
            columnWidth: '55%',
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    colors: colors,
    series: [{
        name: 'Pi',
        data: [
             @foreach ($pis as $key=>$value)
                '{{ $value }}',
                @endforeach
            ]
    }],
    xaxis: {
        categories: [
            @foreach ($pis as $key=>$value)
                '{{ $key }}',
                @endforeach
            ],
    },
    legend: {
        offsetY: 5,
    },
    yaxis: {
        title: {
            text: 'No Of Pi'
        }
    },
    fill: {
        opacity: 1

    },
    grid: {
        row: {
            colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.2
        },
        borderColor: '#f1f3fa',
        padding: {
            bottom: 10
        }
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "" + val + ""
            }
        }
    }
}

var chart = new ApexCharts(
    document.querySelector("#apex-column-12"),
    options
);

chart.render();

var colors = ['#3bafda'];
var dataColors = $("#apex-column-13").data('colors');
if (dataColors) {
    colors = dataColors.split(",");
}
var options = {
    chart: {
        height: 380,
        type: 'bar',
        toolbar: {
            show: false
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            endingShape: 'rounded',
            columnWidth: '55%',
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    colors: colors,
    series: [{
        name: 'Enquiry',
        data: [
             @foreach ($enquries as $key=>$value)
                '{{ $value }}',
                @endforeach
            ]
    }],
    xaxis: {
        categories: [
            @foreach ($enquries as $key=>$value)
                '{{ $key }}',
                @endforeach
            ],
    },
    legend: {
        offsetY: 5,
    },
    yaxis: {
        title: {
            text: 'No Of Enquiry'
        }
    },
    fill: {
        opacity: 1

    },
    grid: {
        row: {
            colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.2
        },
        borderColor: '#f1f3fa',
        padding: {
            bottom: 10
        }
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "" + val + ""
            }
        }
    }
}

var chart = new ApexCharts(
    document.querySelector("#apex-column-13"),
    options
);

chart.render();

</script>
    
</body>
</html>