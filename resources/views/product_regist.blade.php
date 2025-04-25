@extends('layouts.app')

@section('title', '商品新規登録画面')

@section('content')
    <div class="container">
        <div class="row">
            <h1>商品新規登録画面</h1>
            <form action="{{route('submit')}}" method="post" enctype='multipart/form-data'>
                @csrf

                <div class="form-group1">
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
                    <input type="number" class="form-control" id="price" name="price"value="{{ old('price') }}">
                </div>

                <div class="form-group">
                    <label for="stock">在庫数<sup class="mark">※</sup></label>
                    <input type="number" class="form-control" id="stock" name="stock"value="{{ old('stock') }}">
                </div>

                <div class="form-group">
                    <label for="comment">コメント</label>
                    <textarea class="form-control" id="comment" name="comment">{{ old('comment') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="img_path">商品画像</label>
                    <input type="file" class="form-control" id="img_path" name="img_path">
                </div>    
                
                <button type="submit" class="btn btn-success">登録</button>
            </form>

           
            <button class="btn btn-back" type="button" onclick="location.href='/home'">戻る</button>

        </div>
    </div>
@endsection

