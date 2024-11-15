<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function showProduct(Request $request){
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $products = Product::all();
            $productsWithGambar = $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'stok' => $product->stok,
                    'foto' => $product->foto ? asset('storage/' . $product->foto) : null,
                ];
            });
            return response()->json([
                'success' => true,
                'product' => $productsWithGambar
            ],200);
        }
    }

    public function createProduct(Request $request){
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $product = Product::create([
                'name' => $request->name,
                'stok' => $request->stok,
            ]);
            if ($request->hasFile('foto')) {
                $filename = $request->file('foto')->storeAs('foto_produk', $request->name . '.' . $request->file('foto')->getClientOriginalExtension());
                $product->foto = $filename;
                $product->save();
            }
            return response()->json([
                'success' => true,
                'product' => $product
            ],200);
        }
    }
}
