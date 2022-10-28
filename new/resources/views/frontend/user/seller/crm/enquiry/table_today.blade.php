  <div class="table-responsive">
                            <table class="table table-dark text-white mb-0">
                                <thead>
                                     <th>#</th>
                                     <th>Details</th>
                                     <th>Contact Detail</th>
                                     <th>Date </th>
                                     <th>Action</th>
                                </thead>
                                <tbody>
                                    
                                    @foreach($data2 as $key=>$item) 
                <tr>
                    <td>{{ ($key+1) + ($data->currentPage() - 1)*$data->perPage() }}</td>
                    <td>{{$item->contact_form->company_name}}
                      <br>
                      {{$item->contact_form->contact_name}}
                      <br>
                    </td>
                    <td>{{$item->contact_form->email}}
                      <br>
                      {{$item->contact_form->phone}}
                    </td>
                    <td>{{$item->last_date_of_contact}}
                      <br>
                      {{$item->next_date_of_contact}}
                    </td>
                    <td>
                      <a href="{{route('contact_form.edit',$item->contact_enquiry_id)}}" class="btn btn-soft-info btn-icon btn-circle btn-sm route_action">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                      </a>
                        <a href="{{route('contact_followup.detail',$item->contact_enquiry_id)}}" class="btn btn-soft-info btn-icon btn-circle btn-sm route_action">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                      </a>
                       <a href="{{route('message_template_index','id='.json_encode([$item->contact_form->id]))}}" class="btn btn-soft-info btn-icon btn-circle btn-sm route_action">
                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                      </a>
                      <form action="#" method="POST"> &nbsp; @csrf @method('DELETE') </br>
                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete">
                          <i class="fa fa-trash"></i>
                        </a>
                      </form>
                    </td>
                  </tr> 
                  @endforeach 
                                </tbody>
                            </table>
                        </div> 