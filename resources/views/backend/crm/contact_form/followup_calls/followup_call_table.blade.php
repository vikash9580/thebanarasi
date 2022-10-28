<div class="col-lg-12 table-responsive">
    				<table class="table table-bordered invoice-summary">
        				<thead>
            				<tr class="bg-trans-dark">
                                <th class="min-col">#</th>
                                <th width="10%">{{translate('Last Date Contact')}}</th>
              					<th class="text-uppercase">{{translate('Next Date Contact')}}</th>
                                <th class="text-uppercase">{{translate('Next Time Contact')}}</th>
              					<th class="min-col text-center text-uppercase">{{translate('Status of Lead')}}</th>
              					<!--<th class="min-col text-center text-uppercase">{{translate('Source of Lead')}}</th>-->
              					<th class="min-col text-right text-uppercase">{{translate('Remark')}}</th>
              					<!--<th class="min-col text-right text-uppercase">{{translate('Date')}}</th>-->
            				</tr>
        				</thead>
        				<tbody>
        				   
        				    @foreach($followup_calls as $key => $followup_call)
                        <tr>
                            <td>{{ ($key+1) + ($followup_calls->currentPage() - 1)*$followup_calls->perPage() }}</td>
                            <td>{{$followup_call->last_date_of_contact}}</td>
                            <td>{{$followup_call->next_date_of_contact}}</td>
                            <td>{{$followup_call->next_time_of_contact}}</td>
                            <td>{{$followup_call->lead_status}}</td>
                            <!--<td>{{$followup_call->lead_source}}</td>-->
                            <td>{{$followup_call->remark}}</td>
                            <!--<td>{{$followup_call->date}}</td>-->
                            
                        </tr>
                        @endforeach
            </tbody>
    				</table>
    				<div class="aiz-pagination">
             @if ($followup_calls->lastPage() > 1)
<ul class="followup_call pagination">
    <li class="{{ ($followup_calls->currentPage() == 1) ? ' disabled' : '' }} page-item">
        <a class="page-link" href="{{ $followup_calls->url(1) }}"><</a>
    </li>
    @for ($i = 1; $i <= $followup_calls->lastPage(); $i++)
        <li class="{{ ($followup_calls->currentPage() == $i) ? ' active' : '' }} page-item">
            <a class="page-link" href="{{ $followup_calls->url($i) }}">{{ $i }}</a>
        </li>
    @endfor
    <li class="{{ ($followup_calls->currentPage() == $followup_calls->lastPage()) ? ' disabled' : '' }} page-item">
        <a class="page-link" href="{{ $followup_calls->url($followup_calls->currentPage()+1) }}" >></a>
    </li>
</ul>
@endif
        </div>
    			</div>