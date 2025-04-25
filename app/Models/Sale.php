<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Company;


class Sale extends Model
{
    use HasFactory;

    protected $fillable =[
        'product_id',
    
    ];

    public function products()
    {
        return $this-> belongsTo('App\Models\Product');
    }
}
