@extends('layouts.app')

@section('title', '商品情報一覧画面')

@section('content')
<h1>商品一覧画面</h1>
<div>

  <form action="{{ route('search') }}" method="GET">

  @csrf

    <input type="text" id="keyword"  name="keyword" value="{{ request('keyword')}}"  placeholder="キーワード">
    
    <select name="company_id">
      <option value="">メーカー名</option>
      @foreach($companies as $company)
        <option value="{{ $company-> id }}">{{ $company->company_name}}</option>
      @endforeach
    </select>
   
    <label for="price">価格</label>
    <input type="number" name="price_min" id="price_min" value="{{ request('price_min') }}" placeholder="最小値">
    <input type="number" name="price_max" id="price_max" value="{{ request('price_max') }}" placeholder="最大値">
    
    <label for="stock">在庫数</label>
    <input type="number" name="stock_min" id="stock_min" value="{{ request('stock_min') }}" placeholder="最小値">
    <input type="number" name="stock_max" id="stock_max" value="{{ request('stock_max') }}" placeholder="最大値">
    

    <button type="submit" id="search-btn"data-url="{{ route('search') }}">検索</button>
  </form>
</div>


<button class="btn btn-primary" type=“button” onclick="location.href='{{route('regist')}}'">新規登録</button>


      <div class="table-responsive">
          <table class=table>
                <tr class="table-info">
                <th scope="col" > 
                <a href="{{ route('home', ['column' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                ID
                @if(request('column') === 'id')
                
                        @if(request('direction') === 'asc') ⬆ @else ⬇ @endif
                @endif
                </a>
                </th>
                <th scope="col" >商品画像</th>
                <th scope="col" >
                <a href="{{ route('home',['column' => 'product_name', 'direction' => request('direction') ==='asc' ? 'desc' : 'asc']) }}">
                  商品名
                @if(request('column') === 'product_name')
                @if(request('direction') === 'asc') ⬆ @else ⬇ @endif
                @endif
                </th>
                <th scope="col" > 
                <a href="{{ route('home', ['column' => 'price', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                   価格
                  @if(request('column') === 'price')
                        @if(request('direction') === 'asc') ⬆ @else ⬇ @endif
                  @endif
                </a>
                </th>
                <th scope="col" > 
                <a href="{{ route('home', ['column' => 'stock', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                   在庫数
                  @if(request('column') === 'stock')
                        @if(request('direction') === 'asc') ⬆ @else ⬇ @endif
                  @endif
                </a>
                </th>
                <th scope="col" >
                <a href="{{ route('home', ['column' => 'company_name', 'direction' => request('column')==='company_name' && request('direction')==='asc' ? 'desc' : 'asc']) }}">
                  メーカー名 
                  @if(request('column')==='company_name')
                  @if(request('direction')==='asc') ⬆ @else ⬇ @endif
                  @endif
                </th>
                <th scope="col" ></th>
                <th scope="col" ></th>
                </tr>
                

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
         </table>
     </div>


@endsection
