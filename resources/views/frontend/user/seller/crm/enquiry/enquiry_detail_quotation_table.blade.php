  <div class="table">
                            <table class="table table-dark text-white mb-0">
                                <thead>
                                     <th>#</th>
                                     <th>QUOTAION NUMBER</th>
                                     <th>QUOTATION TITLE</th>
                                     <th>RESELLER </th>
                                     <th>RESELLER PHONE</th>
                                     <th>QUOTATION DATE</th>
                                     <th>TOTAL AMOUNT</th>
                                </thead>
                                <tbody>
                                    
                                    @foreach($quotations as $key=>$item) 
                             <tr>
                               <td>{{ ($key+1) + ($quotations->currentPage() - 1)*$quotations->perPage() }}</td>
                               <td>{{$item->quotation_number}}</td>
                               <td>{{$item->quotation_name}}</td>
                               <td>{{$item->other_name}}</td>
                               <td>{{$item->other_phone}}</td>
                               <td>{{$item->date}}</td>
                             </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>                           
                                         
                        