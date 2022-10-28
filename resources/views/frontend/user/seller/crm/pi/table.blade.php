  <div class="table">
                            <table class="table table-dark text-white mb-0">
                                <thead>
                                     <th>#</th>
                                     <th>PI NUMBER</th>
                                     <th>QUOTATION TITLE</th>
                                     <th>RESELLER </th>
                                     <th>RESELLER PHONE</th>
                                     <th>QUOTATION DATE</th>
                                     <th>TOTAL AMOUNT</th>
                                     <th>OPTIONS</th>
                                </thead>
                                <tbody>
                                    
                                    @foreach($data as $key=>$item) 
                             <tr>
                               <td>{{ ($key+1) + ($data->currentPage() - 1)*$data->perPage() }}</td>
                               <td>{{$item->pi_number}}</td>
                               <td>{{$item->quotation_name}}</td>
                               <td>{{$item->other_name}}</td>
                               <td>{{$item->other_phone}}</td>
                               <td>{{$item->date}}</td>
                               <td>{{$item->total}}</td>
                               <td>
                                   
                                   <a href="{{route('crm_seller.pi_edit',$item->pi_number)}}" class="btn btn-soft-info btn-icon btn-circle btn-sm route_action">
                                       <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                   
                               </td>
                             </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            @include('backend.pagination',['list' =>$data,'class'=>'pi_index'])
                        </div>                           
                                         
                        