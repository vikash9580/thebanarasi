<style>
    .dropdown-menu {
    min-width: 7rem;
}
</style>
@php function color_tr($status){
      if($status=='Contacted'){
      echo '#082900';
      }
      if($status=='Attempted to contact'){
      echo '#166b01';
      }
      if($status=='Junk lead'){
      echo '#f02207';
      }
      if($status=='Lost lead'){
      echo '#821304';
      }
      if($status=='Contact in future'){
      echo '#044b82';
      }
      if($status=='Not contacted'){
      echo '#c45b0a';
      }
      if($status=='Pre-qualified'){
      echo '#001c4a';
      }
      if($status=='Not qualified'){
      echo '#e30219';
      }
      }
      @endphp
      
<table class="table " id="myTable1">
   <thead>
      <tr>
         <th>#</th>
         <!--<th>User Type</th>-->
         <th>Name</th>
          <th>Contact Details</th>
         <!--<th>Phone</th>-->
         <th>Date Of Last Contact</th>
         <th>Date Of Next Contact</th>
         <th>Action</th>
      </tr>
   </thead>
   <tbody>
      @foreach($data2 as $key => $leads)
      @php
      $SellerDetails = App\SellerDetails::where('user_id', $leads->reseller_id)->first();
      @endphp
      @if(!empty($leads->reseller))
      <tr>
         <td  style="background:<?php color_tr($leads->status_of_lead); ?>">{{ ($key+1) + ($data2->currentPage() - 1)*$data2->perPage() }}</td>
         <!--<td>{{$leads->reseller->user_type}}</td>-->
         <td>{{$leads->reseller->name}} <br> <smmall class="user_type">{{$leads->reseller->user_type}}</smmall></td>
         <td><i class="foll fa fa-envelope" aria-hidden="true"></i> {{$leads->reseller->email}} <br><i class="foll fa fa-phone" aria-hidden="true"></i> {{$leads->reseller->phone}}</td>
         <!--<td>{{$leads->reseller->phone}}</td>-->
         <td>{{$leads->last_date}}</td>
         <td>{{$leads->next_date}} {{$leads->next_time}}</td>
         <!--<td>-->
         <!--   @if($SellerDetails->whatsapp_number!="")-->
         <!--   <a class="btn btn-soft-success btn-icon btn-circle btn-sm" href="https://api.whatsapp.com/send?phone=+91{{$SellerDetails->whatsapp_number}}" title="{{ translate('Whatsapp Now') }}" target="_blank">-->
         <!--   <i class="lab la-whatsapp"></i>-->
         <!--   </a>-->
         <!--   @endif-->
         <!--</td>-->
         <td class="text-right">
            <div class="dropdown show">
               <a class="btn btn-soft-primary btn-icon btn-circle btn-sm mybtn1" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <i class="la la-ellipsis-v" style="font-size: 20px;"></i>
               </a>
               <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    @if($SellerDetails->whatsapp_number!="")
                     <a href="https://api.whatsapp.com/send?phone=+91{{$SellerDetails->whatsapp_number}}" title="{{ translate('Whatsapp Now') }}" target="_blank" class="dropdown-item"><i class="lab la-whatsapp" style="color:lime;"></i> Whatsapp</a>
                    @endif
                  <a href="{{route('contact.edit',$leads->id)}}" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                  <a href="contact_delete/{{$leads->id}}"  class="dropdown-item"  title="{{ translate('Delete') }}"><i class="las la-trash"></i> Delete</a>
               </div>
            </div>
         </td>
      </tr>
      @endif
      @endforeach
   </tbody>
</table>
<div class="aiz-pagination">
   @if ($data2->lastPage() > 1)
   <ul class="non-modal2 pagination">
      <li class="{{ ($data2->currentPage() == 1) ? ' disabled' : '' }} page-item">
         <a class="page-link" href="{{ $data2->url(1) }}"><</a>
      </li>
      @for ($i = 1; $i <= $data2->lastPage(); $i++)
      <li class="{{ ($data2->currentPage() == $i) ? ' active' : '' }} page-item">
         <a class="page-link" href="{{ $data2->url($i) }}">{{ $i }}</a>
      </li>
      @endfor
      <li class="{{ ($data2->currentPage() == $data2->lastPage()) ? ' disabled' : '' }} page-item">
         <a class="page-link" href="{{ $data2->url($data2->currentPage()+1) }}" >></a>
      </li>
   </ul>
   @endif
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
   $("#selectAll").click(function() {
      $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
       });
   
   $("input[type=checkbox]").click(function() {
    if (!$(this).prop("checked")) {
       $("#selectAll").prop("checked", false);
       }
     });
</script>