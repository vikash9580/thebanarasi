  <div class="table">
                            <table class="table table-dark text-white mb-0">
                                <thead>
                                     <th>#</th>
                                     <th>ORDER CODE</th>
                                     <th>PI NUMBER</th>
                                     <th>NUMBER Of PRODUCTS</th>
                                     <th>AMOUNT</th>
                                     <th>OPTIONS</th>
                                </thead>
                                <tbody>
                                    
                                    @foreach($orders as $key=>$item) 
                             <tr>
                               <td>{{ ($key+1) + ($orders->currentPage() - 1)*$orders->perPage() }}</td>
                               <td>{{$item->code}}</td>
                               <td>{{$item->pi_number}}</td>
                               <td>{{$item->orderDetails()->count()}}</td>
                               <td>{{$item->grand_total}}</td>
                               <td>
                                   
                                   <a href="{{route('crm_seller.order_detail',$item->id)}}" class="btn btn-soft-info btn-icon btn-circle btn-sm route_action">
                                       <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                   
                               </td>
                             </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            
                        </div>                           
                                         
                        