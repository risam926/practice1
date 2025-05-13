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

        // 全データ取得
    $companies = Company::all();
    $sales = Sale::all();

    $query = Product::query();

     // ソートの対象（デフォルトはID）
     $sortColumn = $request->query('column', 'id'); 

     // ソートの方向（デフォルトは昇順）
     $sortDirection = $request->query('direction', 'asc');
 
     // 許可するカラム名を指定（不正な値の防止）
     $allowedColumns = ['id', 'price', 'stock'];
 
     if (!in_array($sortColumn, $allowedColumns)) {
         $sortColumn = 'id';
     }
 
     // データをソートして取得
     $products = $query->orderBy($sortColumn, $sortDirection)->get();

    
    return view('product', compact('products','companies', 'sales', 'sortColumn','sortDirection'));

    }

    public function search(Request $request)
    {   
    
        $keyword    = $request->input('keyword');
        $company_id = $request->input('company_id');
        $price_min  = $request->input('price_min');
        $price_max  = $request->input('price_max');
        $stock_min  = $request->input('stock_min');
        $stock_max  = $request->input('stock_max');

        
        $query = Product::query()->with('company');

        if ($keyword) {
            $query->where('product_name', 'LIKE', '%' . $keyword . '%');
        }
        if ($company_id) {
            $query->where('company_id', $company_id);
        }
        if (!is_null($price_min)) {
            $query->where('price', '>=', $price_min);
        }
        if (!is_null($price_max)) {
            $query->where('price', '<=', $price_max);
        }
        if (!is_null($stock_min)) {
            $query->where('stock', '>=', $stock_min);
        }
        if (!is_null($stock_max)) {
            $query->where('stock', '<=', $stock_max);
        }

        $products = $query->get();

        return response()->json($products);
    }
    
    

    public function destroy($id)
    { 
        // トランザクション開始
        DB::beginTransaction();
    
        try {
            $product = Product::find($id);
    
            // 商品が見つからない場合の処理
            if (!$product) {
                DB::rollback();
                return response()->json(['success' => false, 'message' => '商品が見つかりません'], 404);
            }
    
            $product->delete();
            DB::commit();
    
            return response()->json(['success' => true]); // AjaxへJSONレスポンスを送る
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => '削除中にエラーが発生しました'], 500);
        }
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
    return redirect(route('regist'))->with('success', '新規登録が完了しました！');
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

       return redirect(route('edit',['id' => $products->id]))->with('success','更新しました！');
        
    }
    }


