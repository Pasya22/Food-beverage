<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'status','products'];

    protected $casts = [
        'products' => 'array', // Ensure products are cast to an array
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('stock', 'price');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // public static function getOrdersWithDetails()
    // {
    //     return DB::table('orders')
    //         ->join('users', 'orders.user_id', '=', 'users.id')
    //         ->join('products', 'orders.product_id', '=', 'products.id')
    //         ->select('orders.id as order_id', 'users.name as user_name', 'products.name')
    //         ->get()
    //         ->map(function ($order) {
    //             // Decode JSON products
    //             $products = json_decode($order->products, true);

    //             // Retrieve product details
    //             $order->products = DB::table('products')
    //                 ->whereIn('id', array_column($products, 'id'))
    //                 ->get()
    //                 ->map(function ($product) use ($products) {
    //                     $product->quantity = collect($products)->firstWhere('id', $product->id)['quantity'];
    //                     return $product;
    //                 });

    //             return $order;
    //         });
    // }
}
