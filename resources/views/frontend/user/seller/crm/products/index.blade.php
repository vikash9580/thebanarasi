<style>

    .btns {

    padding: 0.25rem .52rem;

    font-size: 0.875rem;

    color: #2a3242;

    font-weight: inherit;

    margin-top: 25px;

}



.pg_no{

        margin: 10px 0px 0px 0px;

    width: 50px;

    box-shadow: 0 0 20px #0000000d;

    margin-left: 10px;

}

</style>

<div class="frm">

    <div class="col-md-12 mx-auto">

<div class="card">



		<div class="card-header row gutters-5">

			

			<div class="col-md-2 ml-auto">

			    <label>Search</label>

				<div class="input-group input-group-sm">

					<input type="text" class="form-control filter" id="search" name="search" placeholder="{{ translate('Search') }}" onkeyup="filter()">

				</div>

			</div>

           

      

           <div class="col-md-1 ml-auto">

         <div class="input-group input-group-sm ">

            <button class="btns btn-info" id="clear_selection">Clear</button>

         </div>

      </div>

                    	

		</div>



    <div class="card-body" id="product_table">

        @include('frontend.user.seller.crm.products.index_table_ajax')

        </div>

    </div>

</div>

</div>

</div>



    <script type="text/javascript">

 $("#clear_selection").click(function(){

   localStorage.clear();

   $("input[name='check']").prop("checked", false);

   $('#delete_button').attr('disabled', 'disabled');

   });

  

  

   $(document).ready(function(){

       all_checked_data();

       check_box_check();

        

   });

   

        $(document).ready(function(){

            

            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');

        });



 $(document).on('click', '.product_index a', function(event) {

        event.preventDefault();

        var page = $(this).attr('href').split('page=')[1];

        fetch_data(page);

    });



    function fetch_data(page) {

        var search = $('#search').val();

        var type=$('#type').val();

        var brand_id=$('#brand_id').val();

        var product_type=$('#product_type').val();

        var vendor='yes';

        $.ajax({

            beforeSend: function() {

                $('.ajax-loader').css("visibility", "visible");

            },

            url: "{{route('crm_seller.allproducts')}}?form_search="+vendor+"&product_type="+product_type+"&brand_id="+brand_id+"&type="+type+"&search="+search+"&page="+page,

            success: function(data) {

                

                $('#product_table').html(data);

                all_checked_data();

                check_box_check();

                  $("#selectAll").click(function() {

             

      $(".save-cb-state").prop("checked", $(this).prop("checked"));

       if (!$(this).prop("checked")) {

       $('#delete_button').attr('disabled', 'disabled');

       }

       

        if ($(this).prop("checked")) {

     $(".save-cb-state").each(function () {

          var thenum = $(this).attr("id").replace( /^\D+/g, '');

         save_checkbox('product',thenum);

     });

     }else{

     $(".save-cb-state").each(function () {

          var thenum = $(this).attr("id").replace( /^\D+/g, '');

          save_checkbox('product',thenum);

     }); 

      

   }

   

   all_checked_data();

       

       

       });

                   $(".save-cb-state").click(function() {

    if (!$(this).prop("checked")) {

       $("#selectAll").prop("checked", false);

       }

     });

              

            },

            complete: function() {

                $('.ajax-loader').css("visibility", "hidden");

            }

        });

    }





  function filter() {

      

        var search = $('#search').val();

        var type=$('#type').val();

        var brand_id=$('#brand_id').val();

        var product_type=$('#product_type').val();

         var vendor=$('#vendor').val();

       $.ajax({

         beforeSend: function() {

            $('.ajax-loader').css("visibility", "visible");

         },

           url: "/admin/admin/products/all?vendor="+vendor+"&product_type="+product_type+"&brand_id="+brand_id+"&type="+type+"&search="+search,

         success: function(data) {

             console.log(data);

             $('#product_table').html(data);

             all_checked_data();

             check_box_check();

     

               $("#selectAll").click(function() {

             

      $(".save-cb-state").prop("checked", $(this).prop("checked"));

       if (!$(this).prop("checked")) {

       $('#delete_button').attr('disabled', 'disabled');

       }

       

        if ($(this).prop("checked")) {

     $(".save-cb-state").each(function () {

          var thenum = $(this).attr("id").replace( /^\D+/g, '');

         save_checkbox('product',thenum);

     });

     }else{

     $(".save-cb-state").each(function () {

          var thenum = $(this).attr("id").replace( /^\D+/g, '');

          save_checkbox('product',thenum);

     }); 

      

   }

   

   all_checked_data();

       

       

       });

         $(".save-cb-state").click(function() {

    if (!$(this).prop("checked")) {

       $("#selectAll").prop("checked", false);

       }

     });

        },

        complete: function() {

            $('.ajax-loader').css("visibility", "hidden");

        }

      });

    }



       



   

    </script>

    

    <script>

        

        function save_checkbox(name,id){

   

   var checkbox = document.getElementById(name+'_'+id);

   

   var cart = localStorage.getItem(name);

   var pcart = JSON.parse(cart) != null ? JSON.parse(cart) : [];

   //get index of the json array where the productid is there ...

   var present_or_not = pcart.findIndex(item => item.property_id == id);

   

   if (cart == null || present_or_not == null || present_or_not == -1) {

   var product = {

   property_id: id,

   value: checkbox.checked,

   };

   pcart.push(product);

   localStorage.setItem(name, JSON.stringify(pcart));

   

   }else {

   //get the the json from index...

   var actual_stored_product = pcart[present_or_not];

   pcart.splice(present_or_not, 1); //remove the json array 

   //get the qty which was already prsnt

   

   //update the value

   actual_stored_product.value =checkbox.checked ;

   //now..we have updated value..push obj again..

   pcart.push(actual_stored_product);

   //store the json in local Storage

   localStorage.setItem(name, JSON.stringify(pcart));

   }

   

   //  let data = [];

   //  var cart = localStorage.getItem("cart");

   

   

   // if(localStorage.getItem(name)){

   //     data = JSON.parse(localStorage.getItem(name));

   // }

   

   

   // data.push({id: id,'value':checkbox.checked});

   // localStorage.setItem(name, JSON.stringify(data));

   

   

   check_box_check();
   all_checked_data();

   }

        

        

     function check_box_check(){

   var i=0;

   var j=0;

   $(".save-cb-state").each(function () {

        if($(this).prop("checked")){

            j++;

             $('#delete_button').removeAttr('disabled');

        }

        i++;

     }); 

    

     if(i==j){

         $("#selectAll").prop("checked",'true');

     }

   

   }       

        

         $("#selectAll").click(function() {

             

      $(".save-cb-state").prop("checked", $(this).prop("checked"));

       if (!$(this).prop("checked")) {

       $('#delete_button').attr('disabled', 'disabled');

       }

       

        if ($(this).prop("checked")) {

            

     $(".save-cb-state").each(function () {

          var thenum = $(this).attr("id").replace( /^\D+/g, '');

         save_checkbox('product',thenum);

     });

     }else{

     $(".save-cb-state").each(function () {

          var thenum = $(this).attr("id").replace( /^\D+/g, '');

          save_checkbox('product',thenum);

     }); 

      

   }

   

   all_checked_data();

       

       

       });

   

      $(".save-cb-state").click(function() {

    if (!$(this).prop("checked")) {

       $("#selectAll").prop("checked", false);

       }

     });

     

    

     

     

     

     

      function all_checked_data(){

   let cart = JSON.parse(localStorage.getItem("product"));

   if(cart){
      var variant_id=[];
   $.each(cart, function(key, values) {

     $("#product_"+values.property_id).prop("checked",values.value);

     if (values.value == true) {
            variant_id.push(values.property_id);
            $('#delete_button').removeAttr('disabled');

          }

       });
       varinat_product_list(variant_id);
     }

   } 

   

   

   

     

    </script>

    



