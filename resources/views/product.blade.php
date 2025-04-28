@extends('layouts.app')

@section('title', '商品情報一覧画面')

@section('content')
<h1>商品一覧画面</h1>
<div>

  <form action="{{ route('home') }}" method="GET">

  @csrf

    <input type="text" name="keyword">
    <select name="company_id">
      <option value="">メーカー名</option>
      @foreach($companies as $company)
        <option value="{{ $company-> id }}">{{ $company->company_name}}</option>
      @endforeach
    </select>
    <input type="submit" value="検索">
  </form>
</div>


<button class="btn btn-primary" type=“button” onclick="location.href='{{route('regist')}}'">新規登録</button>


      <div class="table-responsive">
          <table class=table>
                <tr class="table-info">
                <th scope="col" >ID</th>
                  <th scope="col" >商品画像</th>
                  <th scope="col" >商品名</th>
                  <th scope="col" >価格</th>
                  <th scope="col" >在庫数</th>
                  <th scope="col" >メーカー名</th>
                  <th scope="col" ></th>
                  <th scope="col" ></th>
                </tr>
                

                @foreach($products as $product)
                <tr>
                  <td>{{$product->id}}</td>
                  <td><img src="{{asset('storage/images/'.$product->img_path)}}" width="100"></td>
                  <td>{{$product->product_name}}</td>
                  <td>{{$product->price}}</td>
                  <td>{{$product->stock}}</td>
                  <td>{{$product->company->company_name}}</td>
                  <td><a href="{{ route('detail', ['id'=>$product->id]) }}" class="btn btn-info">詳細</a></td>

                  <td>
                  <form action="{{ route('delete', ['id'=>$product->id]) }}" method="POST">
                   @csrf
                   @method('DELETE')
                   <button type="submit" class="btn btn-danger" id="deleteButton">削除</button>
                  </form>
                  </td>

                </tr>
                @endforeach
         </table>
     </div>


@endsection
