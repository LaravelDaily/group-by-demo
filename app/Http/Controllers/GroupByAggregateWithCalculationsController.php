<?php

namespace App\Http\Controllers;

use App\Models\Product;
use DB;

class GroupByAggregateWithCalculationsController extends Controller
{
    public function __invoke()
    {
        $products = Product::query()
            ->select(['name', 'stock_quantity'])
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->addSelect(DB::raw('SUM(order_product.quantity) + products.stock_quantity as total_quantity'))
            ->groupBy('products.id')
            ->get();

        return view('examples.groupByAggregateWithCalculations', [
            'products' => $products
        ]);
    }
}
