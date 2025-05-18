<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product; 
use App\Models\Sale; 
class SalesController extends Controller
{
    public function purchase(Request $request)
{
    $data = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'required|integer|min:1'
    ]);

    $productId = $data['product_id'];
    $quantity  = $data['quantity'];

    DB::beginTransaction();

    try {
        // 商品を取得
        $product = Product::find($productId);

        if (!$product) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => '商品が存在しません'
            ], 404);
        }

        // 在庫不足の場合は、エラーレスポンスを返す
        if ($product->stock < $quantity) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => '在庫が不足しています'
            ], 400);
        }
        
        $sale = new Sale([
            'product_id' => $productId,
        ]);
       
        $sale->save();

         // 在庫を減少させる
        $product->stock -= $quantity; 
        $product->save();


        DB::commit();

        return response()->json([
            'success' => true,
            'sale'    => $sale
        ], 200);
    } catch (\Exception $e) {
        DB::rollBack();
       
        return response()->json([
            'success' => false,
            'message' => '購入処理中にエラーが発生しました'
        ], 500);
    }
}

}

