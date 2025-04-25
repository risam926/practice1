@extends('layouts.app')

@section('title', '商品情報編集画面')

@section('content')
<h1>商品情報編集画面</h1>

<form action="{{ route('update', ['id'=>$products->id]) }}" method="POST">
  @csrf
  @method('PUT')
    <fieldset>
    <div class="form-group">
        <label for="product_name">商品名<sup class="mark">※</sup></label>
        <input type="text" class="form-control" id="product_name" name="product_name"value="{{ old('product_name') }}">
    </div>

    <div class="form-group">
     <label for="company_id">メーカー名<sup class="mark">※</sup></label>
         <select name="company_id">
         <option value="">メーカー名</option>
         @foreach($companies as $company)
         <option value="{{ $company-> id }}">{{ $company->company_name}}</option>
         @endforeach
         </select>
    </div>

    <div class="form-group">
        <label for="price">価格<sup class="mark">※</sup></label>
        <input type="text" class="form-control" id="price" name="price"value="{{ old('price') }}">
    </div>

    <div class="form-group">
        <label for="stock">在庫数<sup class="mark">※</sup></label>
        <input type="text" class="form-control" id="stock" name="stock"value="{{ old('stock') }}">
    </div>

    <div class="form-group">
        <label for="comment">コメント</label>
        <textarea class="form-control" id="comment" name="comment"value="{{ old('comment') }}"></textarea>
    </div>

    <div class="form-group">
        <label for="img_path">商品画像</label>
        <input type="file" class="form-control" id="img_path" name="img_path">
    </div> 
               
    <button type="submit" class="btn btn-success">更新</button>
    </fieldset>

</form>   
    

<a href="{{ route('detail',['id'=>$products->id])}}" class="btn btn-back">戻る</a>


   
 
@endsection