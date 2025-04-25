<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Company;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'company_id',
        'price',
        'stock',
        'commnet',
        'img_path',
    ];
    
    public function sale() {
        return $this->hasMany('App\Models\Sale');
       
    }

    public function company() {
        return $this->belongsTo('App\Models\Company');
    }

    public function getList() {
    
        $products = DB::table('products')->get();
    
        return $products;
    }
    public function registProducts($data) {
        // 登録処理
        DB::table('products')->insert([
            'product_name' => $data->product_name,
            'company_id' => $data->company_id,
            'price' => $data->price,
            'stock'=> $data->stock,
            'comment' => $data->comment,
            'img_path' => $data->img_path,
        ]);
    }



    public function updateProducts($data){
        $product = Product::find($data->id);
        $product->update([
            'product_name' => $data->product_name,
            'company_id' => $data->company_id,
            'price' => $data->price,
            'stock' => $data->stock,
            'comment' => $data->comment,
            'img_path' => $data->img_path,
        ]);

       

    }
}    
