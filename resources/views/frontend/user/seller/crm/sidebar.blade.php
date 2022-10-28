<div class="left-side-menu">

            <!-- LOGO -->

            <div class="h-100" data-simplebar>
                
                <div class="logo-box">
                    <a href="index.html" class="logo logo-dark text-center">
                        <span class="logo-sm">
                            <img src="{{asset('public/crm/images/logo.png')}}" alt="" height="24">
                            <!-- <span class="logo-lg-text-light">Minton</span> -->
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset('public/crm/images/logo.png')}}" alt="" height="50">
                            <!-- <span class="logo-lg-text-light">M</span> -->
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light text-center">
                        <span class="logo-sm">
                            <img src="{{asset('public/crm/images/logo.png')}}" alt="" height="24">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset('public/crm/images/logo.png')}}" alt="" height="50">
                        </span>
                    </a>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    <ul id="side-menu">

                        <li class="menu-title">Navigation</li>
                        <li>
                            <a href="{{route('crm.dashboard')}}" class="route">
                                <i class="fas fa-tachometer-slowest"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>

                        <li class="">
                            <a href="{{route('crm.enquiry')}}" class="route">
                                <i class="fas fa-table"></i>
                                <span> Enquiry </span>
                            </a>
                        </li>
                        
                        <li class="">
                            <a href="{{route('crm_seller.quotation')}}" class="route">
                                <i class="fas fa-table"></i>
                                <span> Quotation </span>
                            </a>
                        </li>
                        
                        <li class="">
                            <a href="{{route('crm_seller.pi')}}" class="route">
                                <i class="fas fa-table"></i>
                                <span> PI </span>
                            </a>
                        </li>
                        
                        <li class="">
                            <a href="{{route('crm_seller.orders')}}" class="route">
                                <i class="fas fa-table"></i>
                                <span> Order </span>
                            </a>
                        </li>
                        
                       <!--<li>-->
                       <!--     <a href="#sidebarEmail" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarEmail">-->
                       <!--         <i class="far fa-mail-bulk"></i>-->
                       <!--         <span> Email </span>-->
                       <!--         <span class="menu-arrow"></span>-->
                       <!--     </a>-->
                       <!--     <div class="collapse" id="sidebarEmail">-->
                       <!--         <ul class="nav-second-level">-->
                       <!--             <li>-->
                       <!--                 <a href="#">Inbox</a>-->
                       <!--             </li>-->
                       <!--         </ul>-->
                       <!--     </div>-->
                       <!-- </li>-->
                    </ul>

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>