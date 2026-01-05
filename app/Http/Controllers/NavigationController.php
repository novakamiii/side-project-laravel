<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index(Request $request)
    {
        return view('welcome');
    }

    public function productPage(Request $request)
    {
        $product = Product::where('id', $request->query('item'))->firstOrFail();
        return view('product-page', compact('product'));
    }

    public function tags(Request $request, $tag = null)   // route param inject
    {
        $tag = $tag ?? $request->query('tag', 'all');      // allow both styles

        $query = Product::query();

        if ($tag !== 'all') {
            $query->where('tag', $tag);
        }

        $products = $query->get();                         // run the query

        return view('product-by-tags', compact('products', 'tag'));
    }

    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->get();          // don’t forget this line!
        return view('product-by-tags', compact('products', 'search'));
    }


    public function shoppingCart()
    {
        return view('shopping-cart');
    }

    public function profilePage()
    {
        return view('user-profile');
    }
}
