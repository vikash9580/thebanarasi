 <div class="content">
    <!-- Start Content-->
     <div class="container-fluid">
    
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Send Notification</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">MOB</a></li>
                            <li class="breadcrumb-item active">Notifcation</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
                          <div class="card-body">

<div class="col-md-12">
                <div class="card">
                       <div class="card-body">
                         <form id="message_send" action="{{ route('notification.send') }}" method="POST">
                             @csrf
                             <input type="hidden" name="enquiry_id" value="{{request('id')}}">
                             <div class="row col-md-12">
                             <div class="form-group col-md-4">
                             <label for="title">{{translate('Message Template')}}</label>
                              <select id="message_template" class="form-control js-example-basic-single" title="Notification Template" name="notification_template"   onchange="flow_info()"  required>
                                  <option value="">Select</option>
                                   @foreach (\App\NotificationTemplet::orderBy('id','desc')->get() as $key => $notification_template)
                                     <option value="{{$notification_template->id}}">{{$notification_template->title}}</option>
                                   @endforeach
                              </select>
                             </div>
                             <div class="form-group col-md-12">
                             <label for="body">{{translate('Body')}}</label>
                             <textarea name="body" id="body" rows="5" class="form-control" readonly required></textarea>
                             </div>
                             
                             <div class="form-group col-md-8 text-right pt-30">
                             <button type="submit" onclick="data_save()" class="btn btn-info">{{translate('Send Notification')}}</button>
                             </div>
                             </div>
                        </form>
                    </div>
                </div>
              </div>
              
   </div>
        </div>
        
        </div>
 </div>            
              
              
<script>
    function flow_info(){
     var id = $('#message_template').val();
     $.ajax({
    	   type:'get',
            url:"{{route('notification_info.details')}}",
            data:{ 
                    _token:'{{ csrf_token() }}',
                    id:id
                },
                success:function(data) {
                   // console.log(data);
                 $('#body').val(data.body);
                }
        });
    }
    
    function data_save(){
        event.preventDefault();
        var formUrl = $('#message_send').attr('action');
         $.ajax({
            beforeSend: function() {
                $('#preloader').css("display", "block");
            },
            type: "POST",
            url: formUrl ,
            data:$('#message_send').serialize(),
            success: function(data) {
                $('#page_content').html(data);    
            },
            complete: function() {
               $('#preloader').css("display", "none");
            }
        });
   }
    
</script>