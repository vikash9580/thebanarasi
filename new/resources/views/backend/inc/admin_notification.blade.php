@php
                $orders = DB::table('orders')
                            ->orderBy('code', 'desc')
                            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                            ->where('order_details.seller_id', \App\User::where('user_type', 'admin')->first()->id)
                            ->where('orders.viewed', 0)
                            ->select('orders.id')
                            ->distinct()
                            ->count();
                $sellers = \App\Seller::where('verification_status', 0)->where('verification_info', '!=', null)->count();
                $followup=\App\Followup::where('viewed', 1)->get();
                
                $notification_sound=\App\NotificationSound::where('id','>',0)->first();
                if($notification_sound['play']==1){
                $file_name = "https://thebanarasisaree.com/notification_sound.mp3";
            echo '<audio autoplay="true" style="display:none;">
            <source src="'.$file_name.'">
            </audio>';
            $notification_sound->play=0;
            $notification_sound->save();
            }
            
            @endphp
                
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon p-1">
                            <span class="position-relative d-inline-block text-white">
                                <i class="las la-bell la-2x"></i>
                                @if($orders > 0 || $sellers > 0 || $followup->count() > 0)
                                    <span class="badge badge-dot badge-circle badge-primary position-absolute absolute-top-right"></span>
                                @endif
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg py-0">
                        <div class="p-3 bg-light border-bottom">
                            <h6 class="mb-0">{{ translate('Notifications') }}</h6>
                        </div>
                        <ul class="list-group c-scrollbar-light overflow-auto" style="max-height:300px;">

                            @if($orders > 0)
                            <li class="list-group-item">
                                <a href="{{ route('inhouse_orders.index') }}" class="text-reset">
                                    <span class="ml-2">{{ $orders }} {{translate('new orders')}}</span>
                                </a>
                            </li>
                            @endif
                            @if($sellers > 0)
                            <li class="list-group-item">
                                <a href="{{ route('sellers.index') }}" class="text-reset">
                                    <span class="ml-2">{{translate('New verification request(s)')}}</span>
                                </a>
                            </li>
                            @endif
                            @if($followup->count() > 0)
                            @foreach($followup as $follow)
                            <li class="list-group-item">
                                <a href="{{ route('contact.index') }}" class="text-reset">
                                    @php  $user_data = \App\User::where('id', $follow->reseller_id)->first();  @endphp
                                    @if($user_data)
                                    <span class="ml-2">Followup-{{ $user_data->name }} ({{$follow->next_date}}:{{$follow->next_time}})</span>
                                    @endif
                                </a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>