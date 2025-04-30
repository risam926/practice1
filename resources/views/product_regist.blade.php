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
                    @if($errors->has('product_name'))
                    <p>{{ $errors->first('product_name') }}</p>
                     @endif
                </div>

                <div class="form-group">
                    <label for="company_id">メーカー名<sup class="mark">※</sup></label>
                    <select name="company_id">
                    <option value="">メーカー名</option>
                    @foreach($companies as $company)
                    <option value="{{ $company-> id }}">{{ $company->company_name}}</option>
                    @endforeach
                    </select>
                    @if($errors->has('company_id'))
                    <p>{{ $errors->first('company_id') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="price">価格<sup class="mark">※</sup></label>
                    <input type="number" class="form-control" id="price" name="price"value="{{ old('price') }}">
                    @if($errors->has('price'))
                    <p>{{ $errors->first('price') }}</p>
                     @endif
                </div>

                <div class="form-group">
                    <label for="stock">在庫数<sup class="mark">※</sup></label>
                    <input type="number" class="form-control" id="stock" name="stock"value="{{ old('stock') }}">
                    @if($errors->has('stock'))
                    <p>{{ $errors->first('stock') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="comment">コメント</label>
                    <textarea class="form-control" id="comment" name="comment">{{ old('comment') }}</textarea>
                    @if($errors->has('comment'))
                    <p>{{ $errors->first('comment') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="img_path">商品画像</label>
                    <input type="file" class="form-control" id="img_path" name="img_path">
                    @if($errors->has('img_path'))
                   <p>{{ $errors->first('img_path') }}</p>
                   @endif
                </div>    
                
                <button type="submit" class="btn btn-success">登録</button>
            </form>

            <a href="{{ route('home')}}" class="btn btn-back">戻る</a>

        </div>
    </div>
@endsection

