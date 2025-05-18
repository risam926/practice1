@extends('layouts.app')

@section('title', '商品情報一覧画面')

@section('content')
<h1>商品一覧画面</h1>
<div>

  <form action="{{ route('home') }}" method="GET">

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
    

    <button type="submit" id="search-btn" data-url="{{ route('home') }}">検索</button>
  </form>
</div>


<button class="btn btn-primary" type=“button” onclick="location.href='{{route('regist')}}'">新規登録</button>


      <div class="table-responsive">
          <table class=table>
                <thead>
                <tr class="table-info">
                <th scope="col" >
                <a class="sort-link"   
                href="{{ route('home') }}"
                 data-column="id"
                 data-direction="{{ request('column') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                 data-active="{{ request('column') === 'id' ? 'true' : 'false' }}">
                ID
                @if(request('column') === 'id')
                {!! request('direction') === 'asc' ? '⬆' : '⬇' !!}
                @endif
                </a>
                </th>
                <th scope="col" >商品画像</th>
                <th scope="col" >
                <a class="sort-link" 
                 href="{{ route('home') }}"
                 data-column="product_name"
                 data-direction="{{ request('column') === 'product_name' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                 data-active="{{ request('column') === 'product_name' ? 'true' : 'false' }}">
                  商品名
                @if(request('column') === 'product_name')
                {!! request('direction') === 'asc' ? '⬆' : '⬇' !!}
                @endif
                </th>
                <th scope="col" > 
                <a class="sort-link" 
                 href="{{ route('home') }}"
                 data-column="price"
                 data-direction="{{ request('column') === 'price' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                 data-active="{{ request('column') === 'price' ? 'true' : 'false' }}">
                   価格
                  @if(request('column') === 'price')
                  {!! request('direction') === 'asc' ? '⬆' : '⬇' !!}    
                  @endif
                </a>
                </th>
                <th scope="col" > 
                <a class="sort-link" 
                 href="{{ route('home') }}"
                 data-column="stock"
                 data-direction="{{ request('column') === 'stock' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                 data-active="{{ request('column') === 'stock' ? 'true' : 'false' }}">
                   在庫数
                  @if(request('column') === 'stock')
                  {!! request('direction') === 'asc' ? '⬆' : '⬇' !!}         
                  @endif
                </a>
                </th>
                <th scope="col" >
                <a class="sort-link" 
                 href="{{ route('home') }}"
                 data-column="company_name"
                 data-direction="{{ request('column') === 'company_name' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                 data-active="{{ request('column') === 'company_name' ? 'true' : 'false' }}">
                  メーカー名 
                  @if(request('column')==='company_name')
                  {!! request('direction') === 'asc' ? '⬆' : '⬇' !!}  
                  @endif
                </th>
                <th scope="col" ></th>
                <th scope="col" ></th>
                </tr>
                </thead>

                <tbody id="products-table-body">
                @include('product_table', ['products' => $products])
                
                </tbody>
         </table>
     </div>


@endsection
