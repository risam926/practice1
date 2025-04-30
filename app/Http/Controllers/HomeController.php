<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {

         /* テーブルから全てのレコードを取得する */
           $companies = Company::all();
           $sales = Sale::all();
           $products = Product::all();

        $keyword = $request->input('keyword');
        $products = Product::where('product_name', 'LIKE', '%' . $keyword . '%')->get();

        return view('product', compact('products', 'keyword','companies','sales'));
    }

    public function destroy($id)
    { 
             // トランザクション開始
    DB::beginTransaction();

    try{
        $products = Product::find($id);
        $products->delete();
        DB::commit();
    }catch (\Exception $e) {
            DB::rollback();
            return back();
    }
        
    return redirect()->route('home');
    
    }

    public function showRegistForm() {
        $companies = Company::all();    
        return view('product_regist', ['companies' => $companies]);
    }


    public function registSubmit(ProductRequest $request)
    {
        Log::debug($request->all());
    //①画像ファイルの取得
	$image = $request->file('img_path');
    if($image){
         //②画像ファイルのファイル名を取得
	$file_name = $image->getClientOriginalName();
    //③storage/app/public/imagesフォルダ内に、取得したファイル名で保存
	$image->storeAs('public/images', $file_name);
      
    }

        // トランザクション開始
    DB::beginTransaction();

    try {
        // 登録処理呼び出し
        $model = new Product();
        $model->registProducts($request);
        DB::commit();
    } catch (\Exception $e) {
        Log::error($e);
        DB::rollback();
        return back();
    }

    // 処理が完了したらregistにリダイレクト
    return redirect(route('regist'));
    }

    public function show($id)
    {
        $products = Product::find($id);

        return view('product_detail', compact('products'));
    }
    
    public function edit($id)
    {
        $products = Product::find($id);
        $companies = Company::all();

        return view('product_edit', compact('products','companies'));
    }
    
    public function update(ProductRequest $request, $id)
    {
        $products = Product::find($id);

        //①画像ファイルの取得
	    $image = $request->file('img_path');
        if($image){
        //②画像ファイルのファイル名を取得
	    $file_name = $image->getClientOriginalName();
        //③storage/app/public/imagesフォルダ内に、取得したファイル名で保存
	    $image->storeAs('public/images', $file_name);
        }
        
        // トランザクション開始
        DB::beginTransaction();

        try {
            $model = new Product();
            $model->updateProducts($request);
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();
            return back();
        }

            return redirect()->route('edit',['id' => $products->id]);
        
        }
    }


