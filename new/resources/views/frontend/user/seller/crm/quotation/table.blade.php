  <div class="table">
                            <table class="table table-dark text-white mb-0">
                                <thead>
                                     <th>#</th>
                                     <th>QUOTAION NUMBER</th>
                                     <th>QUOTATION TITLE</th>
                                     <th>SELLER DETAILS </th>
                                     <th>QUOTATION DATE</th>
                                     <th>TOTAL AMOUNT</th>
                                     <th>OPTIONS</th>
                                </thead>
                                <tbody>
                                    
                                    @foreach($data as $key=>$item) 
                             <tr>
                               <td>{{ ($key+1) + ($data->currentPage() - 1)*$data->perPage() }}</td>
                               <td>{{$item->quotation_number}}</td>
                               <td>{{$item->quotation_name}}</td>
                               <td>
                                   <b> Business : </b>{{$item->business_name}} <br />
                                    <b> Owner : </b>{{$item->name}} <br />
                                    <b> Contact Person : </b>{{$item->other_name}} <br />
                                    <b> Business : </b>{{$item->other_name}} <br />
                               </td>
                               <td>{{$item->date}}</td>
                               <td>{{$item->total}}</td>
                               <td>
                                   
                                   <a href="{{route('crm_seller.quotation_edit',$item->quotation_number)}}" class="btn btn-soft-info btn-icon btn-circle btn-sm route_action">
                                       <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{route('crm_seller.generate_pi',$item->quotation_number)}}" class="btn btn-soft-info btn-icon btn-circle btn-sm route_action">
                                       + PI
                                    </a>
                                   
                               </td>
                             </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            @include('backend.pagination',['list' =>$data,'class'=>'quotation_index'])
                        </div>                           
                                         
                        