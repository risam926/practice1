@foreach($products as $product)
                <tr id="product-{{ $product->id }}">
                  <td>{{$product->id}}</td>
                  <td><img src="{{asset('storage/images/'.$product->img_path)}}" width="100"></td>
                  <td>{{$product->product_name}}</td>
                  <td>{{$product->price}}</td>
                  <td>{{$product->stock}}</td>
                  <td>{{$product->company->company_name}}</td>
                  <td><a href="{{ route('detail', ['id'=>$product->id]) }}" class="btn btn-info">詳細</a></td>

                  <td>
                  <form method="POST">
                  <meta name="csrf-token" content="{{ csrf_token() }}">
                    @csrf
                    @method('DELETE')
                  <button type="button" class="btn btn-danger delete-btn" data-id="{{ $product->id }}" data-url="{{ route('product.destroy', ['id' => $product->id]) }}">
                     削除
                  </button>
                  </form>

                </tr>
                @endforeach