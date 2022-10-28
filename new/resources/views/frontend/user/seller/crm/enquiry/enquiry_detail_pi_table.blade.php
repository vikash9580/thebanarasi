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
                                </thead>
                                <tbody>
                                    
                                    @foreach($pis as $key=>$item) 
                             <tr>
                               <td>{{ ($key+1) + ($pis->currentPage() - 1)*$pis->perPage() }}</td>
                               <td>{{$item->pi_number}}</td>
                               <td>{{$item->quotation_name}}</td>
                               <td>{{$item->other_name}}</td>
                               <td>{{$item->other_phone}}</td>
                               <td>{{$item->date}}</td>
                               <td>{{$item->total}}</td>
                             </tr>
                                  @endforeach
                                </tbody>
                            </table>
                           
                        </div>                           
                                         
                        