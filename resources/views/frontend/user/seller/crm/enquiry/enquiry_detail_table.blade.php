<div class="row">
   <div class="table-responsive mb-0 table table-striped">
      <table class="table table-bordered invoice-summary">
         <thead>
            <tr class="bg-trans-dark">
               <th class="min-col">#</th>
               <th class="min-col text-right text-uppercase">{{translate('Last Date Contact')}}</th>
               <th class="text-uppercase">{{translate('Next Date Contact')}}</th>
               <th class="min-col text-center text-uppercase">{{translate('Status of Lead')}}</th>
               <th class="min-col text-right text-uppercase">{{translate('Remark')}}</th>
            </tr>
         </thead>
         <tbody>
            @foreach($list as $key => $data)
            <tr>
               <td>{{ ($key+1) + ($list->currentPage() - 1)*$list->perPage() }}</td>
               <td>{{$data->last_date_of_contact}}</td>
               <td>{{$data->next_date_of_contact}}</td>
               <td>{{$data->lead_status}}</td>
               <td>{{$data->remark}}</td>
            </tr>
            @endforeach
         </tbody>
      </table>
      
   </div>
</div>