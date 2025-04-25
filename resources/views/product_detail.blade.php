@extends('layouts.app')

@section('title', '商品情報詳細画面')

@section('content')
    <div class="container">
        <div class="row">
            <h1>商品情報詳細画面</h1>
            <table class="table table-striped">
               <tr><th>ID</th><td>{{$products->id}}</td></tr>
               <tr><th>商品画像</th><td><img src="{{asset($products->img_path)}}"></td></tr>
               <tr><th>商品名</th><td>{{$products->product_name}}</td></tr>
               <tr><th>メーカー</th><td>{{$products->company->company_name}}</td></tr>
               <tr><th>価格</th><td>{{$products->price}}</td></tr>
               <tr><th>在庫数</th><td>{{$products->stock}}</td></tr>
               <tr><th>コメント</th><td>{{$products->comment}}</td></tr>
            </table>
            
            <a href="{{ route('home')}}" class="btn btn-back">戻る</a>
            <a href="{{ route('edit', ['id'=>$products->id]) }}" class="btn btn-edit">編集</a>

           
@endsection