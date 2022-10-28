 <table class="table  mb-0">

            <thead>

                <tr>

                    <th># </th>

                    <th><input type="checkbox" name="check"  id="selectAll" /></th>

                  <th >Image</th>

                    <th >{{translate('Product Name')}}</th>

                  <th>Variant Name</th>

                    <th>{{translate('Total Stock')}}</th>

                    <th>{{translate('Base Price')}}</th>

                    <th>Discounted Price</th>

                    

                </tr>

            </thead>

            <tbody>

                @foreach($products as $key => $product)

                    <tr>

                        <td>{{ ($key+1) + ($products->currentPage() - 1)*$products->perPage() }}</td>

                        <td><input type="checkbox" class="save-cb-state" onclick="save_checkbox('product','{{$product->id}}')" id="product_{{$product->id}}" name="check" value="{{$product->id}}" /></td>

                      <td>

                        <img src="{{ uploaded_asset($product->thumbnail_img)}}" style="height: 100px;width: 100px;" alt="Image" >

                      </td>

                        <td>

                           {{$product->product->name}} 

                        </td>

                       <td>

                         {{ $product->variant }}

                      </td>

                        <td>

                          {{ $product->qty }}

                        </td>

                        <td>{{ $product->price }}</td>

                        

                      <td>{{home_variant_discounted_price($product->id)}}</td>

						

							

							@php

							if(isset($_GET['page']) && !empty($_GET['page'])){

							$pages=$_GET['page'];

							}else{

							$pages='';

							}

							@endphp

							

								

                     

                  	</tr>

                @endforeach

            </tbody>

        </table>

         @include('backend.pagination',['list' =>$products,'class'=>'product_index'])

         

        

         