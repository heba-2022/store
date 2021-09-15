<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    protected $products = [
        1 => 'Product 1',
        2 => 'Product 2',
        3 => 'Product 3',
    ];

    public function index(Request $request)
    {
        
       $products = Product::latest()->Paginate(10);;
       $categories = Category::latest()->paginate(10);

       //$categories = Category::has('products')->withCount('products')->get();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function show($id)
    {
            $products = Product::findOrFail($id);
            return view('products.show', [
                'product' => $products,
            ]);
    }

}
